<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coop Tracker')</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">

    {{-- Load the RTL build of Bootstrap when the locale is Arabic --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap{{ app()->getLocale() === 'ar' ? '.rtl' : '' }}.min.css" rel="stylesheet">

    {{-- Arabic font used by the shared theme in RTL mode --}}
    @if (app()->getLocale() === 'ar')
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    @endif

    {{-- Shared team theme: must be loaded after Bootstrap so it overrides it --}}
    <link href="{{ asset('css/coop.css') }}" rel="stylesheet">
    <style>
        /* Show the logo in its original colours instead of forcing it white */
        .sidebar-logo img { filter: none; height: 40px; width: auto; }
    </style>
</head>
<body>
{{-- Accessibility: lets keyboard users jump straight to the main content --}}
<a href="#main" class="visually-hidden-focusable">{{ __('messages.skip') }}</a>

{{-- Every page that uses this layout is behind the auth middleware, so a user always exists --}}
@php $role = auth()->user()->role; @endphp

<div class="d-flex flex-wrap min-vh-100">

    {{-- Sidebar: menu items depend on the user's role --}}
    <aside class="sidebar">
        <div class="sidebar-logo d-flex align-items-center gap-2 mb-4">
            <img src="{{ asset('images/logo.png') }}" alt="Coop Tracker logo">
            <strong class="text-white">Coop Tracker</strong>
        </div>

        <nav aria-label="{{ __('messages.nav_label') }}">
            {{-- TODO: point this link to the Dashboard service --}}
            <a href="#">{{ __('messages.dashboard') }}</a>
            @if ($role === 'coordinator')
                <a href="/companies" class="{{ request()->is('companies*') ? 'active' : '' }}">{{ __('messages.companies') }}</a>
                <a href="/placements" class="{{ request()->is('placements*') ? 'active' : '' }}">{{ __('messages.placements') }}</a>
                <a href="/students" class="{{ request()->is('students*') ? 'active' : '' }}">{{ __('messages.students') }}</a>
                <a href="/supervisors" class="{{ request()->is('supervisors*') ? 'active' : '' }}">{{ __('messages.supervisors') }}</a>
            @elseif ($role === 'supervisor')
                <a href="/placements" class="{{ request()->is('placements*') ? 'active' : '' }}">{{ __('messages.my_students') }}</a>
            @else
                <a href="/placements" class="{{ request()->is('placements*') ? 'active' : '' }}">{{ __('messages.my_placement') }}</a>
            @endif
        </nav>
    </aside>

    <main id="main" class="main">
        {{-- Top row: user name and role on one side, language switcher and logout on the other --}}
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <div class="eyebrow">{{ __('messages.role_' . $role) }}</div>
                <div class="fw-semibold">{{ auth()->user()->name }}</div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div>
                    <a href="/lang/en" class="text-decoration-none">EN</a> |
                    <a href="/lang/ar" class="text-decoration-none">العربية</a>
                </div>

                {{-- Logout must be a POST form with a CSRF token --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-quiet btn-sm">{{ __('messages.logout') }}</button>
                </form>
            </div>
        </div>

        {{-- Flash messages set by the controllers --}}
        @if (session('success'))
            <div class="alert alert-success mt-3">{{ __(session('success')) }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger mt-3">{{ __(session('error')) }}</div>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>