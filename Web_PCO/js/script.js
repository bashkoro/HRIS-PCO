document.addEventListener('DOMContentLoaded', function () {
    const presensiBtn = document.getElementById('presensiBtn');
    const presensiModalEl = document.getElementById('presensiModal');
    const presensiModal = new bootstrap.Modal(presensiModalEl);
    const clockInBtn = document.getElementById('clockInBtn');
    const presensiStatus = document.getElementById('presensi-status');
    const locationStatus = document.getElementById('location-status');
    const recenterBtn = document.getElementById('recenterBtn');

    let map, userMarker, officePolygon;
    const officeCoords = [
        [-6.2088, 106.8456],
        [-6.2088, 106.8466],
        [-6.2098, 106.8466],
        [-6.2098, 106.8456],
        [-6.2088, 106.8456]
    ];

    presensiBtn.addEventListener('click', function () {
        presensiModal.show();
    });

    presensiModalEl.addEventListener('shown.bs.modal', function () {
        if (map) {
            map.invalidateSize();
        }
    });

    presensiModalEl.addEventListener('show.bs.modal', function () {
        initMap();
    });

    recenterBtn.addEventListener('click', function () {
        if (map && userMarker) {
            map.setView(userMarker.getLatLng(), 16);
        }
    });

    function initMap() {
        if (!map) {
            map = L.map('map').setView([0, 0], 2);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            officePolygon = L.polygon(officeCoords, {color: 'blue'}).addTo(map);
        }

        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            map.setView([lat, lon], 16);

            if (userMarker) {
                userMarker.setLatLng([lat, lon]);
            } else {
                userMarker = L.marker([lat, lon]).addTo(map);
            }

            const userPoint = turf.point([lon, lat]);
            const poly = turf.polygon([officeCoords]);
            const isInside = turf.booleanPointInPolygon(userPoint, poly);

            if (isInside) {
                locationStatus.textContent = "You are within the office area.";
                locationStatus.style.color = 'green';
            } else {
                locationStatus.textContent = "You are outside the office area.";
                locationStatus.style.color = 'red';
            }
        }, function() {
            locationStatus.textContent = 'Could not get your location.';
        });
    }

    clockInBtn.addEventListener('click', function() {
        presensiStatus.textContent = locationStatus.textContent;
        presensiModal.hide();
    });
});