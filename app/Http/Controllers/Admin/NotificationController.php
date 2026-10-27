<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $adminId = Auth::guard('admin')->id();
        
        $notifications = Notification::forAdmin($adminId)
            ->latest()
            ->paginate(20);

        $unreadCount = Notification::forAdmin($adminId)->unread()->count();

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markAsRead(int $id): JsonResponse
    {
        $notification = Notification::findOrFail($id);
        
        // Ensure admin can only mark their own notifications
        if ($notification->admin_id !== Auth::guard('admin')->id()) {
            return $this->errorJson('Unauthorized', 403);
        }

        $notification->markAsRead();

        return $this->successJson('Notification marked as read');
    }

    public function markAllAsRead(): JsonResponse
    {
        $adminId = Auth::guard('admin')->id();
        $count = Notification::forAdmin($adminId)
            ->unread()
            ->update(['read_at' => now()]);

        return $this->successJson("{$count} notifications marked as read");
    }

    public function getUnreadCount(): JsonResponse
    {
        $adminId = Auth::guard('admin')->id();
        $count = Notification::forAdmin($adminId)->unread()->count();

        return response()->json(['count' => $count]);
    }

    public function destroy(int $id): JsonResponse
    {
        $notification = Notification::findOrFail($id);
        
        if ($notification->admin_id !== Auth::guard('admin')->id()) {
            return $this->errorJson('Unauthorized', 403);
        }

        $notification->delete();

        return $this->successJson('Notification deleted');
    }
}