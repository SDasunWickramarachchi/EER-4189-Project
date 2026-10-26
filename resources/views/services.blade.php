<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services | Ashan Rumaiz Photography</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: #121212;
            --bg-light: #f8f6f4;
            --card-grey: #a6abb4;
            --card-lavender: #d2c5d6;
            --btn-pink: #bc8e97;
            --btn-purple: #787a91;
            --text-dark: #1c1c1e;
            --text-muted: #555555;
            --accent-blue: #2f80ed;
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
            transition: color 0.3s ease;
        }

        .main-nav a:hover, .main-nav a.active {
            color: #000;
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
            transition: background 0.3s ease;
        }

        .btn-small:hover {
            background-color: #a3757e;
        }

        /* Hero / Header Section */
        .services-hero {
            text-align: center;
            padding: 4rem 1rem 3rem 1rem;
            max-width: 800px;
            margin: 0 auto;
        }

        .services-hero h1 {
            font-size: 3.2rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
            letter-spacing: 1px;
        }

        .services-hero h1::after {
            content: '';
            display: block;
            width: 110%;
            height: 4px;
            background-color: var(--accent-blue);
            margin: 8px auto 0 auto;
            border-radius: 2px;
        }

        .services-hero p {
            font-size: 1.1rem;
            color: #4a4a4a;
            font-weight: 400;
            line-height: 1.7;
        }

        /* Services Container */
        .services-container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        .service-card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            align-items: center;
        }

        .service-card.bg-grey {
            background-color: var(--card-grey);
        }

        .service-card.bg-lavender {
            background-color: var(--card-lavender);
        }

        .service-content {
            padding: 3.5rem 3rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            justify-content: center;
        }

        .service-content h2 {
            font-size: 2.2rem;
            margin-bottom: 1.2rem;
            color: #1a1a1a;
            font-weight: 600;
        }

        .service-content p {
            font-size: 0.95rem;
            color: #2b2b2b;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .btn-inquire {
            display: inline-block;
            background-color: var(--btn-pink);
            color: #fff;
            padding: 0.75rem 1.8rem;
            border-radius: 25px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .service-card.bg-lavender .btn-inquire {
            background-color: var(--btn-purple);
        }

        .btn-inquire:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .service-image {
            height: 100%;
            min-height: 380px;
            width: 100%;
            overflow: hidden;
        }

        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Booking Details Section */
        .booking-section {
            background-color: #dfd8e3;
            text-align: center;
            padding: 4rem 2rem;
            margin: 3rem 0 0 0;
        }

        .booking-section h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #1a1a1a;
        }

        .booking-section p {
            max-width: 650px;
            margin: 0 auto 2rem auto;
            font-size: 0.95rem;
            color: #4a4a4a;
        }

        .btn-book-now {
            display: inline-block;
            background-color: var(--btn-purple);
            color: #fff;
            padding: 0.8rem 2.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.85rem;
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

        .footer-links a:hover {
            color: #000;
        }

        .footer-contact p {
            margin-bottom: 0.5rem;
            color: #555;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-icons a {
            color: #333;
            text-decoration: none;
            font-size: 1.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .site-header {
                flex-direction: column;
                gap: 1rem;
            }
            .service-card {
                grid-template-columns: 1fr;
            }
            .service-card.reverse {
                display: flex;
                flex-direction: column-reverse;
            }
            .site-footer {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<div id="app">
    <!-- Navigation Header -->
    <header class="site-header">
        <a href="/" class="logo">
            <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
        </a>

        <nav class="main-nav">
            <a href="/">Home</a>
            <a href="/portfolio">Portfolio</a>
            <a href="/services" class="active">Services</a>
            <a href="/packages">Packages</a>
            <a href="/about">About</a>
            <a href="/contact">Contact</a>
            <a href="/booking" class="btn-small">Book Now</a>
        </nav>
    </header>

    <!-- Services Header Banner -->
    <section class="services-hero">
        <h1>Tailored Memories.</h1>
        <p>Genuine moments, thoughtfully captured. Explore the photography services designed to hold onto what matters most.</p>
    </section>

    <!-- Dynamic Services Container (Connected to MongoDB Backend API) -->
    <section class="services-container">
        <div v-if="loading" style="text-align: center; padding: 3rem; color: #666;">
            Loading services...
        </div>

        <div v-else-if="services.length === 0" style="text-align: center; padding: 3rem; color: #666;">
            No active services found. Please check back later.
        </div>

        <div v-else v-for="(service, index) in services" 
             :key="service._id || service.id" 
             :class="['service-card', index % 2 === 0 ? 'bg-grey' : 'bg-lavender', index % 2 === 1 ? 'reverse' : '']">
            
            <!-- Left Text Content (for even index 0, 2...) -->
            <div class="service-content" v-if="index % 2 === 0">
                <h2>{{ service.name }}</h2>
                <p>{{ service.description }}</p>
                <a :href="service.button_link || '/booking'" class="btn-inquire">
                    {{ service.button_text || 'Inquire For Full Detail Package' }}
                </a>
            </div>

            <!-- Image Column -->
            <div class="service-image">
                <img :src="service.image_url" :alt="service.name">
            </div>

            <!-- Right Text Content (for odd index 1, 3...) -->
            <div class="service-content" v-if="index % 2 === 1">
                <h2>{{ service.name }}</h2>
                <p>{{ service.description }}</p>
                <a :href="service.button_link || '/booking'" class="btn-inquire">
                    {{ service.button_text || 'Inquire For Full Detail Package' }}
                </a>
            </div>

        </div>
    </section>

    <!-- Booking Details Section -->
    <section class="booking-section">
        <h2>Booking Details</h2>
        <p>A 50% non-refundable deposit is required to secure your requested dates. The remaining balance is due prior to the delivery of final assets.</p>
        <a href="/booking" class="btn-book-now">Book Now</a>
    </section>

    <!-- Site Footer -->
    <footer class="site-footer">
        <div class="footer-brand">
            <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
        </div>

        <div class="footer-about">
            <h4>Ashan Rumaiz Photography</h4>
            <p>Ashan Rumaiz Photography provides professional photography services in Sri Lanka. We capture every moment with warmth, precision, and a personal touch that lasts a lifetime.</p>
            <div class="social-icons">
                <a href="#" aria-label="Facebook">🌐</a>
                <a href="#" aria-label="Instagram">📷</a>
                <a href="#" aria-label="Email">✉️</a>
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
            <h4>Contact Us</h4>
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
                services: [],
                loading: true
            }
        },
        mounted() {
            // Fetch services dynamically from Laravel MongoDB API
            fetch('/api/services')
                .then(res => res.json())
                .then(resData => {
                    if (resData.status === 'success' && resData.data) {
                        this.services = resData.data;
                    }
                    this.loading = false;
                })
                .catch(err => {
                    console.error('Error fetching public services from backend:', err);
                    this.loading = false;
                });
        }
    }).mount('#app');
</script>

</body>
</html>
