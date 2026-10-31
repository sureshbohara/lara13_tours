# SP TOUR MANAGE - Advanced Travel & Tour Management System

A robust, enterprise-level **Laravel 13 + React (Inertia.js)** application specifically designed for travel agencies, tour operators, and hospitality businesses. It features a modern, responsive frontend for customers and a comprehensive, modular admin panel to manage trips, bookings, content, and customers efficiently.

---

## 🌟 Key Features

### 🎯 Core Admin Modules
- **Dashboard:** Comprehensive overview with real-time stats, traffic analytics, and recent bookings.
- **Trip Management:** Full CRUD for Packages, Categories, Fixed Departures, Itineraries, Inclusions/Exclusions, and Equipment lists.
- **Booking & Inquiry System:** Manage customer bookings, track statuses (Pending, Confirmed, Cancelled, Completed), and handle "Customize Trip" inquiries.
- **Content Management (CMS):** Dynamic Blogs, Static Pages (About, Contact, FAQs, Terms, Privacy), Banners, Reviews, Gallery, and Team Members.
- **User & Access Control:** Admin Users, Roles, and Granular Permissions (RBAC).
- **Site Settings:** 80+ configurable options (General, Media, SMTP, Social Links, SEO, API Keys).

### 🚀 Advanced Features
- **📧 Notification System:** Automated emails (Booking Confirmation, Contact Form, Newsletter) with in-app notification bell and unread counts.
- **🖼️ Central Media Library:** Reusable media picker across all modules, bulk uploads, and automatic image variant generation.
- **🛡️ Database Backup:** One-click database backup creation, download, and management directly from the admin panel.
- **📊 Subscriber Management:** Newsletter subscriber list with CSV import, status toggling, and filtering.
- **🔐 Login Activity Tracking:** Detailed logs of admin logins including IP, Browser, OS, and Device type.
- **🌐 Dynamic Sitemap:** Auto-generated `sitemap.xml` for SEO optimization.

### 💻 Modern Frontend (Customer Facing)
- **React + Inertia.js:** Blazing fast, Single Page Application (SPA) feel without building a separate API.
- **Advanced Filtering:** Dynamic package filtering by Duration, Difficulty, Subcategories, and Sorting.
- **Responsive Design:** Fully mobile-optimized UI with custom Offcanvas mobile menus.
- **Interactive Components:** Swiper carousels, Lightbox galleries, Accordion FAQs, and Dynamic Mega Menus.

### ⚡ Technical Highlights
- **Queue-Based Processing:** Non-blocking email sending and background tasks using Laravel Queues.
- **Smart Data Handling:** Automatic transformation of parallel form arrays into structured JSON data.
- **Enterprise Security:** CSRF protection, strict FormRequest validation, password hashing, and session regeneration.
- **Named Routing:** Fully integrated `ziggy-js` for safe, maintainable frontend routing.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 13.x, PHP 8.2+
- **Frontend:** React 18, Inertia.js, Vite, Ziggy, Bootstrap 5, Tailwind CSS (Utility), Swiper.js
- **Database:** MySQL / MariaDB / SQLite
- **Image Processing:** Intervention Image v3 (GD Driver)
- **Queue Driver:** Database / Redis

---

## 📦 Installation & Setup

Follow these steps to set up the project locally:

### 1. Clone the Repository
```bash
git clone https://github.com/sureshbohara/lara13_tours.git
cd lara13_tours