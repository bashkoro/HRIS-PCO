/**
 * HRIS Dashboard JavaScript
 * Handles geolocation, attendance tracking, and modal interactions
 */

class HRISMap {
    constructor() {
        this.map = null;
        this.marker = null;
        // PCO Office locations
        this.office1Location = { lat: -6.169067, lng: 106.825635 }; // Main office
        this.office2Location = { lat: -6.1751660136989335, lng: 106.8311075439858 }; // Second office
        this.officeRadius = 30; // meters
        this.currentPosition = null;
        this.presensiType = 'masuk';
        this.capturedPhoto = null;
        this.videoStream = null;
    }

    /**
     * Initialize the map
     */
    initMap(lat, lng) {
        const mapContainer = document.getElementById('mapContainer');
        const recenterBtn = document.getElementById('recenterBtn');
        if (!mapContainer) return;

        // Show map container first
        mapContainer.style.display = 'block';

        // Create map using Leaflet (Open Source alternative to Google Maps)
        this.map = L.map('mapContainer').setView([lat, lng], 16);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);

        // Add user marker
        this.marker = L.marker([lat, lng])
            .addTo(this.map)
            .bindPopup('Lokasi Anda')
            .openPopup();

        // Add office locations and radius
        // Office 1 (Main Office)
        const office1Marker = L.marker([this.office1Location.lat, this.office1Location.lng])
            .addTo(this.map)
            .bindPopup('Kantor PCO - Gedung 1');

        L.circle([this.office1Location.lat, this.office1Location.lng], {
            color: 'blue',
            fillColor: '#007bff',
            fillOpacity: 0.1,
            radius: this.officeRadius
        }).addTo(this.map);

        // Office 2 (Second Office)
        const office2Marker = L.marker([this.office2Location.lat, this.office2Location.lng])
            .addTo(this.map)
            .bindPopup('Kantor PCO - Gedung 2');

        L.circle([this.office2Location.lat, this.office2Location.lng], {
            color: 'green',
            fillColor: '#28a745',
            fillOpacity: 0.1,
            radius: this.officeRadius
        }).addTo(this.map);

        // Show recenter button
        if (recenterBtn) {
            recenterBtn.style.display = 'block';
            recenterBtn.addEventListener('click', () => {
                if (this.currentPosition) {
                    this.map.setView([this.currentPosition.lat, this.currentPosition.lng], 16);
                    if (this.marker) {
                        this.marker.openPopup();
                    }
                }
            });
        }

        // Force map to resize properly
        setTimeout(() => {
            this.map.invalidateSize();
        }, 100);
    }

    /**
     * Calculate distance between two points
     */
    calculateDistance(lat1, lng1, lat2, lng2) {
        const R = 6371000; // Earth's radius in meters
        const dLat = this.deg2rad(lat2 - lat1);
        const dLng = this.deg2rad(lng2 - lng1);

        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(this.deg2rad(lat1)) * Math.cos(this.deg2rad(lat2)) *
                  Math.sin(dLng/2) * Math.sin(dLng/2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    deg2rad(deg) {
        return deg * (Math.PI/180);
    }

    /**
     * Check if user is inside either office area
     */
    isInsideOffice(lat, lng) {
        // Check distance to both offices
        const distanceToOffice1 = this.calculateDistance(
            lat, lng,
            this.office1Location.lat, this.office1Location.lng
        );
        const distanceToOffice2 = this.calculateDistance(
            lat, lng,
            this.office2Location.lat, this.office2Location.lng
        );

        // Return true if within range of either office
        return distanceToOffice1 <= this.officeRadius || distanceToOffice2 <= this.officeRadius;
    }

    /**
     * Get the closest office information
     */
    getClosestOffice(lat, lng) {
        const distanceToOffice1 = this.calculateDistance(
            lat, lng,
            this.office1Location.lat, this.office1Location.lng
        );
        const distanceToOffice2 = this.calculateDistance(
            lat, lng,
            this.office2Location.lat, this.office2Location.lng
        );

        if (distanceToOffice1 <= distanceToOffice2) {
            return {
                name: 'Gedung 1',
                distance: distanceToOffice1,
                coordinates: this.office1Location
            };
        } else {
            return {
                name: 'Gedung 2',
                distance: distanceToOffice2,
                coordinates: this.office2Location
            };
        }
    }
}

class AttendanceManager {
    constructor() {
        this.map = new HRISMap();
        this.init();
    }

    init() {
        // Bind modal events
        const presensiModal = document.getElementById('presensiModal');
        if (presensiModal) {
            presensiModal.addEventListener('show.bs.modal', this.handleModalShow.bind(this));
            presensiModal.addEventListener('hidden.bs.modal', this.handleModalHide.bind(this));
        }

        // Bind confirm button
        const confirmBtn = document.getElementById('confirmPresensi');
        if (confirmBtn) {
            confirmBtn.addEventListener('click', this.submitAttendance.bind(this));
        }

        // Bind camera buttons
        this.initCameraButtons();

        // Update time every second
        this.updateCurrentTime();
        setInterval(() => this.updateCurrentTime(), 1000);
    }

    handleModalShow(event) {
        const button = event.relatedTarget;
        const type = button.getAttribute('data-type');
        this.map.presensiType = type;

        // Update modal title
        const typeSpan = document.getElementById('presensiType');
        if (typeSpan) {
            typeSpan.textContent = type === 'masuk' ? 'Masuk' : 'Pulang';
        }

        // Reset modal state
        this.resetModal();

        // Get user location after a small delay to ensure modal is fully shown
        setTimeout(() => {
            this.getCurrentLocation();
        }, 300);
    }

    handleModalHide() {
        // Clean up map
        if (this.map.map) {
            this.map.map.remove();
            this.map.map = null;
        }

        // Hide recenter button
        const recenterBtn = document.getElementById('recenterBtn');
        if (recenterBtn) {
            recenterBtn.style.display = 'none';
        }

        this.resetModal();
    }

    resetModal() {
        const elements = {
            locationStatus: document.getElementById('locationStatus'),
            mapContainer: document.getElementById('mapContainer'),
            locationInfo: document.getElementById('locationInfo'),
            outsideOfficeWarning: document.getElementById('outsideOfficeWarning'),
            confirmPresensi: document.getElementById('confirmPresensi')
        };

        elements.locationStatus.className = 'alert alert-info';
        elements.locationStatus.innerHTML = `
            <div class="d-flex align-items-center">
                <div class="spinner-custom me-3"></div>
                <span>Mendapatkan lokasi Anda...</span>
            </div>
        `;

        elements.mapContainer.style.display = 'none';
        elements.locationInfo.style.display = 'none';
        elements.outsideOfficeWarning.style.display = 'none';
        elements.confirmPresensi.disabled = true;

        // Reset camera elements
        const cameraSection = document.getElementById('cameraSection');
        const photoPreview = document.getElementById('photoPreview');
        if (cameraSection) cameraSection.style.display = 'none';
        if (photoPreview) photoPreview.style.display = 'none';

        // Stop camera if running
        if (this.map.videoStream) {
            this.map.videoStream.getTracks().forEach(track => track.stop());
            this.map.videoStream = null;
        }

        this.map.currentPosition = null;
        this.map.capturedPhoto = null;
    }

    getCurrentLocation() {
        if (!navigator.geolocation) {
            this.showLocationError('Geolocation tidak didukung oleh browser ini');
            return;
        }

        const options = {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 60000
        };

        navigator.geolocation.getCurrentPosition(
            this.handleLocationSuccess.bind(this),
            this.handleLocationError.bind(this),
            options
        );
    }

    handleLocationSuccess(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        this.map.currentPosition = { lat, lng };

        // Update location status
        const locationStatus = document.getElementById('locationStatus');
        locationStatus.className = 'alert alert-success';
        locationStatus.innerHTML = `
            <i class="bi bi-check-circle me-2"></i>
            Lokasi berhasil diperoleh
        `;

        // Initialize map
        this.loadMapScript(() => {
            this.map.initMap(lat, lng);
            // Additional map resize after initialization
            setTimeout(() => {
                if (this.map.map) {
                    this.map.map.invalidateSize();
                }
            }, 200);
        });

        // Update location info
        this.updateLocationInfo(lat, lng);

        // Check office status
        const isInside = this.map.isInsideOffice(lat, lng);
        const closestOffice = this.map.getClosestOffice(lat, lng);
        this.updateOfficeStatus(isInside, closestOffice);

        // Enable confirm button only if inside office or photo taken
        const confirmBtn = document.getElementById('confirmPresensi');
        if (isInside || this.map.capturedPhoto) {
            confirmBtn.disabled = false;
        } else {
            confirmBtn.disabled = true;
        }
    }

    handleLocationError(error) {
        let message = 'Tidak dapat memperoleh lokasi';

        switch(error.code) {
            case error.PERMISSION_DENIED:
                message = 'Akses lokasi ditolak. Mohon berikan izin akses lokasi.';
                break;
            case error.POSITION_UNAVAILABLE:
                message = 'Informasi lokasi tidak tersedia.';
                break;
            case error.TIMEOUT:
                message = 'Waktu permintaan lokasi habis.';
                break;
        }

        this.showLocationError(message);
    }

    showLocationError(message) {
        const locationStatus = document.getElementById('locationStatus');
        locationStatus.className = 'alert alert-danger';
        locationStatus.innerHTML = `
            <i class="bi bi-exclamation-triangle me-2"></i>
            ${message}
            <br><small>Silakan refresh halaman dan coba lagi.</small>
        `;
    }

    updateLocationInfo(lat, lng) {
        document.getElementById('currentLat').textContent = lat.toFixed(6);
        document.getElementById('currentLng').textContent = lng.toFixed(6);
        document.getElementById('locationInfo').style.display = 'block';
    }

    updateOfficeStatus(isInside, closestOffice) {
        const statusBadge = document.getElementById('officeStatus');
        const warning = document.getElementById('outsideOfficeWarning');
        const confirmBtn = document.getElementById('confirmPresensi');

        if (isInside) {
            statusBadge.className = 'badge bg-success';
            statusBadge.innerHTML = `<i class="bi bi-check-circle me-1"></i>Di dalam kantor (${closestOffice.name})`;
            warning.style.display = 'none';
            if (confirmBtn) confirmBtn.disabled = false;
        } else {
            statusBadge.className = 'badge bg-warning text-dark';
            statusBadge.innerHTML = `<i class="bi bi-exclamation-triangle me-1"></i>Di luar kantor (Terdekat: ${closestOffice.name} - ${Math.round(closestOffice.distance)}m)`;
            warning.style.display = 'block';
            // Disable confirm button until photo is taken
            if (confirmBtn) confirmBtn.disabled = true;
        }
    }

    updateCurrentTime() {
        const timeElement = document.getElementById('currentTime');
        if (timeElement) {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            timeElement.textContent = timeString;
        }
    }

    loadMapScript(callback) {
        // Check if Leaflet is already loaded
        if (typeof L !== 'undefined') {
            callback();
            return;
        }

        // Load Leaflet CSS
        if (!document.querySelector('link[href*="leaflet"]')) {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css';
            document.head.appendChild(link);
        }

        // Load Leaflet JS
        if (!document.querySelector('script[src*="leaflet"]')) {
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js';
            script.onload = callback;
            document.head.appendChild(script);
        } else {
            callback();
        }
    }

    async submitAttendance() {
        if (!this.map.currentPosition) {
            alert('Lokasi belum tersedia');
            return;
        }

        const confirmBtn = document.getElementById('confirmPresensi');
        const originalText = confirmBtn.innerHTML;

        // Show loading
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<div class="spinner-custom me-2"></div>Memproses...';

        try {
            const formData = new FormData();
            formData.append('latitude', this.map.currentPosition.lat);
            formData.append('longitude', this.map.currentPosition.lng);
            formData.append('type', this.map.presensiType);

            // Add office information
            const closestOffice = this.map.getClosestOffice(this.map.currentPosition.lat, this.map.currentPosition.lng);
            formData.append('office_building', closestOffice.name);

            // Add photo if captured (for outside office attendance)
            if (this.map.capturedPhoto) {
                formData.append('attendance_photo', this.map.capturedPhoto, 'attendance.jpg');
            }

            const response = await fetch('/presensi', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                // Show success message
                this.showAlert('success', result.message);

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('presensiModal'));
                modal.hide();

                // Reload page to update attendance status
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                this.showAlert('danger', result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            this.showAlert('danger', 'Terjadi kesalahan saat memproses presensi');
        } finally {
            // Reset button
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = originalText;
        }
    }

    showAlert(type, message) {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;

        // Insert alert at the top of the container
        const container = document.querySelector('.container-fluid');
        container.insertAdjacentHTML('afterbegin', alertHtml);

        // Auto remove after 5 seconds
        setTimeout(() => {
            const alert = container.querySelector('.alert');
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    }

    initCameraButtons() {
        const cameraBtn = document.getElementById('cameraBtn');
        const captureBtn = document.getElementById('captureBtn');
        const cancelCameraBtn = document.getElementById('cancelCameraBtn');
        const retakeBtn = document.getElementById('retakeBtn');

        if (cameraBtn) {
            cameraBtn.addEventListener('click', this.startCamera.bind(this));
        }

        if (captureBtn) {
            captureBtn.addEventListener('click', this.capturePhoto.bind(this));
        }

        if (cancelCameraBtn) {
            cancelCameraBtn.addEventListener('click', this.stopCamera.bind(this));
        }

        if (retakeBtn) {
            retakeBtn.addEventListener('click', this.retakePhoto.bind(this));
        }
    }

    async startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({
                video: { facingMode: 'user' },
                audio: false
            });

            const video = document.getElementById('cameraVideo');
            const cameraSection = document.getElementById('cameraSection');

            this.map.videoStream = stream;
            video.srcObject = stream;
            cameraSection.style.display = 'block';

        } catch (error) {
            console.error('Error accessing camera:', error);
            this.showAlert('danger', 'Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
        }
    }

    capturePhoto() {
        const video = document.getElementById('cameraVideo');
        const canvas = document.getElementById('cameraCanvas');
        const context = canvas.getContext('2d');

        // Set canvas size to video size
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        // Draw video frame to canvas
        context.drawImage(video, 0, 0);

        // Convert canvas to blob
        canvas.toBlob((blob) => {
            this.map.capturedPhoto = blob;
            this.showPhotoPreview(canvas.toDataURL());
            this.stopCamera();

            // Enable confirm button
            const confirmBtn = document.getElementById('confirmPresensi');
            if (confirmBtn) confirmBtn.disabled = false;
        }, 'image/jpeg', 0.8);
    }

    stopCamera() {
        if (this.map.videoStream) {
            this.map.videoStream.getTracks().forEach(track => track.stop());
            this.map.videoStream = null;
        }

        const cameraSection = document.getElementById('cameraSection');
        if (cameraSection) cameraSection.style.display = 'none';
    }

    showPhotoPreview(dataUrl) {
        const photoPreview = document.getElementById('photoPreview');
        const previewImage = document.getElementById('previewImage');

        if (previewImage) previewImage.src = dataUrl;
        if (photoPreview) photoPreview.style.display = 'block';
    }

    retakePhoto() {
        const photoPreview = document.getElementById('photoPreview');
        if (photoPreview) photoPreview.style.display = 'none';

        this.map.capturedPhoto = null;

        // Disable confirm button until new photo is taken
        const confirmBtn = document.getElementById('confirmPresensi');
        const isInside = this.map.isInsideOffice(
            this.map.currentPosition.lat,
            this.map.currentPosition.lng
        );

        if (confirmBtn && !isInside) {
            confirmBtn.disabled = true;
        }

        this.startCamera();
    }
}

// Utility functions for other components
class HRISUtilities {
    static formatTime(timeString) {
        if (!timeString) return '-';
        return timeString.substring(0, 5); // HH:MM
    }

    static formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    static calculateWorkingHours(startTime, endTime) {
        if (!startTime || !endTime) return 0;

        const start = new Date(`2000-01-01 ${startTime}`);
        const end = new Date(`2000-01-01 ${endTime}`);

        const diff = end - start;
        return Math.round((diff / (1000 * 60 * 60)) * 10) / 10; // Round to 1 decimal
    }

    static showConfirmDialog(message, callback) {
        if (confirm(message)) {
            callback();
        }
    }

    static showToast(message, type = 'info') {
        // Simple toast implementation
        const toastHtml = `
            <div class="toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'primary'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

        // Create toast container if it doesn't exist
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        const toastElement = toastContainer.lastElementChild;
        const toast = new bootstrap.Toast(toastElement);
        toast.show();

        // Remove toast element after it's hidden
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastElement.remove();
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize attendance manager if on dashboard page
    if (document.getElementById('presensiModal')) {
        new AttendanceManager();
    }

    // Add fade-in animation to cards
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('fade-in');
        }, index * 100);
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Make utilities available globally
window.HRIS = {
    AttendanceManager,
    HRISMap,
    HRISUtilities
};