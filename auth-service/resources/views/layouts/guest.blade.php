<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Coop Tracker')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    {{-- Load the RTL build of Bootstrap when the locale is Arabic --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap{{ app()->getLocale() === 'ar' ? '.rtl' : '' }}.min.css" rel="stylesheet">

    {{-- Arabic font used by the shared theme in RTL mode --}}
    @if (app()->getLocale() === 'ar')
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    {{-- Shared team theme --}}
    <link href="{{ asset('css/coop.css') }}" rel="stylesheet">
    <style>
        /* Page-specific tweaks only; colours come from the theme tokens */
        .brand-panel { background: var(--navy); color: #fff; }
        .brand-panel .tagline { color: #C3D3E2; }
        .brand-panel .sidebar-logo img { height: 64px; width: auto; filter: none; }
        .auth-wrap { max-width: 380px; width: 100%; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row min-vh-100">

        {{-- Brand side: logo, project name and short description --}}
        <div class="col-md-6 brand-panel d-flex flex-column justify-content-center align-items-center text-center p-5">
            {{-- Logo on the left, project name beside it --}}
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                <div class="sidebar-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Coop Tracker logo">
                </div>
                <h1 class="display-5 fw-bold mb-0">Coop Tracker</h1>
            </div>
            <p class="tagline fs-5 mb-0">{{ __('messages.tagline') }}</p>
        </div>

        {{-- Form side: the page content (login or sign up form) --}}
        <div class="col-md-6 d-flex flex-column justify-content-center align-items-center p-4 position-relative">
            <div class="position-absolute top-0 end-0 p-3">
                <a href="/lang/en" class="text-decoration-none">EN</a> |
                <a href="/lang/ar" class="text-decoration-none">العربية</a>
            </div>

            <div class="auth-wrap">
                @yield('content')
            </div>
        </div>

    </div>
</div>
</body>
</html>