<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Coop Tracker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/coop.css') }}" rel="stylesheet">

</head>
<body>

    <div class="d-flex flex-wrap min-vh-100">

        <nav class="sidebar" aria-label="Main">

            <div class="d-flex align-items-center gap-2 px-2 pb-4">
                <img src="{{ asset('images/logo-mark-light.png') }}" alt="" width="40" height="40">
                <span class="fw-bold" style="font-size: 17px;">Coop Tracker</span>
            </div>

            @include('partials.sidemenu')
        </nav>

        <main class="main">
            <p class="eyebrow mb-1">@yield('role')</p>
            <h1 class="fw-bold mb-4" style="font-size: 28px;">@yield('title')</h1>
            @yield('content')
        </main>

    </div>

</body>
</html>