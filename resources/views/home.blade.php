@extends('layouts.app')

@section('title', 'Home')

@section('content')
@verbatim
<div id="app">

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
                       milestone events, newborns, and family portraits across Sri Lanka.
                       Every frame is about the moment as it happened.</p>
                    <a href="/about" class="btn">Read My Story</a>
                </div>
            </div>

            <img class="story-photo" src="/images/photographer.jpg" alt="Ashan editing photos at his desk">
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

    <div class="lightbox" v-if="lightbox !== null" @click.self="closeLightbox"
         role="dialog" aria-modal="true">
        <button class="lb-close" @click="closeLightbox" aria-label="Close">&times;</button>
        <button class="lb-nav prev" @click="step(-1)" aria-label="Previous photo">&#8249;</button>
        <img :src="gallery[lightbox].src" :alt="gallery[lightbox].alt">
        <button class="lb-nav next" @click="step(1)" aria-label="Next photo">&#8250;</button>
    </div>

</div>
@endverbatim

@endsection

@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush


