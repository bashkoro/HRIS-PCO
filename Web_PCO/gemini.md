# Project Gemini Documentation

This document provides a comprehensive overview of the Web_PCO project, a Human Resource Information System (HRIS) designed for the Presidential Communication Office.

## Project Structure

The project is organized into the following directories and files:

```
/Users/bashkoro/Downloads/Magang/PCO/Web_PCO/
├───.DS_Store
├───account_setting.html
├───cuti.html
├───index.html
├───kepegawaian_bukti_potong_pajak.html
├───kepegawaian_hak_keuangan.html
├───profil.html
├───css/
│   └───style.css
├───img/
│   ├───FA-Logo-PCO_Horizontal-Emas-Putih.png
│   ├───Logo_Kantor_Komunikasi_Kepresidenan.png
│   ├───Logo_of_Presidential_Communication_Office_(Indonesia)_(2024).svg
│   └───logo.png
└───js/
    └───script.js
```

### HTML Files

- **`index.html`**: The main dashboard of the HRIS. It displays key information such as attendance, leave information, and employee details. It also includes a history of attendance.
- **`account_setting.html`**: Allows users to manage their account settings.
- **`cuti.html`**: Handles leave requests and displays leave-related information.
- **`kepegawaian_bukti_potong_pajak.html`**: Displays tax withholding evidence.
- **`kepegawaian_hak_keuangan.html`**: Provides information about financial rights.
- **`profil.html`**: Displays the user's complete profile information, including personal data, address, and employment details.

### CSS File

- **`css/style.css`**: Contains the styles for the entire web application. It defines the color palette, fonts, and styles for various components like the navbar, buttons, cards, and tables.

### JavaScript File

- **`js/script.js`**:  This file contains the client-side logic for the application. It handles:
    - **Attendance:**  The script uses the Geolocation API to get the user's location and allows them to "clock in". It checks if the user is within a predefined office area.
    - **Modal Interaction:** It manages the attendance modal.

### Image Files

The `img` directory contains logos and other images used in the application.

## Key Features

- **Dashboard:**  A central hub for employees to view their information.
- **Attendance:**  Allows employees to clock in and out, with location validation.
- **Leave Management:**  Provides a system for requesting and tracking leave.
- **Employee Information:**  A comprehensive view of employee data.
- **Financial Information:**  Access to financial rights and tax documents.

## How to Run the Project

This is a static web project. To run it, you can simply open the `index.html` file in a web browser. For the attendance feature to work, you will need to allow location access.
