@extends('layouts.app')

@section('title', 'Portfolio')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/portfolio.css') }}">
@endpush

@section('content')
<main>

    <section class="portfolio-hero" style="background-image: url('{{ asset('images/portfolio/portfolio.jpg') }}')">
        <h1>Capturing real stories, honestly.</h1>
        <p>A collection of real moments, captured as they happened. Explore the portfolio to see the stories behind each frame.</p>
    </section>

    <section id="newborn" class="collection collection-newborn" aria-labelledby="newborn-title">
        <div class="collection-text">
            <h2 id="newborn-title">New Born</h2>
            <p>There's something quietly extraordinary about the first days of a new life, the tiny curled fingers, the soft weight of sleep, the hush that settles over a home in those early weeks. Each session moves at the baby's own pace, working with soft natural light to capture honest, unhurried moments rather than staged ones. These are the days that pass the fastest, and the ones most worth holding onto.</p>
        </div>

        <div class="col stack">
            <img src="{{ asset('images/portfolio/newborn-1.jpg') }}" alt="Newborn baby wrapped in blue" loading="lazy">
            <img src="{{ asset('images/portfolio/newborn-2.jpg') }}" alt="Newborn baby on pink fabric" loading="lazy">
            <img src="{{ asset('images/portfolio/newborn-3.jpg') }}" alt="Sleeping newborn on white fur" loading="lazy">
            <img src="{{ asset('images/portfolio/newborn-4.jpg') }}" alt="Newborn baby on green fabric" loading="lazy">
        </div>

        <div class="col">
            <img src="{{ asset('images/portfolio/newborn-5.jpg') }}" alt="Black and white photo of a father holding his baby" loading="lazy">
        </div>

        <div class="col stack two">
            <img src="{{ asset('images/portfolio/newborn-6.jpg') }}" alt="Baby sleeping in an autumn leaf wreath" loading="lazy">
            <img src="{{ asset('images/portfolio/newborn-7.jpg') }}" alt="Parents' hands holding a newborn's feet" loading="lazy">
        </div>
    </section>

    <section id="events" class="collection collection-events" aria-labelledby="events-title">
        <div class="col stack two">
            <img src="{{ asset('images/portfolio/events-1.jpg') }}" alt="Marriage proposal at an event" loading="lazy">
            <img src="{{ asset('images/portfolio/events-2.jpg') }}" alt="Woman holding a bouquet of flowers" loading="lazy">
        </div>

        <div class="col">
            <img src="{{ asset('images/portfolio/events-3.jpg') }}" alt="Black and white portrait with a water splash" loading="lazy">
        </div>

        <div class="col stack two">
            <img src="{{ asset('images/portfolio/events-4.jpg') }}" alt="Woman with two dogs" loading="lazy">
            <img src="{{ asset('images/portfolio/events-5.jpg') }}" alt="Fire spinning performance on a beach" loading="lazy">
        </div>

        <div class="collection-text">
            <h2 id="events-title">Events</h2>
            <p>Every event carries its own energy - the anticipation before it begins, the small unscripted moments in between, and the atmosphere that builds as the day unfolds. Our approach is to stay observant and unobtrusive, capturing genuine reactions and connections rather than posed setups. The result is a true record.</p>
        </div>
    </section>

    <section id="maternity" class="collection collection-maternity" aria-labelledby="maternity-title">
        <div class="collection-text">
            <h2 id="maternity-title">Maternity</h2>
            <p>Pregnancy is a season of quiet anticipation, and this collection is dedicated to that in-between time - the soft curve of a growing belly, a hand resting gently where new life is forming. Each session is unhurried and shaped around comfort, letting genuine warmth come through so you can look back and remember exactly how it felt to be waiting.</p>
        </div>

        <div class="col">
            <img src="{{ asset('images/portfolio/maternity-1.jpg') }}" alt="Expectant mother holding flowers by a brick wall" loading="lazy">
        </div>

        <div class="col stack two">
            <img src="{{ asset('images/portfolio/maternity-2.jpg') }}" alt="Expectant mother in a pink dress and hat" loading="lazy">
            <img src="{{ asset('images/portfolio/maternity-3.jpg') }}" alt="Couple holding an ultrasound picture" loading="lazy">
        </div>
    </section>

</main>
@endsection
             



               

    