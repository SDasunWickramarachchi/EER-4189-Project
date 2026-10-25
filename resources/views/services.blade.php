@extends('layouts.app')

@section('title', 'Services')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/services.css') }}">
@endpush

@section('content')

@verbatim
<div id="app">
    
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

</div>
@endverbatim
@endsection

@push('scripts')
<script src="{{ asset('js/services.js') }}"></script>
@endpush


