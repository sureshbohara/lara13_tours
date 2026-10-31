<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\NewsletterController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/packages/{slug}', [HomeController::class, 'packageListing'])->name('packages.category');
Route::get('/tour/{slug}', [HomeController::class, 'packageDetails'])->name('package.details');
Route::post('/tour/{slug}/review', [HomeController::class, 'storeReview'])->name('package.review.store');
Route::post('/tour/{slug}/booking', [HomeController::class, 'storeBooking'])->name('package.booking.store');

Route::get('/blogs', [HomeController::class, 'blogs'])->name('blog.index');
Route::get('/blogs/{slug}', [HomeController::class, 'blogDetails'])->name('blog.details');


Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact-us', [HomeController::class, 'sendContactEmail'])->name('contact.send');

Route::get('/faqs', [HomeController::class, 'faqs'])->name('faqs');
Route::get('/team', [HomeController::class, 'team'])->name('team');

Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/about-us', [HomeController::class, 'about'])->name('about');

Route::get('/pages/{slug}', [HomeController::class, 'cmsPage'])->name('cms.page');


Route::get('/customize-trip', [HomeController::class, 'customizeTrip'])->name('customize.trip');
Route::post('/customize-trip', [HomeController::class, 'sendCustomizeTripEmail'])->name('customize.trip.send');

require __DIR__.'/admin.php';
