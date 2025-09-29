# HRIS-PCO Pages Documentation

## Overview
This document provides detailed information about all pages and features in the HRIS-PCO system.

---

## 🏠 Dashboard (`/dashboard`)

### **Purpose**
Main landing page providing overview of employee attendance and quick actions.

### **Features**
- **Real-time Clock**: Shows current time with automatic updates
- **Attendance Status**: Shows today's check-in/check-out status
- **Geolocation Check-in**: HTML5 Geolocation API with office radius validation
- **Interactive Map**: Leaflet.js map showing office location and user position
- **Attendance History**: Paginated table with month/year filtering
- **Statistics Cards**: Quick stats on recent attendance

### **Components**
- Check-in/Check-out modal with map
- Filter dropdown for month/year selection
- Elegant pagination (custom template)
- Responsive design with Bootstrap 5

### **Files**
- Controller: `app/Http/Controllers/DashboardController.php`
- View: `resources/views/dashboard/index.blade.php`
- Model: `app/Models/Presensi.php`

---

## 📅 Cuti (Leave Management) (`/cuti`)

### **Purpose**
Comprehensive leave application and tracking system.

### **Features**
- **Leave Application Form**: Multi-field form with validation
- **Leave Types**: Various leave categories (Annual, Sick, Personal, etc.)
- **Date Range Selection**: Start and end date picker
- **Status Tracking**: Pending, Approved, Rejected status system
- **Leave History**: Paginated table of all leave requests
- **Remaining Leave Balance**: Shows available leave days

### **Form Fields**
- Start Date (required, future dates only)
- End Date (required, must be after start date)
- Leave Type (dropdown selection)
- Reason (text area, max 1000 characters)

### **Status Colors**
- **Pending**: Yellow badge
- **Approved**: Green badge
- **Rejected**: Red badge

### **Files**
- Controller: `app/Http/Controllers/CutiController.php`
- View: `resources/views/cuti/index.blade.php`
- Model: `app/Models/Cuti.php`

---

## 💰 Hak Keuangan (Financial Rights) (`/hak-keuangan`)

### **Purpose**
Financial information management including salary details and deductions.

### **Features**
- **Period Filter**: Dropdown to filter by specific months/years
- **Search Functionality**: Search through slip gaji and status
- **Financial Breakdown**: Detailed salary, tax, and deduction information
- **Status Tracking**: Pending, Approved, Paid status system
- **Elegant Pagination**: Custom centered pagination with page info

### **Table Columns**
- **Slip Gaji**: Unique salary slip identifier
- **Periode**: Month/Year in readable format
- **Status**: Color-coded status badges
- **Hak Keuangan**: Gross salary amount (formatted currency)
- **PPH 21**: Income tax deduction (red text)
- **Iuran BPJS**: BPJS contribution (blue text)
- **Penghasilan Bersih**: Net income after deductions (green text)

### **Status Colors**
- **Pending**: Warning yellow badge
- **Approved**: Info blue badge
- **Paid**: Success green badge

### **Currency Formatting**
- Indonesian Rupiah format (Rp 1.000.000)
- Automatic thousand separators
- Color coding for different amount types

### **Files**
- Controller: `app/Http/Controllers/HakKeuanganController.php`
- View: `resources/views/hak-keuangan/index.blade.php`
- Model: `app/Models/HakKeuangan.php`
- Seeder: `database/seeders/HakKeuanganSeeder.php`

---

## 📄 Bukti Potong Pajak (Tax Documents) (`/bukti-potong-pajak`)

### **Purpose**
Tax document management with view and download capabilities.

### **Features**
- **Period Filter**: Filter by specific tax periods
- **Search Functionality**: Search through document descriptions
- **Document Availability**: Shows available/unavailable status
- **View Documents**: Modal preview for tax documents
- **Download Documents**: Direct download links for PDF files
- **Elegant Pagination**: Custom centered pagination

### **Table Columns**
- **Periode**: Tax period in readable format (e.g., "January 2024")
- **Lihat**: View button with modal popup (blue button)
- **Unduh**: Download button for PDF files (green button)
- **Keterangan**: Document description/notes

### **Document States**
- **Available**: Shows action buttons
- **Unavailable**: Shows "Tidak Tersedia" gray badges

### **Modal Features**
- Document preview placeholder
- Download from modal option
- Professional design with proper spacing

### **Files**
- Controller: `app/Http/Controllers/BuktiPotongPajakController.php`
- View: `resources/views/bukti-potong-pajak/index.blade.php`
- Model: `app/Models/BuktiPotongPajak.php`
- Seeder: `database/seeders/BuktiPotongPajakSeeder.php`

---

## 👤 Profile (`/profile`)

### **Purpose**
User profile information display.

### **Features**
- **Personal Information**: Name, email, position details
- **Work Information**: Unit kerja, status PNS, employment status
- **Leave Balance**: Current remaining leave days
- **Profile Picture**: Placeholder with user initial

### **Files**
- Controller: `app/Http/Controllers/ProfileController.php`
- View: `resources/views/profile/detail.blade.php`

---

## ⚙️ Account Settings (`/profile/edit`)

### **Purpose**
Security-focused account management (simplified from original multi-tab design).

### **Features Removed**
- Profile information editing
- Notification settings
- Privacy settings
- Account deletion

### **Features Kept**
- **Password Reset**: Change password without current password requirement
- **Two-Factor Authentication**: Enable/disable 2FA (placeholder for future implementation)

### **Design Changes**
- Single navigation item (Security Settings only)
- Beautiful green header with white text
- Simplified profile summary card (no edit button)
- Focused security interface

### **Files**
- Controller: `app/Http/Controllers/ProfileController.php`
- View: `resources/views/profile/edit.blade.php`

---

## 🎨 Custom Pagination (`resources/views/custom/pagination.blade.php`)

### **Purpose**
Elegant, centered pagination template used across all data tables.

### **Features**
- **Centered Layout**: Professional centered alignment
- **Bootstrap Icons**: Chevron navigation arrows
- **Smart Navigation**: Previous/Next with disabled states
- **Page Numbers**: Clear current page highlighting
- **Page Information**: "Showing X - Y of Z data (Page X of Y)"
- **Query Preservation**: Maintains filters and search terms

### **Design Elements**
- Primary colored active page
- Outline buttons for inactive pages
- Disabled state styling
- Responsive design
- Professional spacing

### **Usage**
Used in all paginated views:
- Dashboard attendance history
- Cuti history
- Hak Keuangan records
- Bukti Potong Pajak documents

---

## 🧭 Navigation Structure

### **Main Navigation**
1. **Dashboard**: Home page with attendance features
2. **Cuti**: Leave management system
3. **Kepegawaian**: Dropdown menu containing:
   - **Hak Keuangan**: Financial rights
   - **Bukti Potong Pajak**: Tax documents

### **User Menu**
1. **Profile**: View personal information
2. **Account Settings**: Security settings only
3. **Log Out**: Authentication logout

### **Active States**
- Navigation items highlight when active
- Dropdown items show active state
- Breadcrumb navigation on all pages

---

## 🎨 Design System

### **Color Scheme**
- **Primary**: Blue (#007bff) for main actions
- **Success**: Green for positive states, income
- **Warning**: Yellow for pending states
- **Danger**: Red for errors, deductions
- **Info**: Blue for informational states

### **Card Headers**
- **Dashboard**: Primary blue
- **Cuti**: Default styling
- **Hak Keuangan**: Primary blue
- **Bukti Potong Pajak**: Info blue
- **Security Settings**: Success green

### **Typography**
- **Primary Font**: Poppins (Google Fonts)
- **Weights**: 300, 400, 500, 600, 700
- **Icons**: Bootstrap Icons

### **Responsive Design**
- Mobile-first approach
- Bootstrap 5 grid system
- Responsive tables with horizontal scroll
- Mobile-friendly forms and buttons

---

## 🗄️ Database Schema

### **Users Table**
Extended with HRIS-specific fields:
- `nip`: Employee ID number
- `unit_kerja`: Work unit/department
- `status_pns`: Civil servant status
- `status_kepegawaian`: Employment status
- `sisa_cuti`: Remaining leave balance

### **Presensi Table**
- `user_id`: Foreign key to users
- `tanggal`: Date of attendance
- `jam_masuk`: Check-in time
- `jam_keluar`: Check-out time (nullable)
- `latitude`, `longitude`: GPS coordinates
- `status`: Attendance status

### **Cuti Table**
- `user_id`: Foreign key to users
- `tanggal_mulai`: Leave start date
- `tanggal_selesai`: Leave end date
- `jenis_cuti`: Type of leave
- `alasan`: Reason for leave
- `status`: Approval status (pending/approved/rejected)

### **Hak Keuangans Table**
- `user_id`: Foreign key to users
- `slip_gaji`: Salary slip identifier
- `periode`: Period (YYYY-MM format)
- `status`: Payment status
- `hak_keuangan`: Gross salary amount
- `pph_21`: Tax deduction
- `iuran_bpjs`: BPJS contribution
- `penghasilan_bersih`: Net income

### **Bukti Potong Pajaks Table**
- `user_id`: Foreign key to users
- `periode`: Tax period (YYYY-MM format)
- `file_path`: Path to PDF document
- `keterangan`: Document description
- `is_available`: Document availability status

---

## 🚀 Technical Implementation

### **Controllers**
All controllers follow Laravel conventions with:
- Proper dependency injection
- Request validation
- Eloquent relationships
- Pagination support
- Filter and search functionality

### **Models**
- Eloquent ORM with relationships
- Attribute casting for proper data types
- Accessor methods for formatted output
- Mass assignment protection

### **Views**
- Blade templating engine
- Component-based architecture
- Consistent layout inheritance
- Responsive Bootstrap 5 design
- JavaScript enhancements with Alpine.js

### **Routes**
- RESTful route conventions
- Middleware protection (auth, verified)
- Grouped routes for organization
- Named routes for URL generation

---

## 📱 User Experience Features

### **Search & Filter**
- Real-time search with Enter key support
- Search term highlighting in results
- Filter preservation during pagination
- Reset filter options

### **Pagination**
- Elegant centered design
- Page information display
- Query parameter preservation
- Responsive navigation

### **Feedback**
- Success/error messages
- Loading states
- Empty state illustrations
- Tooltips for additional information

### **Accessibility**
- Semantic HTML structure
- ARIA labels and roles
- Keyboard navigation support
- Screen reader friendly

---

## 🔧 Development Notes

### **Styling**
- Custom CSS in `/public/css/custom.css`
- Bootstrap 5.3 for base styling
- Custom color variables
- Responsive utilities

### **JavaScript**
- Alpine.js for reactive components
- Bootstrap JS for interactive elements
- Custom scripts for enhanced UX
- Geolocation API integration

### **Performance**
- Optimized database queries
- Proper pagination limits
- Efficient asset loading
- Minimal JavaScript dependencies

### **Security**
- CSRF protection on all forms
- Input validation and sanitization
- User-specific data filtering
- Secure file handling (for future PDF storage)

---

## 📝 Future Enhancements

### **Planned Features**
1. **PDF Generation**: Actual PDF creation for tax documents
2. **File Upload**: Document upload functionality
3. **Email Notifications**: Automated notifications for leave requests
4. **Advanced Reporting**: Detailed attendance and financial reports
5. **Mobile App**: Native mobile application
6. **Real-time Updates**: WebSocket integration for live updates

### **Technical Improvements**
1. **Caching**: Implement Redis caching for better performance
2. **Queue Jobs**: Background processing for heavy operations
3. **API**: RESTful API for mobile app integration
4. **Testing**: Comprehensive test suite
5. **Deployment**: Docker containerization and CI/CD pipeline