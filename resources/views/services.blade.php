<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Ashan Rumaiz Photography</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
</head>
<body>

@verbatim
<div id="app">

    <header class="site-header">
        <a href="/" class="logo">
            <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
        </a>

        <nav class="main-nav">
            <a v-for="link in navLinks" :key="link.label" :href="link.href"
               :class="{ active: link.label === 'Services' }">{{ link.label }}</a>
            <a href="/booking" class="btn btn-small">Book Now</a>
        </nav>
    </header>

    <main>

        <section class="page-title">
            <h1>Tailored Memories.</h1>
            <p>Genuine moments, thoughtfully captured. Explore the photography services designed to hold onto what matters most.</p>
        </section>

        <section class="service-band" v-for="(s, i) in services" :key="s.title"
                 :class="[s.band, { reverse: i % 2 === 1 }]">
            <div class="service-text">
                <h2>{{ s.title }}</h2>
                <p>{{ s.text }}</p>
                <a :href="s.link" class="btn" :class="s.button">Inquire For Full Detail Package</a>
            </div>
            <img class="service-photo" :src="s.image" :alt="s.alt">
        </section>

        <section class="booking-details">
            <h2>Booking Details</h2>
            <p>A 50% non-refundable deposit is required to secure your requested dates. The remaining balance is due prior to the delivery of final assets.</p>
            <a href="/booking" class="btn btn-slate">Book Now</a>
        </section>
    </main>

    <footer class="site-footer">
        <div class="footer-brand">
            <a href="/" class="logo">
                <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
            </a>
        </div>

        <div class="footer-about">
            <h4>Ashan Rumaiz Photography</h4>
            <p>Ashan Rumaiz Photography provides professional photography services in Sri Lanka. We capture every moment with warmth, precision, and a personal touch from first frame to lifetime.</p>
        </div>

        <div class="footer-links">
            <h4>Explore</h4>
            <a href="/portfolio">Portfolio</a>
            <a href="/services">Services</a>
            <a href="/packages">Packages</a>
            <a href="/about">About Us</a>
            <a href="/contact">Contact</a>
        </div>

        <div class="footer-contact">
            <h4>Contact Us</h4>
            <p>+94 77 123 4567</p>
            <p>info@ashanrumaiz.lk</p>
            <p>Colombo, Sri Lanka</p>
        </div>
    </footer>

</div>
@endverbatim

<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js"></script>
<script src="{{ asset('js/services.js') }}"></script>
<script src="{{ asset('js/chatbot.js') }}"></script>
</body>
</html>


