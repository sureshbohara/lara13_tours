<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
   
    @inertiaHead

    @php

        $siteSetting = isset($page) && isset($page['props']['setting']) ? $page['props']['setting'] : null;
    @endphp

    <title>{{ $siteSetting['meta_title'] ?? ($siteSetting['system_name'] ?? 'SP Travel and Tours') }}</title>
    
    @if(!empty($siteSetting['favicon_url']))
        <link rel="icon" type="image/x-icon" href="{{ $siteSetting['favicon_url'] }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('default/noimage.png') }}">
    @endif

    @if(!empty($siteSetting['meta_description']))
        <meta name="description" content="{{ $siteSetting['meta_description'] }}">
    @endif
    @if(!empty($siteSetting['meta_keywords']))
        <meta name="keywords" content="{{ $siteSetting['meta_keywords'] }}">
    @endif

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @routes

    @viteReactRefresh

    @vite(['resources/js/app.jsx', "resources/js/Pages/" . ($page['component'] ?? 'Home') . ".jsx"])
</head>
<body class="antialiased text-slate-800 bg-white">
    @inertia
</body>
</html>