<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

#[Fillable([
    'admin_id',
    'ip_address',
    'user_agent',
    'os',
    'browser',
    'device_type',
    'login_at',
    'logout_at',
])]
class LoginActivity extends Model
{
    use HasFactory;

    protected $table = 'login_activities';

    protected function casts(): array
    {
        return [
            'admin_id'  => 'integer',
            'login_at'  => 'datetime',
            'logout_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('logout_at');
    }

    public function scopeLatestLogin($query)
    {
        return $query->latest('login_at');
    }

    public static function recordLogin(Admin $admin, Request $request): self
    {
        $agent = new Agent();
        $agent->setUserAgent($request->userAgent() ?? '');

        return self::create([
            'admin_id'    => $admin->id,
            'ip_address'  => $request->ip(),
            'user_agent'  => $request->userAgent(),
            'os'          => $agent->platform() ?: 'Unknown',
            'browser'     => $agent->browser() ?: 'Unknown',
            'device_type' => self::getDeviceType($agent),
            'login_at'    => now(),
        ]);
    }

    public static function recordLogout(?int $adminId): void
    {
        if (!$adminId) {
            return;
        }

        self::where('admin_id', $adminId)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first()
            ?->update(['logout_at' => now()]);
    }

    private static function getDeviceType(Agent $agent): string
    {
        if ($agent->isPhone()) {
            return 'mobile';
        }
        if ($agent->isTablet()) {
            return 'tablet';
        }
        return 'desktop';
    }
}