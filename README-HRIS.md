# HRIS - Human Resource Information System

A complete HRIS web application built with Laravel, Bootstrap, and JavaScript featuring attendance tracking, leave management, and employee information management.

## 🚀 Features

### Authentication & Authorization
- Laravel Breeze authentication system
- Secure login/logout functionality
- Password reset capability

### Dashboard
- Real-time attendance tracking with geolocation
- Employee information display
- Leave balance overview
- Attendance history with filtering
- Responsive design for all devices

### Attendance System (Presensi)
- **Geolocation-based attendance**: Uses HTML5 Geolocation API
- **Interactive mapping**: Leaflet.js integration for location visualization
- **Office boundary checking**: Automatic detection of inside/outside office area
- **Real-time validation**: Prevents duplicate attendance entries
- **Working hours calculation**: Automatic calculation of total working hours
- **Late/early leave tracking**: Tracks punctuality automatically

### Leave Management (Cuti)
- Leave application system
- Multiple leave types (Annual, Sick, Maternity, etc.)
- Leave balance tracking
- Status management (Pending/Approved/Rejected)
- Leave history with pagination

### User Interface
- Modern Bootstrap 5 design
- Custom color palette matching corporate identity
- Responsive design for mobile and desktop
- Interactive modals and components
- Real-time form validation

## 🛠️ Technical Stack

- **Backend**: PHP Laravel 12
- **Frontend**: Bootstrap 5.3, HTML5, CSS3, JavaScript
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze
- **Mapping**: Leaflet.js (Open Source)
- **Icons**: Bootstrap Icons
- **Fonts**: Google Fonts (Poppins)

## 📋 Installation & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- SQLite (included) or MySQL

### Installation Steps

1. **Clone the repository** (if from git) or navigate to the project directory:
   ```bash
   cd /Applications/XAMPP/xamppfiles/htdocs/HRIS-PCO
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**:
   ```bash
   npm install
   ```

4. **Set up environment variables**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database** (already configured for SQLite):
   - The application uses SQLite by default
   - Database file: `database/database.sqlite`

6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **Seed test data**:
   ```bash
   php artisan db:seed --class=HRISSeeder
   ```

8. **Build frontend assets**:
   ```bash
   npm run build
   ```

9. **Start the development server**:
   ```bash
   php artisan serve
   ```

10. **Access the application**:
    - URL: http://localhost:8000
    - The app will redirect to login page

## 👥 Test Accounts

After running the seeder, you can use these test accounts:

### Administrator
- **Email**: admin@hris-pco.com
- **Password**: password123
- **Role**: Administrator
- **Unit**: IT Department

### Employee 1
- **Email**: john@hris-pco.com
- **Password**: password123
- **Role**: Employee
- **Unit**: Human Resources

### Employee 2
- **Email**: jane@hris-pco.com
- **Password**: password123
- **Role**: Employee
- **Unit**: Finance

## 🎨 Design & UI

### Color Palette
- **Primary**: #1E3A8A (Deep Blue)
- **Primary Darker**: #1c347d
- **Light Primary**: #3B82F6
- **Accent Yellow**: #FBBF24
- **Accent Red**: #DC2626
- **Background**: #f0f2f5
- **Card Background**: #FFFFFF

### Typography
- **Font Family**: Poppins (Google Fonts)
- **Font Weights**: 300, 400, 500, 600, 700

## 📱 Usage Guide

### Login
1. Navigate to the application URL
2. Enter your email and password
3. Click "Login" to access the dashboard

### Dashboard
- **Attendance Card**: Shows today's attendance status
  - Click "Presensi Masuk" to clock in
  - Click "Presensi Pulang" to clock out
- **Leave Card**: Displays remaining leave days
- **Employee Info Card**: Shows personal employment details
- **Attendance History Table**: View past attendance records with filtering

### Attendance Process
1. Click "Presensi Masuk" or "Presensi Pulang" button
2. Allow location access when prompted
3. Wait for location to be detected
4. View your location on the interactive map
5. Check office status (inside/outside office area)
6. Click "Konfirmasi Presensi" to submit

### Leave Management
1. Navigate to "Cuti" in the main menu
2. Click "Ajukan Cuti" to request leave
3. Fill in the leave form:
   - Select leave type
   - Choose start and end dates
   - Enter reason for leave
4. Submit the application
5. View leave history and status in the table

## 🔧 Configuration

### Office Location
Update office coordinates in `/public/js/dashboard.js`:
```javascript
this.officeLocation = { lat: -6.200000, lng: 106.816666 }; // Your office coordinates
this.officeRadius = 100; // Office radius in meters
```

### Working Hours
Modify working hours in `/app/Http/Controllers/PresensiController.php`:
```php
$attendance->is_late = $now->format('H:i:s') > '08:00:00'; // Start time
$attendance->is_early_leave = $now->format('H:i:s') < '17:00:00'; // End time
```

## 📁 Project Structure

```
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php    # Dashboard logic
│   │   ├── PresensiController.php     # Attendance management
│   │   └── CutiController.php         # Leave management
│   └── Models/
│       ├── User.php                   # Extended user model
│       ├── Presensi.php              # Attendance model
│       └── Cuti.php                  # Leave model
├── database/
│   ├── migrations/                    # Database schema
│   └── seeders/HRISSeeder.php        # Test data
├── resources/views/
│   ├── layouts/hris.blade.php        # Main layout
│   ├── dashboard/index.blade.php     # Dashboard view
│   └── cuti/index.blade.php          # Leave management view
├── public/
│   ├── css/custom.css                # Custom styles
│   └── js/dashboard.js               # Frontend functionality
└── routes/web.php                    # Application routes
```

## 🌟 Key Features Explained

### Geolocation Attendance
- Uses HTML5 Geolocation API for precise location tracking
- Leaflet.js provides interactive mapping
- Haversine formula calculates distance from office
- Automatic office boundary detection

### Security Features
- CSRF protection on all forms
- Laravel's built-in authentication
- Input validation and sanitization
- SQL injection prevention through Eloquent ORM

### Responsive Design
- Mobile-first approach
- Bootstrap 5 grid system
- Touch-friendly interfaces
- Optimized for various screen sizes

### Real-time Features
- Live clock display in attendance modal
- Dynamic form validation
- Automatic duration calculation
- Interactive status updates

## 🚧 Development Notes

### Database Schema
- **Users**: Extended with HRIS fields (unit_kerja, status_pns, etc.)
- **Presensi**: Attendance records with geolocation data
- **Cuti**: Leave requests with approval workflow

### API Endpoints
- `POST /presensi`: Submit attendance
- `GET /dashboard`: Dashboard data
- `GET /cuti`: Leave management page
- `POST /cuti`: Submit leave request

### JavaScript Architecture
- Modular class-based structure
- `HRISMap`: Map management
- `AttendanceManager`: Attendance functionality
- `HRISUtilities`: Utility functions

## 📞 Support & Maintenance

### Troubleshooting
- **Location not working**: Ensure HTTPS or localhost
- **Map not loading**: Check internet connection
- **Attendance not saving**: Check console for errors

### Logs
- Laravel logs: `storage/logs/laravel.log`
- Browser console for JavaScript errors

## 🔮 Future Enhancements

- [ ] Mobile app (React Native/Flutter)
- [ ] Push notifications
- [ ] Report generation (PDF/Excel)
- [ ] Advanced role management
- [ ] Integration with payroll systems
- [ ] Facial recognition attendance
- [ ] QR code check-in/out
- [ ] Advanced analytics dashboard

---

**HRIS PCO** - Human Resource Information System
Built with ❤️ using Laravel & Bootstrap