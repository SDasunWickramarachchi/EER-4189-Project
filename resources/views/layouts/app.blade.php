<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home') | Ashan Rumaiz Photography</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">

    @stack('styles')
</head>
<body>

@include('partials.navbar')

@yield('content')

@include('partials.footer')

@include('partials.chatbot')


<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js"></script>

@vite('resources/js/app.js')

@stack('scripts')

<script src="{{ asset('js/chatbot.js') }}"></script>
</body>
</html>

