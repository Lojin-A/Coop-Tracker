<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') · Coop Tracker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy:   #123B5D;
            --accent: #1D6FA5;
            --teal:   #35B8A6;
            --ink:    #172B3A;
            --muted:  #718096;
            --line:   #E2E8F0;
            --track:  #EDF2F7;
            --warn:   #8A3B07;
        }

        body {
            background: #F5F8FA;
            color: var(--ink);
            font-family: 'IBM Plex Sans', system-ui, sans-serif;
        }

        .num { font-family: 'IBM Plex Mono', monospace; }

        .sidebar {
            flex: 1 1 220px;
            background: var(--navy);
            color: #E6EEF5;
            padding: 24px 16px;
        }

        .sidebar a {
            display: block;
            color: #C3D3E2;
            text-decoration: none;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 6px;
        }

        .sidebar a.active {
            color: #fff;
            background: rgba(53, 184, 166, 0.22);
            font-weight: 600;
        }

        .main { flex: 999 1 560px; min-width: 0; padding: 32px; }

        .card { border: 1px solid var(--line); border-radius: 12px; }
        .card-body { padding: 20px; }

        .eyebrow {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .btn-accent { background: var(--accent); color: #fff; }
        .btn-accent:hover { background: var(--navy); color: #fff; }

        .text-muted-2 { color: var(--muted); }
        .text-warn    { color: var(--warn); }
        .text-accent  { color: var(--accent); }

        .badge-late {
            background: #FCE9DC;
            color: var(--warn);
            padding: 3px 10px;
            border-radius: 999px;
            font-weight: 600;
        }
    </style>
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