<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin') | Ashan Rumaiz Photography</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Source+Serif+4:wght@400;500&display=swap">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.19.0/dist/tabler-icons.min.css">
        <link rel="stylesheet" href="/css/admin-layout.css">
        @stack('styles')

        <script src="/js/admin-guard.js"></script>
    </head>
<body>
    <div class="admin-shell">
        @include('admin.partials.sidebar')
        <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

        <div class="admin-main">
            @include('admin.partials.topbar')

            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>

    <script src= "/js/admin-layout.js"></script>
    @stack('scripts')
</body>
</html>