<?php

declare(strict_types=1);

if (!function_exists('setting')) {
    /**
     * Get a setting value by key.
     *
     * @param  string|null  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting(?string $key = null, mixed $default = null): mixed
    {
        $setting = \App\Models\Setting::getInstance();

        if ($key === null) {
            return $setting;
        }

        return $setting->{$key} ?? $default;
    }
}