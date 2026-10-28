<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Category;
use App\Models\Setting;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {

        $megaMenuCategories = Category::whereNull('parent_id')
            ->where('status', true)
            ->with([
                'children' => function ($q) {
                    $q->where('status', true)
                      ->select('id', 'parent_id', 'name', 'slug')
                      ->orderBy('order_level')
                      ->with(['packages' => function ($pq) {
                          $pq->where('status', true)
                             ->select('packages.id', 'packages.name', 'packages.slug', 
                                      'packages.image', 'packages.trip_price', 
                                      'packages.trip_previous_price')
                             ->orderBy('view_count', 'desc');
    
                      }]);
                }
            ])
            ->select('id', 'name', 'slug')
            ->orderBy('order_level')
            ->get();

        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'setting' => Setting::getInstance(),
            'megaMenuCategories' => $megaMenuCategories,
        ]);
    }
}