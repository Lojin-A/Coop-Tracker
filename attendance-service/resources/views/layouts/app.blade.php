<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') · Coop Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap{{ app()->getLocale() == 'ar' ? '.rtl' : '' }}.min.css" rel="stylesheet">
    <link href="{{ asset('css/coop.css') }}" rel="stylesheet">
    <style>
        /* Only what coop.css doesn't cover: the sidebar needs a fixed width
           because it uses position: fixed (coop.css's flex-based width
           doesn't apply to fixed-position elements). */
        .sidebar { width: 220px; }

        /* coop.css forces every sidebar logo to solid white via
           brightness(0) invert(1). We want this specific logo to keep its
           own color instead, so this cancels just that one filter — the
           shared coop.css file itself is left untouched. */
        .sidebar-logo img { filter: none; }
    </style>
</head>
<body>
<div class="d-flex">
    <nav class="sidebar vh-100 position-fixed">
        <div class="sidebar-logo mb-3 d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo-mark-light.png') }}" alt="Coop Tracker">
            <span class="fw-bold" style="color: #fff; font-size: 20px;">Coop Tracker</span>
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
