<?php

declare(strict_types=1);

namespace App\Services\Admin;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteHealthService
{
    public function getServerInfo(): array
    {
        return Cache::remember('server_info', now()->addHours(24), function () {
            return [
                'PHP Version'             => phpversion(),
                'Server Architecture'     => php_uname('m'),
                'Web Server'              => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'PHP SAPI'                => php_sapi_name(),
                'PHP Max Input Variables' => ini_get('max_input_vars'),
                'PHP Time Limit'          => ini_get('max_execution_time') . ' sec',
                'PHP Memory Limit'        => ini_get('memory_limit'),
                'PHP Upload Max Filesize' => ini_get('upload_max_filesize'),
                'PHP Post Max Size'       => ini_get('post_max_size'),
                'MySQL Version'           => $this->getMySQLVersion(),
                'Database Charset'        => 'utf8mb4',
                'Server Timezone'         => date_default_timezone_get(),
                'Site URL'                => config('app.url'),
                'Is HTTPS Enabled'        => $this->isHttpsEnabled(),
            ];
        });
    }

    public function getDirectorySizes(): array
    {
        return Cache::get('directory_sizes', [
            'public'  => 'Calculating...',
            'storage' => 'Calculating...',
            'uploads' => 'Calculating...',
        ]);
    }

    public function getSiteHealthStatus(): array
    {
        $cacheStatus = 'No';
        try {
            Cache::put('health_check_test', 'ok', 10);
            Cache::forget('health_check_test');
            $cacheStatus = 'Yes';
        } catch (\Exception $e) {
            $cacheStatus = 'Error';
        }

        return [
            'Site is online'          => 'Yes',
            'Cache Working'           => $cacheStatus,
            'Disk Space Usage'        => $this->getDiskSpace(),
            'Required PHP Extensions' => $this->checkRequiredPHPExtensions(),
            'Database Connection'     => $this->checkDatabaseConnection(),
        ];
    }

    public function getDiskSpaceChartData(): array
    {
        $logs = \App\Models\DiskUsageLog::orderBy('log_date', 'desc')
            ->limit(7)
            ->get()
            ->reverse();

        return [
            'labels' => $logs->pluck('log_date')->map(fn($date) => \Carbon\Carbon::parse($date)->format('M d'))->toArray(),
            'data'   => $logs->pluck('used_bytes')->toArray(),
        ];
    }

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    private function getDiskSpace(): string
    {
        try {
            $totalSpace = disk_total_space(base_path());
            $freeSpace = disk_free_space(base_path());
            $usedSpace = $totalSpace - $freeSpace;
            return $this->formatBytes((int)$usedSpace) . ' / ' . $this->formatBytes((int)$totalSpace);
        } catch (\Exception $e) {
            return 'Error calculating';
        }
    }

    private function checkRequiredPHPExtensions(): string
    {
        $required = ['mbstring', 'openssl', 'pdo', 'curl', 'xml'];
        $missing = array_filter($required, fn($ext) => !extension_loaded($ext));
        return empty($missing) ? 'All installed' : 'Missing: ' . implode(', ', $missing);
    }

    private function checkDatabaseConnection(): string
    {
        try {
            DB::connection()->getPdo();
            return 'Connected';
        } catch (\Exception $e) {
            return 'Failed';
        }
    }

    private function isHttpsEnabled(): string
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'Yes' : 'No';
    }

    private function getMySQLVersion(): string
    {
        try {
            return DB::selectOne('SELECT VERSION() as version')->version ?? 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
}