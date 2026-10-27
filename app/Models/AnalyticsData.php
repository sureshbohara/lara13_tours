<?php

declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Carbon\Carbon;


#[Fillable([
     'page_url', 'browser', 'session_id', 'ip_address'
])]

class AnalyticsData extends Model
{
    protected $table = 'analytics_data';



    public static function getRecords(Request $request): array
    {
        $filter = $request->get('filter', 'Today');
        $query = self::query();

        // Date Filter Logic
        match ($filter) {
            'Yesterday' => $query->whereDate('created_at', Carbon::yesterday()),
            'This Week' => $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]),
            'Last 7 Days' => $query->whereBetween('created_at', [Carbon::now()->subDays(7), Carbon::now()]),
            'This Month' => $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year),
            'Last 30 Days' => $query->whereBetween('created_at', [Carbon::now()->subDays(30), Carbon::now()]),
            'This Year' => $query->whereYear('created_at', Carbon::now()->year),
            default => $query->whereDate('created_at', Carbon::today()), // Today
        };

        $data = $query->get();

        // 1. Basic Counts
        $totalPageviews = $data->count();
        $uniqueVisitors = $data->unique('ip_address')->count();
        $uniqueSessions = $data->unique('session_id')->count();

        // 2. Bounce Rate (Approximation: Sessions with only 1 pageview)
        $sessionCounts = $data->groupBy('session_id')->map->count();
        $bouncedSessions = $sessionCounts->filter(fn($count) => $count === 1)->count();
        $bounceRate = $uniqueSessions > 0 ? round(($bouncedSessions / $uniqueSessions) * 100, 1) : 0;

        // 3. Top Pages
        $mostVisitedPages = $data->groupBy('page_url')
            ->map(fn($items) => ['page_url' => $items->first()->page_url, 'pageviews' => $items->count()])
            ->sortByDesc('pageviews')
            ->take(5)
            ->values();

        // 4. Top Browsers
        $topBrowsers = $data->groupBy('browser')
            ->map(fn($items) => ['browser' => $items->first()->browser ?? 'Unknown', 'count' => $items->count()])
            ->sortByDesc('count')
            ->take(5)
            ->values();

        // 5. Hourly/Daily Chart Data
        $groupBy = in_array($filter, ['Today', 'Yesterday']) ? 'hour' : 'day';
        $chartData = $data->groupBy(function ($item) use ($groupBy) {
            return $groupBy === 'hour' 
                ? Carbon::parse($item->created_at)->format('H:i') 
                : Carbon::parse($item->created_at)->format('M d');
        })->map->count();

        return [
            'totalSessions'    => $uniqueSessions,
            'visitors'         => $uniqueVisitors,
            'pageviews'        => $totalPageviews,
            'bounceRate'       => $bounceRate,
            'mostVisitedPages' => $mostVisitedPages,
            'topBrowsers'      => $topBrowsers,
            'chartLabels'      => $chartData->keys()->toArray(),
            'hourlyViews'      => $chartData->values()->toArray(),
        ];
    }
}