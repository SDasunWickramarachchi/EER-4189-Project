@extends('layouts.app')

@section('title', 'Book a Session')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/booking.css') }}">
@endpush

@section('content')
@verbatim
<div id="app">
    
    <main>
        <section class="booking-hero">
            <div class="booking-hero-text">
                <h1>Reserve Your Date!</h1>
                <p>Let's start planning your session. Fill out the form below and we'll be in touch to confirm the details and hold your date.</p>
            </div>
        </section>

        <section class="booking-main">

            <div class="booking-info">
                <h2>Experience Overview</h2>
                <p>Our standard session is designed to be an unhurried, collaborative experience. We focus on natural light, genuine interactions, and a quiet, minimalist aesthetic that allows the subject to remain the focal point of every frame.</p>
                <h2>Session Inclusions</h2>
                <ul class="checklist">
                    <li v-for="item in inclusions" :key="item">
                        <span class="tick" aria-hidden="true">&#10003;</span>{{ item }}
                    </li>
                </ul>

                <h2 class="centered">Preparation Guidelines</h2>
                <div class="guidelines">
                    <div class="guideline-box" v-for="g in guidelines" :key="g.title">
                        <h3>{{ g.title }}</h3>
                        <ul>
                            <li v-for="t in g.items" :key="t">
                                <span aria-hidden="true">&#10003;</span> {{ t }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="booking-card">
                <h2>Book Your Session</h2>

                <form @submit.prevent="submit" novalidate>

                    <div class="field">
                        <label for="full_name">Full Name</label>
                        <input id="full_name" type="text" v-model.trim="form.full_name" autocomplete="name">
                        <span class="field-error" v-if="errors.full_name">{{ errors.full_name }}</span>
                    </div>

                    <div class="field">
                        <label for="phone">Phone Number</label>
                        <input id="phone" type="tel" v-model.trim="form.phone" autocomplete="tel">
                        <span class="field-error" v-if="errors.phone">{{ errors.phone }}</span>
                    </div>

                    <div class="field">
                        <label for="email">Email Address</label>
                        <input id="email" type="email" v-model.trim="form.email" autocomplete="email">
                        <span class="field-error" v-if="errors.email">{{ errors.email }}</span>
                    </div>

                    <div class="field">
                        <label for="session_date">Session Date</label>
                        <input id="session_date" type="date" v-model="form.session_date" :min="today">
                        <span class="field-error" v-if="errors.session_date">{{ errors.session_date }}</span>
                    </div>

                    <div class="field">
                        <label for="session_type">Session Type</label>
                        <select id="session_type" v-model="form.session_type">
                            <option value="" disabled>Select Session Type</option>
                            <option v-for="t in sessionTypes" :key="t" :value="t">{{ t }}</option>
                        </select>
                        <span class="field-error" v-if="errors.session_type">{{ errors.session_type }}</span>
                    </div>

                    <div class="field">
                        <label for="venue">Venue / Location</label>
                        <input id="venue" type="text" v-model.trim="form.venue">
                        <span class="field-error" v-if="errors.venue">{{ errors.venue }}</span>
                    </div>

                    <p class="form-error" v-if="serverError" role="alert">{{ serverError }}</p>

                    <button type="submit" class="btn btn-request" :disabled="sending">
                        {{ sending ? "Sending..." : "Request Booking" }}
                    </button>
                </form>
            </div>

        </section>
    </main>
    
    <div class="modal-backdrop" v-if="showThanks" @click.self="showThanks = false">
        <div class="modal" role="dialog" aria-modal="true" aria-labelledby="thanks-title">
            <span class="modal-icon" aria-hidden="true">&#10003;</span>
            <h3 id="thanks-title">Request Sent!</h3>
            <p>Thank you, {{ sentName }}. Your booking request has been received. We will be in touch soon to confirm the details and hold your date.</p>
            <button class="btn btn-request" @click="showThanks = false">Close</button>
        </div>
    </div>

</div>
@endverbatim
@endsection

@push('scripts')
<script src="{{ asset('js/booking.js') }}"></script>
@endpush