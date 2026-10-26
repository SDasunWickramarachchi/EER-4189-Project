<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Your Date | Ashan Rumaiz Photography</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-light: #f8f6f4;
            --btn-pink: #bc8e97;
            --btn-purple: #787a91;
            --card-lavender: #d8c9dc;
            --text-dark: #1c1c1e;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
        }

        /* Site Header */
        .site-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem 5%;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo img {
            height: 48px;
            object-fit: contain;
        }

        .main-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .main-nav a {
            text-decoration: none;
            color: #333;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 4px;
        }

        .main-nav a.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #000;
        }

        .btn-small {
            background-color: var(--btn-pink);
            color: #fff !important;
            padding: 0.6rem 1.4rem;
            border-radius: 20px;
            font-size: 0.85rem !important;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* Hero Banner */
        .hero-banner {
            position: relative;
            background: url('/images/hero.jpg') center/cover no-repeat;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 3rem 1rem;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.45);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 750px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 0.8rem;
        }

        .hero-content p {
            font-size: 1.15rem;
            font-weight: 300;
            line-height: 1.6;
        }

        /* Main Workspace Grid */
        .booking-workspace {
            background-color: #d6cadb;
            padding: 4rem 5%;
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 3.5rem;
            align-items: start;
        }

        /* Left Information Column */
        .info-col {
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        .info-block h2 {
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 1rem;
            color: #2b2b2b;
        }

        .info-block p {
            font-size: 0.95rem;
            color: #444;
            line-height: 1.7;
        }

        .inclusions-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
            margin-top: 1rem;
        }

        .inclusions-list li {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 1.05rem;
            font-weight: 500;
            color: #2b2b2b;
        }

        .checkbox-icon {
            width: 22px;
            height: 22px;
            background-color: #d1b8c1;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.85rem;
        }

        .guidelines-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .guide-card {
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(0, 0, 0, 0.15);
            padding: 1.5rem;
            border-radius: 6px;
        }

        .guide-card h3 {
            font-size: 1.1rem;
            margin-bottom: 0.8rem;
            color: #111;
        }

        .guide-card ul {
            list-style: none;
            font-size: 0.85rem;
            color: #444;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .guide-card ul li::before {
            content: '✓ ';
            color: #333;
            font-weight: bold;
        }

        /* Right Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 2.8rem 2.2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .form-card h2 {
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-align: center;
            margin-bottom: 2rem;
            color: #111;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #444;
            margin-bottom: 0.4rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 0.75rem 0.5rem;
            border: none;
            border-bottom: 1px solid #999;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
            background: transparent;
            transition: border-color 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-bottom-color: var(--btn-pink);
        }

        .btn-submit {
            width: 100%;
            background-color: var(--btn-pink);
            color: #fff;
            border: none;
            padding: 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #a3757e;
        }

        .alert-box {
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Site Footer */
        .site-footer {
            background-color: #f2ede9;
            padding: 4rem 5% 2rem 5%;
            display: grid;
            grid-template-columns: 1.2fr 1.5fr 1fr 1.2fr;
            gap: 2rem;
            border-top: 1px solid #e2ded9;
            font-size: 0.9rem;
        }

        .footer-brand img {
            height: 45px;
            margin-bottom: 1rem;
        }

        .footer-about h4, .footer-links h4, .footer-contact h4 {
            margin-bottom: 1rem;
            font-size: 1rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .footer-links a {
            display: block;
            text-decoration: none;
            color: #555;
            margin-bottom: 0.5rem;
        }

        .footer-contact p {
            margin-bottom: 0.5rem;
            color: #555;
        }

        @media (max-width: 900px) {
            .booking-workspace {
                grid-template-columns: 1fr;
            }
            .site-footer {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div id="app">
    <!-- Header -->
    <header class="site-header">
        <a href="/" class="logo">
            <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
        </a>

        <nav class="main-nav">
            <a href="/">Home</a>
            <a href="/portfolio">Portfolio</a>
            <a href="/services">Services</a>
            <a href="/packages">Packages</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/booking" class="btn-small active">Book Now</a>
        </nav>
    </header>

    <!-- Banner -->
    <section class="hero-banner">
        <div class="hero-content">
            <h1>Reserve Your Date!</h1>
            <p>Let's start planning your session. Fill out the form below and we'll be in touch to confirm the details and hold your date.</p>
        </div>
    </section>

    <!-- Workspace Grid -->
    <section class="booking-workspace">
        <!-- Left Overview Column -->
        <div class="info-col">
            <div class="info-block">
                <h2>Experience Overview</h2>
                <p>Our standard session is designed to be an unhurried, collaborative experience. We focus on natural light, genuine interactions, and a quiet, minimalist aesthetic that allows the subject to remain the focal point of every frame.</p>
            </div>

            <div class="info-block">
                <h2>Session Inclusions</h2>
                <ul class="inclusions-list">
                    <li><span class="checkbox-icon">✓</span> Pre-session consultation</li>
                    <li><span class="checkbox-icon">✓</span> Print release rights</li>
                    <li><span class="checkbox-icon">✓</span> High-resolution digital downloads</li>
                </ul>
            </div>

            <div class="info-block">
                <h2>Preparation Guidelines</h2>
                <div class="guidelines-cards">
                    <div class="guide-card">
                        <h3>What to Bring</h3>
                        <ul>
                            <li>2-3 outfit changes (neutral tones preferred)</li>
                            <li>Personal touch items or props (if desired)</li>
                        </ul>
                    </div>

                    <div class="guide-card">
                        <h3>Studio Etiquette</h3>
                        <ul>
                            <li>Arrive 15 minutes prior to scheduled time</li>
                            <li>Only immediate participants permitted in studio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Column (Connected to POST /api/bookings API) -->
        <div class="form-card">
            <h2>Book Your Session</h2>

            <div v-if="successMessage" class="alert-box alert-success">
                {{ successMessage }}
            </div>

            <div v-if="errorMessage" class="alert-box alert-error">
                {{ errorMessage }}
            </div>

            <form @submit.prevent="submitBooking">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" v-model="form.client_name" required placeholder="John Doe">
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" v-model="form.client_phone" required placeholder="(415) 890-2134">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" v-model="form.client_email" required placeholder="john@example.com">
                </div>

                <div class="form-group">
                    <label>Session Date</label>
                    <input type="date" v-model="form.session_date" required>
                </div>

                <div class="form-group">
                    <label>Session Type</label>
                    <select v-model="form.session_type" required>
                        <option value="" disabled>Select Session Type</option>
                        <option value="Weddings & Couples">Weddings & Couples</option>
                        <option value="Maternity">Maternity</option>
                        <option value="Newbaby & Born">Newbaby & Born</option>
                        <option value="Portraits & Lifestyle">Portraits & Lifestyle</option>
                        <option value="Events & Corporate">Events & Corporate</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Venue / Location</label>
                    <input type="text" v-model="form.location" required placeholder="e.g. St. Jude Estate, Kenwood">
                </div>

                <button type="submit" class="btn-submit" :disabled="submitting">
                    {{ submitting ? 'Submitting...' : 'Request Booking' }}
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-brand">
            <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
        </div>

        <div class="footer-about">
            <h4>Ashan Rumaiz Photography</h4>
            <p>Ashan Rumaiz Photography provides professional photography services in Sri Lanka. We capture every moment with warmth, precision, and a personal touch that lasts a lifetime.</p>
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
            <h4>Write To Us</h4>
            <p>✉️ ashanrumaiz@gmail.com</p>
            <p>📞 +94 77 444 8255</p>
            <p>📍 No.07/20, Rainbow Village, Mahahunupitiya, Negombo</p>
        </div>
    </footer>
</div>

<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js"></script>
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                form: {
                    client_name: '',
                    client_phone: '',
                    client_email: '',
                    session_date: '',
                    session_type: '',
                    location: '',
                },
                submitting: false,
                successMessage: null,
                errorMessage: null,
            }
        },
        methods: {
            submitBooking() {
                this.submitting = true;
                this.successMessage = null;
                this.errorMessage = null;

                fetch('/api/bookings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.form),
                })
                .then(res => res.json())
                .then(resData => {
                    this.submitting = false;
                    if (resData.status === 'success') {
                        this.successMessage = resData.message;
                        this.form = {
                            client_name: '',
                            client_phone: '',
                            client_email: '',
                            session_date: '',
                            session_type: '',
                            location: '',
                        };
                    } else {
                        this.errorMessage = resData.message || 'Failed to submit booking.';
                    }
                })
                .catch(err => {
                    this.submitting = false;
                    console.error('Error submitting booking:', err);
                    this.errorMessage = 'Network error. Please try again.';
                });
            }
        }
    }).mount('#app');
</script>

</body>
</html>
