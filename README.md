# SP TOUR - Advanced Travel & Tour Management System

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
```

### 2. Install Backend Dependencies
```bash
composer install
```

### 3. Install Frontend Dependencies
```bash
npm install
```

### 4. Environment Configuration
Copy the example environment file and configure your local settings:
```bash
cp .env.example .env
php artisan key:generate
```
*Update your `.env` file with your Database credentials and Mail settings (use an App Password for Gmail).*

### 5. Database Migration & Seeding
Run migrations and seed the database with initial data (Admin users, settings, sample packages):
```bash
php artisan migrate --seed
```

### 6. Storage Link
Create a symbolic link for public file uploads:
```bash
php artisan storage:link
```

### 7. Build Frontend Assets
For local development, run the Vite development server:
```bash
npm run dev
```
*(For production, use `npm run build`)*

### 8. Start the Application
Open a new terminal tab and start the Laravel development server:
```bash
php artisan serve
```

🎉 **You're all set!** Visit `http://localhost:8000` to view the frontend, and `http://localhost:8000/admin` for the admin panel.

---

## 🔑 Default Admin Credentials (After Seeding)
*(Note: Change these immediately after first login)*
- **Email:** `admin@example.com` *(Check your seeder for the exact email)*
- **Password:** `password`

---

## 📂 Project Structure Highlights

```text
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   └── Front/          # Frontend customer-facing controllers
│   ├── Models/             # Eloquent models (Package, Booking, Blog, etc.)
│   └── Services/           # Business logic separation
├── resources/
│   ├── js/
│   │   ├── Components/     # Reusable React components (Header, Footer, UI)
│   │   ├── Layouts/        # Inertia layouts (FrontLayout, AdminLayout)
│   │   ├── Pages/          # React page components (Home, Blogs, Team, etc.)
│   │   └── app.jsx         # Inertia & Vite entry point
│   └── views/
│       └── admin/          # Blade templates for the Admin Panel
└── routes/
    ├── web.php             # Frontend routes
    └── admin.php           # Admin panel routes
```

---

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is proprietary software developed for **SP Travel and Tours**. All rights reserved.

---

## 👨‍💻 Author

**Suresh Bohara**  
*Full Stack Developer*  
📧 [boharas371@gmail.com]  
🔗 [https://github.com/sureshbohara/]