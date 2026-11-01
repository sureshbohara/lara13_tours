<?php

declare(strict_types=1);

namespace App\Traits;

trait HasImages
{
    protected function imageUrl(?string $path): string
    {
        if (blank($path)) {
            return asset('default/noimage.png');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('images/' . ltrim($path, '/'));
    }

    public function getImageUrlAttribute(): string { return $this->imageUrl($this->image); }

    public function getFeatureImageUrlAttribute(): string { return $this->imageUrl($this->feature_image); }

    public function getLogoUrlAttribute(): string { return $this->imageUrl($this->logo); }

    public function getFaviconUrlAttribute(): string { return $this->imageUrl($this->favicon); }

    public function getLoaderUrlAttribute(): string { return $this->imageUrl($this->loader); }

    public function getBgImageUrlAttribute(): string { return $this->imageUrl($this->bg_image); }

    public function getFooterGatewayImgUrlAttribute(): string { return $this->imageUrl($this->footer_gateway_img); }

    public function getBreadcrumbUrlAttribute(): string { return $this->imageUrl($this->breadcrumb); }

    public function getImage1UrlAttribute(): string { return $this->imageUrl($this->image1); }
    
    public function getImage2UrlAttribute(): string { return $this->imageUrl($this->image2); }
}