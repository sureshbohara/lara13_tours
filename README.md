# TOUR DASH - Advanced Travel & Tour Management System

A robust, enterprise-level Laravel 13 Admin Panel specifically designed for travel agencies, tour operators, and hospitality businesses. It features a modular architecture, queue-based background processing, and a comprehensive set of tools to manage trips, content, and customers efficiently.

---

## 🌟 Key Features

### 🎯 Core Modules
- **Dashboard:** Comprehensive overview with quick stats.
- **Trip Management:** Full CRUD for Packages, Categories, Fixed Departures, Itineraries, Inclusions/Exclusions, and Equipment lists.
- **Content Management:** Blogs, Static Pages, Banners, FAQs, Reviews, Gallery, and Team Members.
- **User & Access Control:** Admin Users, Roles, and Granular Permissions (RBAC).
- **Site Settings:** 80+ configurable options (General, Media, SMTP, Social Links, SEO, API Keys).

### 🚀 Advanced Features
- **📧 Notification System:** Automated emails (Welcome, Login Alert, Password Change) with in-app notification bell and unread counts.
- **🖼️ Central Media Library:** Reusable media picker across all modules, bulk uploads, and automatic image variant generation (Thumb/Medium).
- **🛡️ Database Backup:** One-click database backup creation, download, and management directly from the admin panel.
- **📊 Subscriber Management:** Newsletter subscriber list with CSV import, status toggling, and filtering.
- **🔐 Login Activity Tracking:** Detailed logs of admin logins including IP, Browser, OS, and Device type.
- **🌐 Dynamic Sitemap:** Auto-generated `sitemap.xml` for SEO optimization.

### ⚡ Technical Highlights
- **Queue-Based Processing:** Non-blocking email sending and image optimization using Laravel Queues.
- **Direct Public Storage:** Images stored directly in `public/images/` for faster access without symlink overhead.
- **Smart Data Handling:** Automatic transformation of parallel form arrays into structured JSON data.
- **Enterprise Security:** CSRF protection, strict validation, password hashing, and session regeneration.
- **Modern Stack:** Laravel 13, PHP 8.5, Bootstrap 5, jQuery, and Intervention Image v3.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 13.x, PHP 8.5+
- **Database:** MySQL / MariaDB
- **Frontend:** Bootstrap 5, jQuery, Bootstrap Icons, Toastr.js
- **Image Processing:** Intervention Image v3 (GD Driver)
- **Queue Driver:** Database

---

## 📦 Installation & Setup

Follow these steps to set up the project locally:

### 1. Clone and Install Dependencies

git clone <https://github.com/sureshbohara/lara13_tours>
cd lara13
composer install