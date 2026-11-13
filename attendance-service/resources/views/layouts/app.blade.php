<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') · {{ __('attendance.app_name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap{{ app()->getLocale() == 'ar' ? '.rtl' : '' }}.min.css" rel="stylesheet">
    <style>
        body { background: #f4f5f3; }
        .sidebar { width: 220px; background: #0b2a4a; }
        .sidebar .nav-link { color: rgba(255,255,255,.65); }
        .sidebar .nav-link.active { color: #fff; font-weight: 600; }
        .brand-dot { width: 28px; height: 28px; background: #1f9a8e; border-radius: 6px; }
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="sidebar vh-100 p-3 position-fixed">
        <div class="d-flex align-items-center gap-2 mb-4 text-white">
            <img src="{{ asset('images/logo.png') }}" alt="Coop Tracker" style="height: 44px; width: auto;">
            <strong>{{ __('attendance.app_name') }}</strong>
        </div>
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item"><a class="nav-link" href="#">{{ __('attendance.sidebar_dashboard') }}</a></li>
            @yield('sidebar-links')
        </ul>
    </nav>

    <div class="flex-grow-1 p-4" style="margin-inline-start: 220px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">@yield('title')</h3>
            <div>
                <a href="{{ route('lang.switch', 'en') }}" class="link-secondary text-decoration-none">EN</a>
                <span class="text-muted">|</span>
                <a href="{{ route('lang.switch', 'ar') }}" class="link-secondary text-decoration-none">العربية</a>
            </div>
        </div>
        @yield('content')
    </div>
</div>
</body>
</html>
