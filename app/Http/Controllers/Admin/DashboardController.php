<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\AnalyticsData;
use App\Models\Service;
use App\Models\Package; 
use App\Models\Review;
use App\Models\Booking; 
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    public function dashboard(Request $request)
    {
        // 1. Analytics Data
        $analytics = AnalyticsData::getRecords($request);

        // 2. Business Stats
        $stats = [
            'services_count'    => Service::count(),
            'services_active'   => Service::where('status', true)->count(),
            'packages_count'    => Package::count(),
            'packages_active'   => Package::where('status', true)->count(),
            'reviews_count'     => Review::count(),
            'server'            => $this->getServerStats(),
            
            //3. Booking Stats
            'bookings_total'    => Booking::count(),
            'bookings_pending'  => Booking::where('status', 'pending')->count(),
            'bookings_confirmed'=> Booking::where('status', 'confirmed')->count(),
            'recent_bookings'   => Booking::with(['package', 'fixedDeparture'])->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', [
            'analytics' => $analytics,
            'stats'     => $stats,
        ]);
    }

    protected function getServerStats(): array
    {
        $path = base_path();
        $total = @disk_total_space($path);
        $free = @disk_free_space($path);
        
        if ($total === false || $free === false || $total == 0) {
            return ['used_percent' => 0, 'used_gb' => 0, 'total_gb' => 0];
        }

        $used = $total - $free;
        $totalGb = round($total / (1024 * 1024 * 1024), 2);
        $usedGb = round($used / (1024 * 1024 * 1024), 2);
        $percent = round(($used / $total) * 100, 2);

        return [
            'used_percent' => $percent,
            'used_gb' => $usedGb,
            'total_gb' => $totalGb,
        ];
    }
}