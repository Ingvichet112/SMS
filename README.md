# 🎓 Student Management System (SMS)

A premium, modern, and feature-rich **Student Management System (SMS)** built with **Laravel 12**, **React 19**, **Tailwind CSS v4**, and **Bootstrap 5**. Designed with a focus on stunning aesthetics, smooth micro-interactions, responsive dashboards, and robust reporting, this application provides an all-in-one portal for Administrators, Teachers, and Students.

It also fully supports **Khmer Unicode** (using mPDF with Hanuman and Noto Sans Khmer fonts) for printing and exporting beautiful academic documents.

---

## 🌟 Key Features

### 🔐 1. Unified Authentication & Access Control
*   **Dynamic Login Gate:** A modern unified login screen (`/login`) featuring a beautiful particle effect canvas background.
*   **Role-Based Routing:** Automatically redirects users to their dedicated dashboard based on their role (`admin`, `teacher`, or `student`).
*   **Self-Service Password Management:** Features an easy password reset flow for guests and a secure "Change Password" portal for logged-in accounts.

### 🏢 2. Admin & Staff Back-Office Portal
*   **Full CRUD Management:** Maintain comprehensive profiles for Students, Teachers, School Classes, and Courses.
*   **Billing & Payment Tracking:** Record invoices, mark students as paid/unpaid, view detailed transaction logs, and generate receipts.
*   **Academic Export Tools:** Export student registers and receipts to **PDF** (custom Khmer font rendering) or **Excel** spreadsheets with a single click.

### 👨‍🏫 3. Teacher Dashboard
*   **Smart Attendance Logger:** Record daily student attendance and export lists to PDF or Excel.
*   **Grade Book:** Input and update subject marks/grades for students instantly.
*   **Exam Scheduler:** Set up, modify, or delete exam timetables for individual classes.

### 🎒 4. Student Portal
*   **Interactive Dashboard:** Access progress summaries, active subjects, and class schedules via a sleek, modern UI.
*   **Timetables:** View upcoming exam schedules and subject lists.
*   **Financial Hub:** Track tuition status, pay fees online, and download premium PDF payment receipts directly to your device.

---

## 🛠️ Tech Stack

*   **Backend:** PHP >= 8.2, Laravel 12 (MVC Architecture)
*   **Frontend:** React 19, Tailwind CSS v4, Bootstrap 5, Sass
*   **Build Tool:** Vite 6
*   **PDF Engine:** mPDF (custom-configured with Noto Sans Khmer & Hanuman fonts)
*   **Excel Engine:** Maatwebsite Excel 3.1
*   **Database:** MySQL / MariaDB

---

## 🚀 Installation & Setup

Follow these steps to clone, configure, and launch the Student Management System locally:

### 📋 Prerequisites
Ensure you have the following installed on your local machine:
*   **PHP** (>= 8.2)
*   **Composer**
*   **Node.js** (includes npm)
*   **MySQL** or **MariaDB** server

---

### Step 1: Clone the Repository
Clone the repository from GitHub and navigate into the project directory:
```bash
git clone https://github.com/Ingvichet112/SMS.git
cd SMS
```

### Step 2: Install Dependencies
Run Composer to install all backend dependencies:
```bash
composer install
```

Run npm to install all frontend UI packages:
```bash
npm install
```

### Step 3: Setup Environment Configuration
1.  Copy the example environment file to create your active `.env`:
    ```bash
    cp .env.example .env
    ```
2.  Generate a secure application security key:
    ```bash
    php artisan key:generate
    ```

### Step 4: Configure the Database
1.  Open your MySQL management tool (e.g., phpMyAdmin, TablePlus, or CLI) and create a new empty database:
    ```sql
    CREATE DATABASE student_management_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
    ```
2.  Open the `.env` file in your code editor and update the database credentials to match your server connection:
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=student_management_db
    DB_USERNAME=root
    DB_PASSWORD=your_mysql_password
    ```

### Step 5: Migrate and Seed Database
Run the database migrations to create the tables, and seed it with realistic Khmer mock data (Admin, Teachers, Classes, Students, Payments):
```bash
php artisan migrate --seed
```

### Step 6: Start the Application
You can run the PHP server, queue listener, logs observer, and Vite dev server **simultaneously** using the custom development script:
```bash
composer run dev
```

Alternatively, you can run them in separate terminals if preferred:
*   **Run Laravel Server:**
    ```bash
    php artisan serve
    ```
*   **Run Vite Frontend Assets Compiler:**
    ```bash
    npm run dev
    ```

Open your browser and navigate to: **[http://127.0.0.1:8000](http://127.0.0.1:8000)**

---

## 🔑 Default Credentials

For quick testing, you can log in using these default seeded accounts:

| Role | Username / Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@sms.com` | `password` |
| **Teacher** | `teacher@sms.com` | `password` |
| **Student** | *(Check the `students` table in DB for generated student emails)* | `password123` |

---

## 📄 License
This project is open-sourced software licensed under the [MIT license](LICENSE).
