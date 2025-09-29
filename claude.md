# HRIS-PCO Project - Claude.md

## Project Overview
HRIS-PCO is a Human Resource Information System built with Laravel 12 and modern web technologies. This project includes attendance tracking with geolocation, leave management, and employee information management.

## Technology Stack
- **Backend**: PHP 8.2+ with Laravel 12
- **Frontend**: Bootstrap 5.3, Alpine.js, Tailwind CSS
- **Database**: SQLite (configured) / MySQL support
- **Authentication**: Laravel Breeze
- **Build Tools**: Vite, NPM
- **Mapping**: Leaflet.js for geolocation features

## Project Structure
```
HRIS-PCO/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── PresensiController.php
│   │   ├── CutiController.php
│   │   ├── ProfileController.php
│   │   ├── HakKeuanganController.php
│   │   └── BuktiPotongPajakController.php
│   ├── Models/
│   │   ├── User.php (extended with HRIS fields)
│   │   ├── Presensi.php
│   │   ├── Cuti.php
│   │   ├── HakKeuangan.php
│   │   └── BuktiPotongPajak.php
│   └── View/Components/
├── database/
│   ├── migrations/ (includes HRIS-specific tables)
│   ├── seeders/
│   │   ├── HRISSeeder.php
│   │   ├── HakKeuanganSeeder.php
│   │   └── BuktiPotongPajakSeeder.php
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── dashboard/
│   │   ├── cuti/
│   │   ├── profile/
│   │   ├── hak-keuangan/
│   │   ├── bukti-potong-pajak/
│   │   ├── custom/ (pagination templates)
│   │   └── layouts/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   ├── auth.php
│   └── console.php
├── public/
│   ├── css/
│   ├── js/
│   └── img/
└── config/ (Laravel configuration files)
```

## Key Features
1. **Authentication System**: Laravel Breeze implementation with security-focused account settings
2. **Geolocation-based Attendance**: HTML5 Geolocation API with Leaflet.js
3. **Leave Management**: Comprehensive leave application and tracking with pagination
4. **Dashboard**: Real-time attendance tracking and employee information
5. **Financial Management**: Hak Keuangan (Financial Rights) tracking with detailed salary information
6. **Tax Documents**: Bukti Potong Pajak management with view and download functionality
7. **Custom Pagination**: Elegant, centered pagination across all data tables
8. **Responsive Design**: Bootstrap 5 with custom styling and modern UI components

## Development Commands

### Setup Commands
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed --class=HRISSeeder
php artisan db:seed --class=HakKeuanganSeeder
php artisan db:seed --class=BuktiPotongPajakSeeder

# Build frontend assets
npm run build
# OR for development
npm run dev

# Start development server
php artisan serve
```

### Development Commands
```bash
# Start development environment (runs server, queue, logs, and vite)
composer run dev

# Run tests
composer run test
# OR
php artisan test

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Build for production
npm run build
```

### Database Commands
```bash
# Run migrations
php artisan migrate

# Refresh database with seeding
php artisan migrate:refresh --seed

# Create new migration
php artisan make:migration create_table_name

# Create new seeder
php artisan make:seeder SeederName
```

## Configuration

### Environment Variables (.env)
- **Database**: Currently configured for SQLite (`DB_CONNECTION=sqlite`)
- **App URL**: `http://localhost` (change as needed)
- **Debug Mode**: Enabled for development (`APP_DEBUG=true`)
- **Queue**: Database driver configured
- **Mail**: Log driver (for development)

### Important Configurations
- **Office Location**: Configure in `/public/js/dashboard.js`
- **Working Hours**: Set in `PresensiController.php`
- **Geolocation Settings**: Modify office radius and coordinates as needed

## Database Schema

### Main Tables
- **users**: Extended with HRIS fields (nip, unit_kerja, status_pns, etc.)
- **presensi**: Attendance records with geolocation data
- **cuti**: Leave requests with approval workflow
- **hak_keuangans**: Financial rights records with salary, tax, and benefits data
- **bukti_potong_pajaks**: Tax cut evidence documents with file management
- **jobs**: Laravel queue jobs
- **cache**: Laravel caching system

## Test Accounts
After running `HRISSeeder`:
- **Admin**: admin@hris-pco.com / password123
- **Employee 1**: john@hris-pco.com / password123
- **Employee 2**: jane@hris-pco.com / password123

## API Endpoints
- `GET /dashboard`: Dashboard view and data with attendance history pagination
- `POST /presensi`: Submit attendance record
- `GET /cuti`: Leave management page with pagination
- `POST /cuti`: Submit leave request
- `GET /hak-keuangan`: Financial rights page with filtering and pagination
- `GET /bukti-potong-pajak`: Tax documents page with view/download functionality
- `GET /bukti-potong-pajak/{id}/view`: View tax document
- `GET /bukti-potong-pajak/{id}/download`: Download tax document
- `GET /profile`: User profile management
- `GET /profile/edit`: Account settings (security-focused)

## Frontend Architecture
- **Alpine.js**: For reactive components
- **Bootstrap 5**: UI framework with custom HRIS styling
- **Leaflet.js**: Interactive mapping for attendance
- **Vite**: Modern build tool for asset compilation

## Security Features
- CSRF protection on all forms
- Laravel Sanctum for API authentication
- Input validation and sanitization
- SQL injection prevention via Eloquent ORM
- Secure password hashing with bcrypt

## Development Notes
- Uses SQLite for development (database/database.sqlite)
- Geolocation requires HTTPS or localhost for browser security
- Map functionality depends on internet connection
- Modular JavaScript architecture with class-based components

## Troubleshooting
- **Location not working**: Ensure HTTPS or localhost environment
- **Map not loading**: Check internet connection and console errors
- **Attendance not saving**: Check Laravel logs and browser console
- **Asset compilation issues**: Run `npm run build` or `npm run dev`

## Related Files
- Main documentation: `README-HRIS.md`
- Layout changes: `LAYOUT_CHANGES.md`
- Carbon fix: `CARBON_ERROR_FIX.md`
- Pages documentation: `pages_documentation.md`

## Notes for Claude
- This is a XAMPP-hosted Laravel project
- SQLite database is pre-configured
- Use `composer run dev` for full development environment
- Check Laravel logs at `storage/logs/laravel.log`
- Frontend assets are built with Vite (not Laravel Mix)