@php
    $facebook  = 'https://www.facebook.com/AshanRumaizPhotography/';
    $instagram = 'https://www.instagram.com/ashanrumaizphotography?cplk=MTN3NWhrMm1leGp0NQ==';

    $email   = 'ashanrumaiz@gmail.com';
    $phone   = '+94 77 949 0255';
    $phoneLink = 'tel:+94779490255';
    $address = 'No:207/16, Rainbow village Mahahunupitiya, Negombo';
@endphp

<footer class="site-footer">

    <div class="footer-brand">
        <a href="/" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Ashan Rumaiz Photography">
        </a>
    </div>

    <div class="footer-about">
        <h4>Ashan Rumaiz Photography</h4>
        <p>Ashan Rumaiz Photography provides professional photography services in Sri Lanka.
           We capture every moment with warmth, precision, and a personal touch
           that lasts a lifetime.</p>

        <div class="social-links">
            <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" aria-label="Ashan Rumaiz Photography on Facebook">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2C6.48 2 2 6.48 2 12c0 4.99 3.66 9.13 8.44 9.88v-6.99H7.9V12h2.54V9.8c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56V12h2.78l-.44 2.89h-2.34v6.99C18.34 21.13 22 16.99 22 12c0-5.52-4.48-10-10-10z"/>
                </svg>
            </a>

            <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Ashan Rumaiz Photography on Instagram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true">
                    <rect x="3" y="3" width="18" height="18" rx="5"/>
                    <circle cx="12" cy="12" r="4.2"/>
                    <circle cx="17.3" cy="6.7" r="1" fill="currentColor" stroke="none"/>
                </svg>
            </a>

            <a href="mailto:{{ $email }}" aria-label="Email Ashan Rumaiz Photography">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="2" y="2" width="20" height="20" rx="4" fill="currentColor"/>
                    <path class="mail-lines" d="M6 8.5l6 4.5 6-4.5M6 8.5h12v7.5H6z" fill="none" stroke-width="1.6" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
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
        <div class="contact-item">
            <svg class="contact-icon" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="2" y="2" width="20" height="20" rx="4" fill="currentColor"/>
                <path class="mail-lines" d="M6 8.5l6 4.5 6-4.5M6 8.5h12v7.5H6z" fill="none" stroke-width="1.6" stroke-linejoin="round"/>
            </svg>
            <div>
                <h5>Write to us</h5>
                <a href="mailto:{{ $email }}">{{ $email }}</a>
            </div>
        </div>

        <div class="contact-item">
            <svg class="contact-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
            <div>
                <h5>Contact us</h5>
                <a href="{{ $phoneLink }}">{{ $phone }}</a>
            </div>
        </div>

        <div class="contact-item">
            <svg class="contact-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 1.5c-4.4 0-8 3.5-8 7.9 0 5.6 8 13.1 8 13.1s8-7.5 8-13.1c0-4.4-3.6-7.9-8-7.9z" fill="currentColor"/>
                <circle class="mail-lines-fill" cx="12" cy="9.4" r="2.8"/>
            </svg>
            <div>
                <h5>Location</h5>
                <p>{{ $address }}</p>
            </div>
        </div>
    </div>

</footer>
