<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Models\Category;
use App\Models\Package;
use App\Models\Team;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $setting = Setting::first();

        $megaMenuCategories = Category::whereNull('parent_id')
            ->active()->where('display_on','header')
            ->with([
                'children' => function ($q) {
                    $q->where('status', true)
                      ->select('id', 'parent_id', 'name', 'slug')
                      ->orderBy('order_level')
                      ->with(['packages' => function ($pq) {
                          $pq->where('status', true)
                             ->select('packages.id', 'packages.name', 'packages.slug', 
                                      'packages.image', 'packages.trip_price', 
                                      'packages.trip_previous_price','duration','trip_grading')
                             ->orderBy('view_count', 'desc')
                             ->limit(3); 
                      }]);
                }
            ])
            ->select('id', 'name', 'slug')
            ->orderBy('order_level')
            ->get();

        $popularTreks = Package::where('status', true)->limit(5)->get(['id', 'name', 'slug']);

        $teamMembers = Team::active()
            ->select('id', 'name', 'address', 'image')
            ->ordered()
            ->limit(4)
            ->get();

        $cmsMenuPages = Page::query()
            ->active()
            ->where('show_in_menu', 1)
            ->ordered()
            ->get(['id', 'title', 'slug']);

        $cmsFooterPages = Page::query()
            ->active()
            ->where('show_in_footer', 1)
            ->ordered()
            ->get(['id', 'title', 'slug']);


            

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error'   => fn () => $request->session()->get('error'),
            ],
            
            'setting' => $setting ? [
                'system_name'      => $setting->system_name,
                'phone'            => $setting->phone,
                'email'            => $setting->email,
                'address'          => $setting->address,
                'facebook'         => $setting->facebook,
                'instagram'        => $setting->instagram,
                'youtube'          => $setting->youtube,
                'google'          => $setting->google,
                'twitter'          => $setting->twitter,
                'logo_url'         => $setting->logo_url,
                'favicon_url'      => $setting->favicon_url,
                'bg_image_url'     => $setting->bg_image_url,
                'breadcrumb_url'     => $setting->breadcrumb_url,
                'image1_url'     => $setting->image1_url,
                'info1'            => $setting->info1, 
                'info2'            => $setting->info2,
                'process_item'     => $setting->process_item,
                'work_item'        => $setting->work_item, 
                'meta_title'       => $setting->meta_title,
                'meta_description' => $setting->meta_description,
                'meta_keywords'    => $setting->meta_keywords,
            ] : null,

            'megaMenuCategories' => $megaMenuCategories,
            'popularTreks'       => $popularTreks, 
            'teamMembers'        => $teamMembers,
            'cmsMenuPages'       => $cmsMenuPages,
            'cmsFooterPages'       => $cmsFooterPages,
        ]);
    }
}