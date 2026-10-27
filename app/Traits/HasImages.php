<?php

declare(strict_types=1);

namespace App\Traits;

trait HasImages
{
    /**
     * Get the image URL attribute.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!isset($this->image)) {
            return null;
        }

        return $this->resolveImage($this->image);
    }

    public function getFeatureImageUrlAttribute(): ?string
    {
        if (!isset($this->feature_image)) {
            return null;
        }

        return $this->resolveImage($this->feature_image);
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->resolveImage($this->logo ?? null);
    }


    public function getFaviconUrlAttribute(): string
    {
        return $this->resolveImage($this->favicon ?? null);
    }


    public function getLoaderUrlAttribute(): string
    {
        return $this->resolveImage($this->loader ?? null);
    }

    public function getBgImageUrlAttribute(): string
    {
        return $this->resolveImage($this->bg_image ?? null);
    }
    public function getFooterGatewayImgUrlAttribute(): string
    {
        return $this->resolveImage($this->footer_gateway_img ?? null);
    }


    public function getBreadcrumbUrlAttribute(): string
    {
        return $this->resolveImage($this->breadcrumb ?? null);
    }
    public function getImage1UrlAttribute(): string
    {
        return $this->resolveImage($this->image1 ?? null);
    }


    public function getImage2UrlAttribute(): string
    {
        return $this->resolveImage($this->image2 ?? null);
    }

    protected function resolveImage(?string $path): string
    {
        if (empty($path)) {
            return asset('default/noimage.png');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('images/' . $path);
    }
}