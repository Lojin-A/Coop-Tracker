<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title') | {{ __('reports.app_name') }}</title>
  @if (app()->getLocale() == 'ar')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  @else
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  @endif
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/coop.css') }}" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="d-flex flex-wrap min-vh-100">

  <aside class="sidebar">
    <a href="/" class="brand sidebar-logo">
      <img src="{{ asset('images/logo-mark-light.png') }}" alt="">
      <span>Coop Tracker</span>
    </a>
    <nav class="nav flex-column">
      <a class="nav-link {{ ($page ?? '') == 'reports' ? 'active' : '' }}" href="/reports">{{ __('reports.weekly_reports') }}</a>
      <a class="nav-link {{ ($page ?? '') == 'evaluations' ? 'active' : '' }}" href="/evaluations">{{ __('reports.evaluations') }}</a>
    </nav>
  </aside>

  <main class="main">
    <header class="d-flex justify-content-between align-items-start">
      <div>
        <p class="eyebrow mb-0">@yield('eyebrow')</p>
        <h1 class="page-title">@yield('title')</h1>
      </div>
      <div class="lang-switch">
        <a href="/lang/en" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
        <span class="text-muted mx-1">|</span>
        <a href="/lang/ar" class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">العربية</a>
      </div>
    </header>

    @yield('content')
  </main>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
