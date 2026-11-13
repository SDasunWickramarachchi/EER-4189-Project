@php
    // label, address, icon name. Add a new admin page here and it appears in the menu on every page.
    $menu = [
        ['Dashboard',        '/admin/dashboard',        'layout-dashboard'],
        ['Booking',          '/admin/booking',          'notebook'],
        ['Portfolio',        '/admin/portfolio',        'photo'],
        ['Inquiries',        '/admin/inquiries',        'mail'],
        ['Services',         '/admin/services',         'aperture'],
        ['Packages',         '/admin/packages',         'package'],
        ['Calendar',         '/admin/calendar',         'calendar'],
        ['Chatbot Settings', '/admin/chatbot-settings', 'robot'],
        ['Reviews',          '/admin/reviews',          'star'],
        ['Settings',         '/admin/settings',         'settings'],
    ];
@endphp

<aside class="sidebar" id="sidebar" aria-label="Admin navigation">
    <a class="brand" href="/admin">
        <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
    </a>

    <p class="console-label">ADMIN CONSOLE</p>

    <nav>
        <ul>
            @foreach ($menu as [$label, $href, $icon])
                @php $active = request()->is(trim($href, '/') . '*'); @endphp
                <li>
                    <a href="{{ $href }}" class="{{ $active ? 'active' : '' }}" @if ($active) aria-current="page" @endif>
                        <i class="ti ti-{{ $icon }}" aria-hidden="true"></i>
                        <span>{{ $label }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <button type="button" class="logout" id="logout-button">
        <i class="ti ti-logout" aria-hidden="true"></i>
        <span>Log Out</span>
    </button>
</aside>