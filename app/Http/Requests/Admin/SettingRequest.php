<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

 
    public function rules(): array
    {
        $rules = [];

        // ==========================================
        // 1. Image Fields
        // ==========================================
        foreach ([
            'logo',
            'favicon',
            'loader',
            'footer_gateway_img',
            'bg_image',
            'breadcrumb',
            'image1',
            'image2',
        ] as $field) {
            $rules[$field] = 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048';
        }

        // ==========================================
        // 2. General Information
        // ==========================================
        $rules['system_name'] = 'nullable|string|max:191';
        $rules['email'] = 'nullable|email|max:191';
        $rules['extra_email'] = 'nullable|email|max:191';
        $rules['phone'] = 'nullable|string|max:50';
        $rules['extra_phone'] = 'nullable|string|max:50';
        $rules['address'] = 'nullable|string|max:500';
        $rules['opening_hr'] = 'nullable|string|max:100';
        $rules['work_hours'] = 'nullable|string|max:100';
        $rules['google_map'] = 'nullable|string';
        $rules['footer_copyright'] = 'nullable|string|max:191';

        // ==========================================
        // 3. Social Links
        // ==========================================
        foreach ([
            'facebook',
            'twitter',
            'linkedin',
            'instagram',
            'youtube',
            'google',
            'yelp',
        ] as $field) {
            $rules[$field] = 'nullable|url|max:191';
        }

        // ==========================================
        // 4. SEO Meta Tags
        // ==========================================
        $rules['meta_author'] = 'nullable|string|max:191';
        $rules['meta_title'] = 'nullable|string|max:191';
        $rules['meta_keywords'] = 'nullable|string|max:500';
        $rules['meta_description'] = 'nullable|string|max:1000';

        // ==========================================
        // 5. Info Blocks (1-7)
        // ==========================================
        for ($i = 1; $i <= 7; $i++) {
            $rules["info{$i}"] = 'nullable|string';
        }

        // ==========================================
        // 6. SMTP / Mail Configuration
        // ==========================================
        $rules['mail_transport'] = 'nullable|string|max:50';
        $rules['mail_host'] = 'nullable|string|max:191';
        $rules['mail_port'] = 'nullable|integer|min:1|max:65535';
        $rules['mail_username'] = 'nullable|string|max:191';
        $rules['mail_password'] = 'nullable|string|max:191';
        $rules['mail_encryption'] = 'nullable|string|max:10|in:tls,ssl,null';
        $rules['mail_from'] = 'nullable|email|max:191';
        $rules['mail_from_name'] = 'nullable|string|max:191';
        $rules['smtp_check'] = 'nullable|boolean';

        // ==========================================
        // 7. Recaptcha
        // ==========================================
        $rules['recaptcha_site_key'] = 'nullable|string|max:191';
        $rules['recaptcha_secret_key'] = 'nullable|string|max:191';
        $rules['is_recaptcha'] = 'nullable|boolean';

        // ==========================================
        // 8. Google API & Analytics
        // ==========================================
        $rules['google_analytic_id'] = 'nullable|string|max:50';
        $rules['google_client_id'] = 'nullable|string|max:191';
        $rules['google_client_secret'] = 'nullable|string|max:191';
        $rules['google_redirect'] = 'nullable|url|max:191';
        $rules['is_google'] = 'nullable|boolean';

        // ==========================================
        // 9. Facebook API & Analytics
        // ==========================================
        $rules['facebook_analytic_id'] = 'nullable|string|max:50';
        $rules['facebook_client_id'] = 'nullable|string|max:191';
        $rules['facebook_client_secret'] = 'nullable|string|max:191';
        $rules['facebook_redirect'] = 'nullable|url|max:191';
        $rules['is_facebook'] = 'nullable|boolean';

        
        $rules['live_chat_provider'] = 'nullable|in:tawk,custom';
        $rules['live_chat_code'] = 'nullable|string';
        $rules['is_live_chat'] = 'nullable|boolean';

        // ==========================================
        // 10. Process Section
        // ==========================================
        $rules['process_title'] = 'nullable|string|max:191';
        $rules['process_sub_title'] = 'nullable|string';
        $rules['process_item'] = 'nullable|array';
        $rules['process_item.*.icon'] = 'nullable|string|max:100';
        $rules['process_item.*.title'] = 'nullable|string|max:191';
        $rules['process_item.*.content'] = 'nullable|string';

        // ==========================================
        // 11. Work Section
        // ==========================================
        $rules['work_title'] = 'nullable|string|max:191';
        $rules['work_sub_title'] = 'nullable|string';
        $rules['work_item'] = 'nullable|array';
        $rules['work_item.*.icon'] = 'nullable|string|max:100';
        $rules['work_item.*.title'] = 'nullable|string|max:191';
        $rules['work_item.*.content'] = 'nullable|string';

        // ==========================================
        // 12. Counter Section 
        // ==========================================
        $rules['counter_title'] = 'nullable|string|max:191';
        $rules['counter_sub_title'] = 'nullable|string';
        $rules['counter_item'] = 'nullable|array';
        $rules['counter_item.*.icon'] = 'nullable|string|max:100';
        $rules['counter_item.*.title'] = 'nullable|string|max:191';
        $rules['counter_item.*.content'] = 'nullable|string';





        return $rules;
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'email.email' => 'Please enter a valid email address.',
            'extra_email.email' => 'Please enter a valid secondary email address.',
            'mail_from.email' => 'Please enter a valid "From" email address.',
            'mail_port.integer' => 'Mail port must be a number.',
            'mail_port.min' => 'Mail port must be at least 1.',
            'mail_port.max' => 'Mail port must not exceed 65535.',
            'mail_encryption.in' => 'Mail encryption must be tls, ssl, or null.',
            'facebook.url' => 'Please enter a valid Facebook URL.',
            'twitter.url' => 'Please enter a valid Twitter URL.',
            'linkedin.url' => 'Please enter a valid LinkedIn URL.',
            'instagram.url' => 'Please enter a valid Instagram URL.',
            'youtube.url' => 'Please enter a valid YouTube URL.',
            'google.url' => 'Please enter a valid Google URL.',
            'yelp.url' => 'Please enter a valid Yelp URL.',
            'google_redirect.url' => 'Please enter a valid Google redirect URL.',
            'facebook_redirect.url' => 'Please enter a valid Facebook redirect URL.',
            'logo.image' => 'Logo must be an image file.',
            'logo.max' => 'Logo must not exceed 2MB.',
            'favicon.image' => 'Favicon must be an image file.',
            'favicon.max' => 'Favicon must not exceed 2MB.',
        ];
    }

    /**
     * Custom attribute names for validation messages.
     */
    public function attributes(): array
    {
        return [
            'system_name' => 'system name',
            'extra_email' => 'secondary email',
            'extra_phone' => 'secondary phone',
            'opening_hr' => 'opening hours',
            'work_hours' => 'work hours',
            'google_map' => 'Google Map embed URL',
            'footer_copyright' => 'footer copyright',
            'meta_author' => 'meta author',
            'meta_title' => 'meta title',
            'meta_keywords' => 'meta keywords',
            'meta_description' => 'meta description',
            'mail_transport' => 'mail transport',
            'mail_host' => 'SMTP host',
            'mail_port' => 'mail port',
            'mail_username' => 'mail username',
            'mail_password' => 'mail password',
            'mail_encryption' => 'mail encryption',
            'mail_from' => 'from email',
            'mail_from_name' => 'from name',
            'recaptcha_site_key' => 'reCAPTCHA site key',
            'recaptcha_secret_key' => 'reCAPTCHA secret key',
            'google_analytic_id' => 'Google Analytics ID',
            'google_client_id' => 'Google client ID',
            'google_client_secret' => 'Google client secret',
            'google_redirect' => 'Google redirect URI',
            'facebook_analytic_id' => 'Facebook pixel ID',
            'facebook_client_id' => 'Facebook client ID',
            'facebook_client_secret' => 'Facebook client secret',
            'facebook_redirect' => 'Facebook redirect URI',
            'process_title' => 'process section title',
            'process_sub_title' => 'process section subtitle',
            'work_title' => 'work section title',
            'work_sub_title' => 'work section subtitle',
            'counter_title' => 'counter section title',
            'counter_sub_title' => 'counter section subtitle',
        ];
    }
}