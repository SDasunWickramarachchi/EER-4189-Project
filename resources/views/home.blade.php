<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ashan Rumaiz Photography | Home</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
               :class="{ active: link.label === 'Home' }">{{ link.label }}</a>
            <a href="/booking" class="btn btn-small">Book Now</a>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h1>Capturing the Best Moments of your Life</h1>
                <p>Honest. Timeless. Unforgettable. We capture real moments and turn
                   them into memories that last a lifetime.</p>
                <a href="/booking" class="btn">Book Now</a>
            </div>
        </section>

        <section class="capture">
            <h2>What We Capture</h2>
            <div class="card-grid">
                <a class="card" v-for="s in services" :key="s.title" :href="s.link">
                    <span class="card-icon" aria-hidden="true">{{ s.icon }}</span>
                    <h3>{{ s.title }}</h3>
                    <p>{{ s.text }}</p>
                </a>
            </div>
        </section>

        <section class="gallery">
            <button class="gallery-item" v-for="(img, i) in gallery" :key="img.src"
                    @click="lightbox = i" :aria-label="'Open photo: ' + img.alt">
                <img :src="img.src" :alt="img.alt" loading="lazy">
            </button>
        </section>

        <section class="story">
            <div class="story-inner">
                <span class="story-number">{{ years }}</span>
                <div>
                    <h2>years of telling real stories, honestly!!!</h2>
                    <p>Ashan Rumaiz Photography has spent the last decade capturing weddings,
                       milestone events, newborns, and family portraits across Sri Lanka:
                       candid, warm, and true to the moment as it happened.</p>
                    <a href="/about" class="btn">Read My Story</a>
                </div>
            </div>
        </section>

        <section class="behind-lens">
            <img src="/images/photographer.jpg" alt="Ashan editing photos at his desk">
        </section>

        <section class="reviews">
            <h2>What Our Clients Say</h2>
            <p class="reviews-sub">Real moments, real emotions. Hear from the people we have worked with.</p>

            <div class="review-grid">
                <figure class="review" v-for="r in reviews" :key="r.name">
                    <figcaption>{{ r.name }}</figcaption>
                    <blockquote>{{ r.text }}</blockquote>
                </figure>
            </div>
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
            <p>Wedding, event, portrait and lifestyle photography from a home studio,
               with a decade of experience behind every shoot.</p>
        </div>

        <div class="footer-links">
            <h4>Explore</h4>
            <a href="/portfolio">Portfolio</a>
            <a href="/services">Services</a>
            <a href="/packages">Packages</a>
            <a href="/about">About Us</a>
        </div>

        <div class="footer-contact">
            <h4>Contact</h4>
            <p>+94 77 123 4567</p>
            <p>info@ashanrumaiz.lk</p>
            <p>Colombo, Sri Lanka</p>
        </div>
    </footer>

    <div class="lightbox" v-if="lightbox !== null" @click.self="closeLightbox"
         role="dialog" aria-modal="true">
        <button class="lb-close" @click="closeLightbox" aria-label="Close">&times;</button>
        <button class="lb-nav prev" @click="step(-1)" aria-label="Previous photo">&#8249;</button>
        <img :src="gallery[lightbox].src" :alt="gallery[lightbox].alt">
        <button class="lb-nav next" @click="step(1)" aria-label="Next photo">&#8250;</button>
    </div>

</div>
@endverbatim

<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>



