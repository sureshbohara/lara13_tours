<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\LoginActivityController;
use App\Http\Controllers\Admin\SiteHealthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BlogsController;
use App\Http\Controllers\Admin\PackageController;

use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\BookingController;

use Illuminate\Support\Facades\Route;

Route::middleware('admin.guest')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
});

Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {


     // ─── Login Activities ────────────────
    Route::get('/login-activities', [LoginActivityController::class, 'index'])->name('login-activities.index');
    Route::delete('/login-activities/bulk-delete', [LoginActivityController::class, 'bulkDelete'])->name('login-activities.bulk-delete');

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/site-health', [SiteHealthController::class, 'index'])->name('site.health');
    
    Route::get('/profile', [AdminAuthController::class, 'showProfile'])->name('profile.edit');
    Route::post('/profile', [AdminAuthController::class, 'updateProfile'])->name('profile.update');
    Route::get('/change-password', [AdminAuthController::class, 'showChangePassword'])->name('password.edit');
    Route::post('/change-password', [AdminAuthController::class, 'updatePassword'])->name('password.update');
    
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    
    Route::post('/ckeditor/upload', [CkeditorController::class, 'ckeditorUpload'])->name('ckeditor.upload');
    Route::post('/ckeditor/delete', [CkeditorController::class, 'ckeditorDeleteImage'])->name('ckeditor.delete');
    
    // Admin Users
    Route::post('user/status', [AdminController::class, 'userStatus'])->name('user.status');
    Route::post('user/order-level', [AdminController::class, 'updateOrderLevel'])->name('user.order-level');
    Route::resource('user', AdminController::class)->except(['show']);
    
    // Permissions
    Route::resource('permission', PermissionController::class)->except(['show']);

    // Banners
    Route::post('banner/status', [BannerController::class, 'bannerStatus'])->name('banner.status');
    Route::post('banner/order-level', [BannerController::class, 'updateOrderLevel'])->name('banner.order-level');
    Route::resource('banner', BannerController::class)->except(['show']);

    // FAQs
    Route::post('faq/status', [FaqController::class, 'faqStatus'])->name('faq.status');
    Route::post('faq/order-level', [FaqController::class, 'updateOrderLevel'])->name('faq.order-level');
    Route::resource('faq', FaqController::class)->except(['show']);

    // Gallery
    Route::post('gallery/status', [GalleryController::class, 'galleryStatus'])->name('gallery.status');
    Route::post('gallery/order-level', [GalleryController::class, 'updateOrderLevel'])->name('gallery.order-level');
    Route::resource('gallery', GalleryController::class)->except(['show']);

    // Pages
    Route::post('page/status', [PageController::class, 'pageStatus'])->name('page.status');
    Route::post('page/order-level', [PageController::class, 'updateOrderLevel'])->name('page.order-level');
    Route::resource('page', PageController::class)->except(['show']);

    // Reviews
    Route::post('review/status', [ReviewController::class, 'reviewStatus'])->name('review.status');
    Route::post('review/order-level', [ReviewController::class, 'updateOrderLevel'])->name('review.order-level');
    Route::resource('review', ReviewController::class)->except(['show']);

    // Services
    Route::post('service/status', [ServiceController::class, 'serviceStatus'])->name('service.status');
    Route::post('service/order-level', [ServiceController::class, 'updateOrderLevel'])->name('service.order-level');
    Route::resource('service', ServiceController::class)->except(['show']);

    // Team
    Route::post('team/status', [TeamController::class, 'teamStatus'])->name('team.status');
    Route::post('team/order-level', [TeamController::class, 'updateOrderLevel'])->name('team.order-level');
    Route::resource('team', TeamController::class)->except(['show']);

      // ─── Categories Management ──────────────────────────────────
    Route::post('category/status', [CategoryController::class, 'toggleStatus'])->name('category.toggleStatus');
    Route::post('category/order-level', [CategoryController::class, 'updateOrderLevel'])->name('category.updateOrderLevel');
    Route::resource('category', CategoryController::class)->except(['show']);

      // ─── Blogs Management ──────────────────────────────────
    Route::post('blogs/status', [BlogsController::class, 'toggleStatus'])->name('blogs.toggleStatus');
    Route::post('blogs/order-level', [BlogsController::class, 'updateOrderLevel'])->name('blogs.updateOrderLevel');
    Route::resource('blogs', BlogsController::class)->except(['show']);




     // ==========================================
    // Packages & Fixed Departures
    // ==========================================
    Route::post('package/status', [PackageController::class, 'packageStatus'])->name('package.status');
    Route::post('package/order-level', [PackageController::class, 'updateOrderLevel'])->name('package.order-level');
    Route::post('package/type', [PackageController::class, 'updatePackageType'])->name('package.type');

    Route::get('package/prices', [PackageController::class, 'packagePrices'])->name('package.prices');
    Route::post('package/prices/update', [PackageController::class, 'updatePackagePrices'])->name('package.prices.update');
    Route::post('package/delete-gallery-image', [PackageController::class, 'deleteGalleryImage'])->name('package.delete.gallery.image');

    // Package Sub-pages
    Route::match(['get', 'post'], 'trip/itinerary/{id}', [PackageController::class, 'tripItinerary'])->name('trip.itinerary');
    Route::match(['get', 'post'], 'trip/incexc/{id}', [PackageController::class, 'tripIncExc'])->name('trip.incexc');
    Route::match(['get', 'post'], 'trip/equipment/{id}', [PackageController::class, 'tripEquipment'])->name('trip.equipment');

    // Standard CRUD Resource
    Route::resource('package', PackageController::class)->except(['show']);

    // Fixed Departures
    Route::get('fixed-departures', [PackageController::class, 'fixDepature'])->name('fix-depature-package');
    Route::post('fixed-departures/add', [PackageController::class, 'fixDepatureAdd'])->name('fix-depature-package-add');
    Route::delete('fixed-departures/{id}', [PackageController::class, 'deleteFixDepature'])->name('delete.fix-depature-package');
    Route::post('fixed-departures/status', [PackageController::class, 'fixDepatureStatus'])->name('fix-depature-status');


    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::get('notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');



    // ─── Backup Management ────────────────
    Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('/backups', [BackupController::class, 'store'])->name('backups.store');
    Route::get('/backups/{id}/download', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('/backups/{id}', [BackupController::class, 'destroy'])->name('backups.destroy');


    // ─── Subscribers Management ────────────────
    Route::post('subscribers/import', [SubscriberController::class, 'import'])->name('subscribers.import');
    Route::post('subscribers/status', [SubscriberController::class, 'toggleStatus'])->name('subscribers.toggleStatus');
    Route::resource('subscribers', SubscriberController::class)->except(['show', 'create', 'store', 'edit', 'update']);



    // ─── Coupons Management ────────────────
    Route::post('coupons/status', [CouponController::class, 'toggleStatus'])->name('coupons.toggleStatus');
    Route::post('coupons/validate', [CouponController::class, 'validateCoupon'])->name('coupons.validate');
    Route::resource('coupons', CouponController::class);



    // ─── Bookings Management ────────────────
   Route::post('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
   Route::resource('bookings', BookingController::class)->except(['create', 'store', 'edit', 'update']);




    
});