# Informatics Center Support System | سامانه درخواست و پشتیبانی مرکز انفورماتیک

This is a web-based application developed with **PHP and the Laravel framework** for the Khuzestan Water and Electricity Company. The system is designed to streamline and organize the process of submitting, managing, and resolving IT support requests.

این یک برنامه تحت وب است که با استفاده از **PHP و فریمورک لاراول** برای شرکت بهره‌برداری از شبکه‌های آبیاری خوزستان توسعه یافته است. این سیستم به منظور ساده‌سازی و سازماندهی فرآیند ثبت، مدیریت و حل درخواست‌های پشتیبانی IT طراحی شده است.

---

## Key Features | ویژگی‌های کلیدی

* **Role-Based Access Control:** The system has three distinct user roles (Employee, IT Support, Admin), each with a specific dashboard and permissions.
* **Ticket Management:** A complete ticketing system for creating, tracking, assigning, and resolving support requests.
* **Device Management:** An admin panel for managing company assets (laptops, phones, etc.) and assigning them to employees.
* **User Management:** A full admin panel for creating, editing, and deleting user accounts.
* **Satisfaction Rating:** A system for users to provide star ratings on completed tickets.
* **Performance Reporting:** A dedicated reports page for admins to view key metrics like response time and user satisfaction.
* **Internal Messaging:** A note-taking and messaging system within each ticket for communication between users and support staff.
* **Jalali Calendar Support:** All dates and times are displayed in the Shamsi (Jalali) calendar for a localized user experience.

---

## User Roles | نقش‌های کاربری

1.  **Employee (کاربر عادی):**
    * Can create new support tickets.
    * Can view their own tickets and their status.
    * Can see a list of assets assigned to them.
    * Can communicate with support via messages in the ticket.
    * Can rate the support after a ticket is completed.

2.  **IT Support (پشتیبان):**
    * Has a dedicated dashboard showing tickets assigned to them.
    * Can view and respond to their assigned tickets.
    * Can allocate available assets to a ticket.
    * Can mark tickets as completed.

3.  **Administrator (مدیر سیستم):**
    * Has a full overview of the entire system.
    * Can manage all users (create, edit, delete).
    * Can manage all devices/assets.
    * Can assign unassigned tickets to IT support staff.
    * Can view performance and satisfaction reports.

---

## Technical Stack | تکنولوژی‌های استفاده شده

* **Backend:** PHP, Laravel Framework
* **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
* **Database:** MySQL

---