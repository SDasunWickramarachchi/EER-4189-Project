@php
    $links = [
        ['label' => 'Home',      'href' => '/',          'match' => '/'],
        ['label' => 'Portfolio', 'href' => '/portfolio', 'match' => 'portfolio*'],
        ['label' => 'Services',  'href' => '/services',  'match' => 'services*'],
        ['label' => 'Packages',  'href' => '/packages',  'match' => 'packages*'],
        ['label' => 'About',     'href' => '/about',     'match' => 'about*'],
        ['label' => 'Contact',   'href' => '/contact',   'match' => 'contact*'],
    ];
@endphp

<header class="site-header">
    <a href="/" class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="Ashan Rumaiz Photography">
    </a>

    <nav class="main-nav">
        @foreach ($links as $link)
            <a href="{{ $link['href'] }}" class="{{ request()->is($link['match']) ? 'active' : '' }}">{{ $link['label'] }}</a>
        @endforeach

        <a href="/booking" class="btn btn-small">Book Now</a>
    </nav>
</header>