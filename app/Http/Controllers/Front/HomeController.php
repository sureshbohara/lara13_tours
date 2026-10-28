<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Package;
use App\Models\Service;
use App\Models\Review;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        $banners = Banner::where('status', true)
            ->orderBy('order_level', 'asc')
            ->get();

    
        $categories = Category::where('status', true)
            ->whereNull('parent_id')
            ->withCount('packages')
            ->orderBy('order_level', 'asc')
            ->limit(6)
            ->get();

  
        $popularTours = Package::where('status', true)
            ->orderBy('view_count', 'desc')
            ->limit(6)
            ->get();

  
        $upcomingPackages = Package::where('status', true)
            ->with('fixedDepartures')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

     
        $services = Service::where('status', true)
            ->orderBy('order_level', 'asc')
            ->limit(4)
            ->get();

  
        $reviews = Review::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

 
        $processSection = [
            'title' => setting('process_title', 'Why Choose Us?'),
            'subtitle' => setting('process_sub_title', 'Experience the best of Nepal with our trusted platform'),
            'items' => setting('process_item', []),
        ];


        $infoSection = [
            'info1' => setting('info1', 'Your Gateway to Authentic Nepali Hospitality'),
            'info2' => setting('info2', ''),
            'info3' => setting('info3', ''),
            'info4' => setting('info4', ''),
        ];

        return Inertia::render('Home', [
            'banners' => $banners,
            'categories' => $categories,
            'popularTours' => $popularTours,
            'upcomingPackages' => $upcomingPackages,
            'services' => $services,
            'reviews' => $reviews,
            'processSection' => $processSection,
            'infoSection' => $infoSection,
        ]);
    }
}