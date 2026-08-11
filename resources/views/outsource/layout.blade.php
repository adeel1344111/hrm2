<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-mode="dark">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Outsource') — Mighty Knights HRM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ URL::to('assets/images/favicon_new.png') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/hrm-system.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body.outsource-body {
            min-height: 100vh;
            background: #0f172a;
            color: #e2e8f0;
        }
        .outsource-nav {
            background: #1e293b;
            border-bottom: 1px solid #334155;
        }
        .outsource-nav a.active {
            color: #60a5fa;
        }
    </style>
    @yield('head')
</head>
<body class="outsource-body text-slate-100">
    @if(session('outsource_login_access'))
    <header class="outsource-nav sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-3 flex flex-wrap items-center gap-4 justify-between">
            <div class="flex items-center gap-3">
                <span class="font-semibold text-white">{{ session('outsource_company_name') }}</span>
                <span class="text-xs text-slate-400">Outsource Portal</span>
            </div>
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('outsource.submissions') }}" class="{{ request()->routeIs('outsource.submissions') ? 'active' : 'text-slate-300 hover:text-white' }}">Today Submissions</a>
                <a href="{{ route('outsource.report') }}" class="{{ request()->routeIs('outsource.report') ? 'active' : 'text-slate-300 hover:text-white' }}">Submissions Report</a>
                <form method="POST" action="{{ route('outsource.logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-slate-400 hover:text-red-400">Logout</button>
                </form>
            </nav>
        </div>
    </header>
    @endif

    <main class="@yield('main_class', 'max-w-7xl mx-auto px-4 py-6')">
        @if(session('error'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-red-500/15 border border-red-500/40 text-red-300 text-sm">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/15 border border-green-500/40 text-green-300 text-sm">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <script>if (window.lucide) lucide.createIcons();</script>
    @yield('script')
</body>
</html>
