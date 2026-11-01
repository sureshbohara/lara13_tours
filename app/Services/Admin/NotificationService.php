<?php

declare(strict_types=1);

namespace App\Services\Admin;

use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class NotificationService
{
    public function sendWelcomeEmail(Admin $admin): void
    {
        $this->createAndSend(
            admin: $admin,
            type: 'welcome',
            title: 'Welcome to ' . config('app.name'),
            message: "Hello {$admin->name}, welcome to our admin panel!",
            view: 'emails.welcome',
            data: ['admin' => $admin]
        );
    }

    public function sendLoginAlert(Admin $admin, string $ipAddress, string $browser): void
    {
        $this->createAndSend(
            admin: $admin,
            type: 'login_alert',
            title: 'New Login Alert',
            message: "New login detected from IP: {$ipAddress}, Browser: {$browser}",
            view: 'emails.login_alert',
            data: [
                'admin' => $admin,
                'ip_address' => $ipAddress,
                'browser' => $browser,
                'time' => now()->toDateTimeString(),
            ]
        );
    }

    public function sendPasswordChangedEmail(Admin $admin): void
    {
        $this->createAndSend(
            admin: $admin,
            type: 'password_changed',
            title: 'Password Changed Successfully',
            message: 'Your password has been changed successfully. If you did not make this change, please contact support immediately.',
            view: 'emails.password_changed',
            data: ['admin' => $admin, 'time' => now()->toDateTimeString()]
        );
    }

    public function sendPasswordResetEmail(Admin $admin, string $resetToken): void
    {
        $resetUrl = route('admin.password.reset', ['token' => $resetToken]);
        
        $this->createAndSend(
            admin: $admin,
            type: 'password_reset',
            title: 'Password Reset Request',
            message: 'Click the link below to reset your password.',
            view: 'emails.password_reset',
            data: [
                'admin' => $admin,
                'reset_url' => $resetUrl,
                'expires_at' => now()->addHours(1)->toDateTimeString(),
            ]
        );
    }

    public function sendAccountStatusChange(Admin $admin, bool $isActive): void
    {
        $status = $isActive ? 'activated' : 'deactivated';
        
        $this->createAndSend(
            admin: $admin,
            type: 'account_status',
            title: "Account {$status}",
            message: "Your account has been {$status} by the administrator.",
            view: 'emails.account_status',
            data: ['admin' => $admin, 'status' => $status]
        );
    }

    protected function createAndSend(
        Admin $admin,
        string $type,
        string $title,
        string $message,
        string $view,
        array $data = []
    ): void {
        $notification = Notification::create([
            'admin_id' => $admin->id,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'channel' => 'email',
            'status' => 'pending',
            'data' => $data,
        ]);

        try {
     
            $mailable = new class($view, $data, $title) extends Mailable implements ShouldQueue {
                use Queueable, SerializesModels;

                public $viewName;
                public $viewData;
                public $mailTitle;

                public function __construct($viewName, $viewData, $mailTitle) {
                    $this->viewName = $viewName;
                    $this->viewData = $viewData;
                    $this->mailTitle = $mailTitle;
                }

                public function build() {
                    return $this->subject($this->mailTitle)
                                ->view($this->viewName)
                                ->with($this->viewData);
                }
            };

    
            Mail::to($admin->email)->queue($mailable);

            $notification->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

        } catch (\Exception $e) {
            Log::error("Failed to queue notification: " . $e->getMessage());
            
            $notification->update([
                'status' => 'failed',
                'data' => array_merge($data, ['error' => $e->getMessage()]),
            ]);
        }
    }

    public function getNotificationsForAdmin(int $adminId, int $limit = 10)
    {
        return Notification::forAdmin($adminId)
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getUnreadCount(int $adminId): int
    {
        return Notification::forAdmin($adminId)->unread()->count();
    }

    public function markAllAsRead(int $adminId): int
    {
        return Notification::forAdmin($adminId)
            ->unread()
            ->update(['read_at' => now()]);
    }
}