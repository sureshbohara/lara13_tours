<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;

#[Fillable([
    'system_name',
    'email',
    'extra_email',
    'phone',
    'extra_phone',
    'address',
    'opening_hr',
    'work_hours',
    'google_map',
    'footer_copyright',
    'facebook',
    'twitter',
    'linkedin',
    'instagram',
    'youtube',
    'google',
    'yelp',
    'logo',
    'favicon',
    'loader',
    'footer_gateway_img',
    'bg_image',
    'breadcrumb',
    'image1',
    'image2',
    'meta_author',
    'meta_title',
    'meta_keywords',
    'meta_description',
    'info1',
    'info2',
    'info3',
    'info4',
    'info5',
    'info6',
    'info7',
    'mail_transport',
    'mail_host',
    'mail_port',
    'mail_username',
    'mail_password',
    'mail_encryption',
    'mail_from',
    'mail_from_name',
    'smtp_check',
    'recaptcha_site_key',
    'recaptcha_secret_key',
    'is_recaptcha',
    'google_analytic_id',
    'google_client_id',
    'google_client_secret',
    'google_redirect',
    'is_google',
    'facebook_analytic_id',
    'facebook_client_id',
    'facebook_client_secret',
    'facebook_redirect',
    'is_facebook',
    'live_chat_provider',
    'live_chat_code',
    'is_live_chat',
    'process_title',
    'process_sub_title',
    'process_item',
    'work_title',
    'work_sub_title',
    'work_item',
    'counter_title',
    'counter_sub_title',
    'counter_item',
])]
class Setting extends Model
{
    use HasFactory, HasImages;

    /**
     * The table associated with the model.
     */
    protected $table = 'settings';

    protected function casts(): array
    {
        return [
            'process_item' => 'array',
            'work_item' => 'array',
            'counter_item' => 'array',
            'smtp_check' => 'boolean',
            'is_recaptcha' => 'boolean',
            'is_google' => 'boolean',
            'is_facebook' => 'boolean',
            'is_live_chat' => 'boolean',
        ];
    }


    public static function getInstance(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            ['system_name' => config('app.name')]
        );
    }
}