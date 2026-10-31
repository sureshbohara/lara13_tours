<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Package;
use App\Models\Service;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Team;
use App\Models\Faq;
use App\Models\PackageReview;
use App\Models\Booking; 
use App\Mail\ContactFormMailable;
use App\Mail\CustomizeTripMailable;
use Illuminate\Support\Facades\Mail;
use App\Models\Gallery;
use App\Models\Page;
use Inertia\Inertia;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    public function index()
    {

        $banners = Banner::active()->ordered()->get();
        
        $destinationCategory = Category::where('slug', 'destinations')
            ->where('status', true)
            ->with(['children' => function ($q) {
                $q->where('status', true)
                  ->withCount('packages')
                  ->orderBy('order_level', 'asc')
                  ->limit(4);
            }])
            ->first();


         $trekkingCategory = Category::where('slug', 'trekking')
            ->where('status', true)
            ->with(['children' => function ($q) {
                $q->where('status', true)
                  ->orderBy('order_level', 'asc')
                  ->limit(8);
            }])
            ->first();

  
         $popularTours = Package::where('status', true)
            ->select('id', 'name', 'slug', 'image', 'trip_price', 'duration', 'trip_grading', 'best_season')
            ->withCount('fixedDepartures') 
            ->orderBy('view_count', 'desc')
            ->limit(6)
            ->get();

  
        $upcomingPackages = Package::where('status', true)
            ->select('id', 'name', 'slug', 'image', 'trip_price', 'duration')
            ->with(['fixedDepartures' => function ($q) {
                $q->where('start_date', '>=', now()->toDateString())
                  ->orderBy('start_date', 'asc')
                  ->limit(1); 
            }])
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

  
        $reviews = Review::active()->ordered()->limit(6)->get();

        $featuredBlog = Blog::active()
            ->where('is_featured', true)
            ->select('id', 'title', 'slug', 'image', 'excerpt', 'created_at')
            ->latest()
            ->first();

        $recentBlogs = Blog::active()
            ->select('id', 'title', 'slug', 'image', 'excerpt', 'created_at')
            ->latest()
            ->limit(4)
            ->get();

 
        $teamMemberships = Team::active()->ordered()->where('display_on','memberships')->get();

        return Inertia::render('Home', [
            'banners' => $banners,
            'destinationCategory' => $destinationCategory,
            'trekkingCategory' => $trekkingCategory,
            'popularTours' => $popularTours,
            'upcomingPackages' => $upcomingPackages,
            'reviews' => $reviews,
            'featuredBlog' => $featuredBlog, 
            'recentBlogs' => $recentBlogs,
            'teamMemberships' => $teamMemberships,     
        ]);
    }



     public function packageListing($slug){
        $category = Category::where('slug', $slug)->where('status', true)->firstOrFail();

        $subCategories = $category->children()->where('status', true)->withCount('packages')->ordered()->get(['id', 'name', 'slug', 'image', 'parent_id']);

        $categoryIds = $subCategories->pluck('id')->toArray();
        $categoryIds[] = $category->id;

        $filterSubCategory = request('subcategory');
        $filterDuration = request('duration');    
        $filterDifficulty = request('difficulty'); 

        $packagesQuery = Package::where('status', true)
            ->whereHas('categories', function ($q) use ($categoryIds, $filterSubCategory) {
                $q->whereIn('categories.id', $categoryIds);
                if ($filterSubCategory) {
                    $q->where('categories.id', $filterSubCategory);
                }
            });


        if ($filterDuration) {
            if ($filterDuration === '1-5') {
                $packagesQuery->where(function($q) {
                    $q->where('duration', 'like', '%1 %')->orWhere('duration', 'like', '%2 %')
                      ->orWhere('duration', 'like', '%3 %')->orWhere('duration', 'like', '%4 %')->orWhere('duration', 'like', '%5 %');
                });
            } elseif ($filterDuration === '6-10') {
                $packagesQuery->where(function($q) {
                    $q->where('duration', 'like', '%6 %')->orWhere('duration', 'like', '%7 %')
                      ->orWhere('duration', 'like', '%8 %')->orWhere('duration', 'like', '%9 %')->orWhere('duration', 'like', '%10 %');
                });
            } elseif ($filterDuration === '11-15') {
                $packagesQuery->where(function($q) {
                    $q->where('duration', 'like', '%11 %')->orWhere('duration', 'like', '%12 %')
                      ->orWhere('duration', 'like', '%13 %')->orWhere('duration', 'like', '%14 %')->orWhere('duration', 'like', '%15 %');
                });
            } elseif ($filterDuration === '16+') {
                $packagesQuery->where('duration', 'like', '%16 %')->orWhere('duration', 'like', '%17 %')->orWhere('duration', 'like', '%18 %');
            }
        }


        if ($filterDifficulty) {
            $packagesQuery->where('trip_grading', 'like', '%' . $filterDifficulty . '%');
        }

        // Sorting
        $sortBy = request('sort', 'popular');
        if ($sortBy === 'price_low') {
            $packagesQuery->orderBy('trip_price', 'asc');
        } elseif ($sortBy === 'price_high') {
            $packagesQuery->orderBy('trip_price', 'desc');
        } elseif ($sortBy === 'newest') {
            $packagesQuery->orderBy('created_at', 'desc');
        } else {
            $packagesQuery->orderBy('view_count', 'desc');
        }

        $packages = $packagesQuery->paginate(12)->withQueryString();

        $breadcrumbs = [];
        $current = $category;
        while ($current) {
            $breadcrumbs[] = ['name' => $current->name, 'slug' => $current->slug];
            $current = $current->parent;
        }
        $breadcrumbs = array_reverse($breadcrumbs);

        return Inertia::render('Listing', [
            'category' => $category,
            'subCategories' => $subCategories,
            'packages' => $packages,
            'breadcrumbs' => $breadcrumbs,
            'filters' => [
                'subcategory' => $filterSubCategory,
                'duration' => $filterDuration,
                'difficulty' => $filterDifficulty,
                'sort' => $sortBy,
            ],
        ]);
    }



    public function packageDetails($slug){
        $package = Package::where('slug', $slug)
            ->where('status', true)
            ->with(['categories' => function($q) {
                $q->select('categories.id', 'categories.name', 'categories.slug');
            }])
            ->firstOrFail();

        $package->increment('view_count');
        
        $fixedDepartures = $package->fixedDepartures()
            ->where('status', 'active')
            ->orderBy('start_date', 'asc')
            ->get(['id', 'start_date', 'end_date', 'discount_price', 'max_seats', 'booked_seats']);

        $categoryIds = $package->categories->pluck('id');
        
        $relatedPackages = Package::where('status', true)
            ->whereHas('categories', function ($q) use ($categoryIds) {
                $q->whereIn('categories.id', $categoryIds);
            })
            ->where('packages.id', '!=', $package->id) 
            ->select('packages.id', 'packages.name', 'packages.slug', 'packages.image', 'packages.trip_price', 'packages.duration', 'packages.trip_grading')
            ->withCount('fixedDepartures')
            ->orderBy('packages.view_count', 'desc') 
            ->limit(4)
            ->get();


        $reviews = PackageReview::where('package_id', $package->id)
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->get(['id', 'name', 'email', 'address', 'review', 'rating', 'created_at']);


        return Inertia::render('PackageDetails', [
            'package' => $package,
            'fixedDepartures' => $fixedDepartures,
            'relatedPackages' => $relatedPackages,
             'reviews' => $reviews,
        ]);
    }



    
    public function storeReview(Request $request, $slug) {
        $package = Package::where('slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10',
        ]);

        $package->reviews()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'rating' => $validated['rating'],
            'review' => $validated['review'],
            'status' => true,
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted successfully.');
    }



    public function storeBooking(Request $request, $slug) {
        $package = Package::where('slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'number_of_people' => 'required|integer|min:1',
            'travel_date' => 'nullable|date',
            'message' => 'nullable|string|max:1000',
            'fixed_departure_id' => 'nullable|exists:fixed_departures,id',
        ]);
        Booking::create([
            'package_id' => $package->id,
            'fixed_departure_id' => $validated['fixed_departure_id'] ?? null,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'number_of_people' => $validated['number_of_people'],
            'travel_date' => $validated['travel_date'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);
        return back()->with('success', 'Your booking request has been submitted successfully! We will contact you shortly.');
    }




    public function blogs() {
        $blogs = Blog::active()->with(['categories', 'creator'])->latest()->paginate(6);

        $popularPosts = Blog::active()
            ->with('categories')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'image', 'views', 'created_at']);

        return Inertia::render('Blogs', [
            'blogs' => $blogs,
            'popularPosts' => $popularPosts,
        ]);
    }



    public function blogDetails($slug) {
        $blog = Blog::where('slug', $slug)
            ->active()
            ->with('categories')
            ->firstOrFail();

        $blog->increment('views');
        $popularPosts = Blog::active()
            ->where('id', '!=', $blog->id)
            ->with('categories')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'image', 'views', 'created_at']);

        return Inertia::render('BlogDetails', [
            'blog' => $blog,
            'popularPosts' => $popularPosts,
        ]);
    }




public function contact() {
    return Inertia::render('Contact');
}

public function sendContactEmail(Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:20',
        'email' => 'required|email|max:255',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string|min:10|max:2000',
    ]);
    try {
        Mail::to(config('mail.from.address', 'boharas371@gmail.com'))
            ->send(new ContactFormMailable($validated));

        return back()->with('success', 'Message sent successfully!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to send message. Please try again.');
    }
}



public function faqs() {
    $faqs = Faq::active()->ordered()->get();
    return Inertia::render('Faqs', [
        'faqs' => $faqs,
    ]);
}

public function team() {
    $teamMembers = Team::active()->ordered()->get();
    
    return Inertia::render('Team', [
        'teamMembers' => $teamMembers,
    ]);
}


public function gallery() {
    $images = Gallery::active()
        ->ordered()
        ->paginate(12);
    return Inertia::render('Gallery', [
        'images' => $images,
    ]);
}


public function about() {
    return Inertia::render('About');
}


public function cmsPage($slug) {
    $page = Page::where('slug', $slug)->active()->firstOrFail();
    return Inertia::render('CmsPage', [
        'page' => $page,
    ]);
}




    public function customizeTrip() {
        $packages = Package::where('status', true)
            ->select('id', 'name', 'slug')
            ->orderBy('name', 'asc')
            ->get();

        return Inertia::render('CustomizeTrip', [
            'packages' => $packages
        ]);
    }

    public function sendCustomizeTripEmail(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'destination' => 'nullable|string|max:255',
            'arrival_date' => 'nullable|date',
            'departure_date' => 'nullable|date|after_or_equal:arrival_date',
            'travelers' => 'nullable|string|max:50',
            'budget' => 'nullable|string|max:100',
            'message' => 'required|string|min:10|max:2000',
        ]);

        try {
            $adminEmail = 'boharas371@gmail.com';
            Mail::to($adminEmail)->send(new CustomizeTripMailable($validated));

            return back()->with('success', 'Your customize trip request has been sent successfully! We will contact you shortly.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send request. Please try again later.');
        }
    }
    

}