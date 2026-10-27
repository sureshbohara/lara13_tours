<?php

use App\Http\Controllers\Front\SitemapController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PackageController;
use App\Http\Controllers\Front\BlogController;
use App\Http\Controllers\Front\PageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;




// Sitemap Route 
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{package:slug}', [PackageController::class, 'show'])->name('packages.show');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::get('/blogs/{blog:slug}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/pages/{page:slug}', [PageController::class, 'show'])->name('pages.show');



// Admin Routes
require __DIR__.'/admin.php';



// Cache Clear (Development only)
Route::get('/cacher', function () {
    Artisan::call('optimize:clear');
    return redirect('/');
});
