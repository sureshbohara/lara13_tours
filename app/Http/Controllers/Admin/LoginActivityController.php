<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\LoginActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginActivityController extends BaseController
{
    public function index(Request $request)
    {
        $query = LoginActivity::with('admin:id,name,email,image') 
            ->latestLogin();

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('admin', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('ip_address', 'like', "%{$search}%")
                ->orWhere('os', 'like', "%{$search}%")
                ->orWhere('browser', 'like', "%{$search}%");
            });
        }

        // Date Filters
        if ($request->filled('from_date')) {
            $query->whereDate('login_at', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('login_at', '<=', $request->to_date);
        }

        // Device Type Filter
        if ($request->filled('device_type') && in_array($request->device_type, ['desktop', 'mobile', 'tablet'])) {
            $query->where('device_type', $request->device_type);
        }

        $perPage = $request->get('per_page', 15);
        $activities = $query->paginate($perPage)->withQueryString();

        return view('admin.login_activities.index', compact('activities'));
    }

    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:login_activities,id'
        ]);

        $deleted = LoginActivity::whereIn('id', $request->ids)->delete();

        return $this->successJson(
            "Successfully deleted {$deleted} login activity record(s)!",
            ['deleted_count' => $deleted]
        );
    }

    public function destroy($id): JsonResponse
    {
        $activity = LoginActivity::findOrFail($id);
        $activity->delete();

        return $this->successJson('Login activity deleted successfully!');
    }
}