<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\Paginator;
use Illuminate\Contracts\Auth\Authenticatable;

use App\Models\Admin;
use App\Services\Admin\SettingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Bootstrap 5 Pagination Style
        Paginator::useBootstrapFive();

        // 2. Custom Gate for Admin Permissions 
        Gate::before(function (Authenticatable $user, string $ability) {
            if (!$user instanceof Admin) {
                return null;
            }

            // Super Admin All permission automatically 
            if ($user->isSuperAdmin()) {
                return true;
            }

            // Ability format 'entity.action' (like: 'user.read')  skip 
            if (!str_contains($ability, '.')) {
                return null;
            }

            [$entity, $action] = explode('.', $ability, 2);
            $perms = $user->permissionRecord?->permissions ?? [];

            return isset($perms[$entity][$action]) && $perms[$entity][$action] === '1';
        });

        // 3. Dynamic Settings & Mail Configuration
        try {
            $settingsData = app(SettingService::class)->getSettings();

            if ($settingsData) {

                View::share('setting', (object) $settingsData);

                if (!empty($settingsData['smtp_check']) && !empty($settingsData['mail_host'])) {
                    Config::set('mail.default', 'smtp');
                    Config::set('mail.mailers.smtp.transport', $settingsData['mail_transport'] ?? 'smtp');
                    Config::set('mail.mailers.smtp.host', $settingsData['mail_host']);
                    Config::set('mail.mailers.smtp.port', (int) ($settingsData['mail_port'] ?? 587));
                    Config::set('mail.mailers.smtp.encryption', $settingsData['mail_encryption'] ?? 'tls');
                    
                    if (!empty($settingsData['mail_username'])) {
                        Config::set('mail.mailers.smtp.username', $settingsData['mail_username']);
                        Config::set('mail.from.address', $settingsData['mail_username']);
                    }
                    
                    if (!empty($settingsData['mail_password'])) {
                        Config::set('mail.mailers.smtp.password', $settingsData['mail_password']);
                    }
                    
                    Config::set('mail.from.name', $settingsData['mail_from_name'] ?? 'Ez Property');
                }
            }
        } catch (\Exception $e) {

            Log::error('AppServiceProvider Settings Error: ' . $e->getMessage());
        }
    }
}