<?php

declare(strict_types=1);

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $packages = Package::where('status', true)->orderBy('updated_at', 'desc')->get();
        $blogs = Blog::where('status', true)->orderBy('updated_at', 'desc')->get();
        $pages = Page::where('status', true)->orderBy('updated_at', 'desc')->get();
        $categories = Category::where('status', true)->orderBy('updated_at', 'desc')->get();
        $services = Service::where('status', true)->orderBy('updated_at', 'desc')->get();

     
        $viewContent = view('sitemap.index', compact(
            'packages', 'blogs', 'pages', 'categories', 'services'
        ))->render();

       
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . $viewContent;

        return response($xml, 200)->header('Content-Type', 'text/xml');
    }
}