<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Your Date | Ashan Rumaiz Photography</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-light: #f8f6f4;
            --btn-pink: #bc8e97;
            --btn-pink-hover: #a3757e;
            --btn-purple: #787a91;
            --card-lavender: #d8c9dc;
            --text-dark: #1c1c1e;
            --text-muted: #555555;
            --border-subtle: #e2ded9;
            --status-pending-bg: #fff7ed;
            --status-pending-text: #c2410c;
            --status-pending-border: #fed7aa;
            --status-pending-dot: #f97316;
            --status-available-bg: #ecfdf5;
            --status-available-text: #047857;
            --status-available-border: #a7f3d0;
            --status-busy-bg: #fef2f2;
            --status-busy-text: #b91c1c;
            --status-busy-border: #fecaca;
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
            transition: background 0.3s;
        }

        .btn-small:hover {
            background-color: var(--btn-pink-hover);
        }

        /* Hero Banner */
        .hero-banner {
            position: relative;
            background: url('/images/hero.jpg') center/cover no-repeat;
            min-height: 380px;
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
            background: rgba(0, 0, 0, 0.48);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 750px;
        }

        .hero-content h1 {
            font-size: 3.2rem;
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
            grid-template-columns: 1.1fr 1.25fr;
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
            background: rgba(255, 255, 255, 0.45);
            border: 1px solid rgba(0, 0, 0, 0.12);
            padding: 1.5rem;
            border-radius: 8px;
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

        /* Lead Photographer Highlight Badge */
        .photographer-card {
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 10px;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.2rem;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .photographer-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #4a1322;
            color: #ffffff;
            font-family: 'Playfair Display', serif;
            font-size: 1.25rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .photographer-details h4 {
            font-size: 1rem;
            color: #111;
        }

        .photographer-details p {
            font-size: 0.82rem;
            color: #666;
            margin: 0;
        }

        /* Right Form Card */
        .form-card {
            background: #ffffff;
            border-radius: 14px;
            padding: 2.8rem 2.4rem;
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            position: relative;
        }

        .form-card h2 {
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-align: center;
            margin-bottom: 0.5rem;
            color: #111;
        }

        .form-subtitle {
            text-align: center;
            font-size: 0.88rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .pending-notice-banner {
            background-color: var(--status-pending-bg);
            border: 1px solid var(--status-pending-border);
            border-radius: 8px;
            padding: 0.85rem 1.1rem;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.84rem;
            color: var(--status-pending-text);
            line-height: 1.5;
        }

        .pending-notice-banner .icon {
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.4rem;
        }

        .form-group label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #444;
            margin-bottom: 0.4rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem 0.5rem;
            border: none;
            border-bottom: 1px solid #bbb;
            font-family: inherit;
            font-size: 0.95rem;
            outline: none;
            background: transparent;
            transition: border-color 0.3s;
        }

        .form-group textarea {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 0.75rem;
            resize: vertical;
            background: #fafafa;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-bottom-color: var(--btn-pink);
        }

        .form-group textarea:focus {
            border-color: var(--btn-pink);
            background: #fff;
        }

        /* Real-Time Availability Badge Indicator (Teammate Extension Hook) */
        .availability-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: none;
            letter-spacing: 0;
            padding: 0.15rem 0.6rem;
            border-radius: 12px;
        }

        .availability-badge.available {
            background-color: var(--status-available-bg);
            color: var(--status-available-text);
            border: 1px solid var(--status-available-border);
        }

        .availability-badge.busy {
            background-color: var(--status-busy-bg);
            color: var(--status-busy-text);
            border: 1px solid var(--status-busy-border);
        }

        .availability-badge.checking {
            background-color: #f1f5f9;
            color: #64748b;
        }

        .btn-submit {
            width: 100%;
            background-color: var(--btn-pink);
            color: #fff;
            border: none;
            padding: 1.1rem;
            border-radius: 25px;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 1.25rem;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
        }

        .btn-submit:hover:not(:disabled) {
            background-color: var(--btn-pink-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(188, 142, 151, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        /* Alerts */
        .alert-box {
            padding: 1rem 1.2rem;
            border-radius: 6px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* ==========================================================================
           FEATURE 2 (LEAD): BOOKING CONFIRMATION MODAL & DOSSIER
           ========================================================================== */
        .confirmation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            z-index: 999;
            overflow-y: auto;
        }

        .confirmation-card {
            background: #ffffff;
            border-radius: 16px;
            width: 100%;
            max-width: 720px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            display: flex;
            flex-direction: column;
            animation: modalFadeIn 0.25s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: scale(0.96) translateY(10px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .confirmation-header {
            padding: 2rem 2.2rem 1.5rem 2.2rem;
            background: linear-gradient(135deg, #faf7f5 0%, #f3ece8 100%);
            border-bottom: 1px solid var(--border-subtle);
            text-align: center;
            position: relative;
        }

        .confirmation-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #4a1322;
            color: #ffffff;
            font-size: 1.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem auto;
            box-shadow: 0 6px 16px rgba(74, 19, 34, 0.25);
        }

        .confirmation-header h2 {
            font-size: 1.9rem;
            color: #111;
            margin-bottom: 0.35rem;
        }

        .confirmation-header p {
            font-size: 0.92rem;
            color: var(--text-muted);
        }

        .ref-box-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .reference-code-badge {
            background: #ffffff;
            border: 1px dashed #bc8e97;
            color: #4a1322;
            font-family: monospace;
            font-size: 0.95rem;
            font-weight: 700;
            padding: 0.35rem 0.85rem;
            border-radius: 6px;
            letter-spacing: 1px;
        }

        .btn-copy-code {
            background: none;
            border: 1px solid var(--border-subtle);
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #555;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-copy-code:hover {
            background: #ffffff;
            color: #111;
        }

        .confirmation-body {
            padding: 2rem 2.2rem;
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        /* Status Banner inside Modal */
        .status-pill-banner {
            background: var(--status-pending-bg);
            border: 1px solid var(--status-pending-border);
            border-radius: 10px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .status-pill-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.88rem;
            font-weight: 700;
            color: var(--status-pending-text);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .pulsing-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--status-pending-dot);
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.25);
            animation: pulseDot 1.8s infinite;
        }

        @keyframes pulseDot {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(249, 115, 22, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(249, 115, 22, 0); }
        }

        .status-pill-eta {
            font-size: 0.82rem;
            color: #9a3412;
            font-weight: 500;
        }

        /* Summary Dossier Grid */
        .dossier-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
            background: #faf9f8;
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            padding: 1.5rem;
        }

        .dossier-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .dossier-item .label {
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #777;
        }

        .dossier-item .value {
            font-size: 0.95rem;
            font-weight: 600;
            color: #111;
        }

        /* 4-Step Next Steps Progress */
        .timeline-box {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .timeline-box h3 {
            font-size: 1.05rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #222;
        }

        .timeline-steps {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
        }

        .timeline-step {
            display: flex;
            align-items: flex-start;
            gap: 0.85rem;
            font-size: 0.88rem;
            color: #444;
        }

        .step-num {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e2ded9;
            color: #4a1322;
            font-weight: 700;
            font-size: 0.78rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .step-num.active {
            background: #4a1322;
            color: #ffffff;
        }

        /* Modal Footer Action Buttons */
        .confirmation-actions {
            padding: 1.25rem 2.2rem 2rem 2.2rem;
            border-top: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            background: #ffffff;
            border-radius: 0 0 16px 16px;
        }

        .action-group-left {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-action-outline {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.65rem 1.1rem;
            background: #ffffff;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            font-size: 0.84rem;
            font-weight: 600;
            color: #333;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-action-outline:hover {
            background: #f4ede9;
            border-color: #bc8e97;
            color: #4a1322;
        }

        .btn-action-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.65rem 1.3rem;
            background: #4a1322;
            color: #ffffff;
            border: none;
            border-radius: 20px;
            font-size: 0.84rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-action-primary:hover {
            background: #380e1a;
        }

        /* Print Mode Override */
        @media print {
            body * {
                visibility: hidden;
            }
            .confirmation-overlay,
            .confirmation-card,
            .confirmation-card * {
                visibility: visible;
            }
            .confirmation-overlay {
                position: absolute;
                top: 0;
                left: 0;
                background: none;
                padding: 0;
            }
            .confirmation-actions,
            .btn-copy-code {
                display: none !important;
            }
            .confirmation-card {
                box-shadow: none;
                max-width: 100%;
                border: 1px solid #ccc;
            }
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
            .dossier-grid,
            .form-grid-2 {
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
            <h1>Reserve Your Date</h1>
            <p>Every genuine moment deserves dedicated preparation. Request your desired date and let us curate a seamless, timeless session for you.</p>
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

            <!-- Principal Photographer Bio -->
            <div class="photographer-card">
                <div class="photographer-avatar">AR</div>
                <div class="photographer-details">
                    <h4>Ashan Rumaiz (Principal)</h4>
                    <p>Lead Creative Director & Principal Photographer. Personally captures and directs every reserved session.</p>
                </div>
            </div>

            <div class="info-block">
                <h2>Session Inclusions</h2>
                <ul class="inclusions-list">
                    <li><span class="checkbox-icon">✓</span> Dedicated pre-session creative consultation</li>
                    <li><span class="checkbox-icon">✓</span> Full personal print release and archival rights</li>
                    <li><span class="checkbox-icon">✓</span> High-resolution hand-graded digital gallery downloads</li>
                </ul>
            </div>

            <div class="info-block">
                <h2>Preparation Guidelines</h2>
                <div class="guidelines-cards">
                    <div class="guide-card">
                        <h3>What to Bring</h3>
                        <ul>
                            <li>2-3 outfit changes (neutral, earth tones preferred)</li>
                            <li>Personal heirloom items or meaningful props</li>
                        </ul>
                    </div>

                    <div class="guide-card">
                        <h3>Studio Etiquette</h3>
                        <ul>
                            <li>Please arrive 15 minutes prior to scheduled start</li>
                            <li>Immediate session participants permitted on set</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Column: Connected to Booking API -->
        <div class="form-card">
            <h2>Book Your Session</h2>
            <p class="form-subtitle">Fill in your reservation details below to initiate your booking request.</p>

            <!-- Pending Workflow Assurance Banner -->
            <div class="pending-notice-banner">
                <span class="icon">ℹ️</span>
                <div>
                    <strong>Pending Review Notice:</strong> All requests are received as <em>Pending</em>. Ashan Rumaiz studio reviews session schedules and confirms reservations within 24 hours.
                </div>
            </div>

            <div v-if="errorMessage" class="alert-box alert-error">
                <span>⚠️</span>
                <span>@{{ errorMessage }}</span>
            </div>

            <form @submit.prevent="submitBooking">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" v-model="form.client_name" required placeholder="Sarah Jenkins">
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" v-model="form.client_phone" required placeholder="(415) 890-2134">
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" v-model="form.client_email" required placeholder="sarah@example.com">
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label>
                            <span>Session Date</span>
                            <!-- ========================================================================= -->
                            <!-- 👩‍💻 [TEAMMATE AREA - UI HOOK 1]: Live Date Availability Indicator         -->
                            <!-- Populated by handleDateChange() calling GET /api/bookings/availability     -->
                            <!-- ========================================================================= -->
                            <span v-if="availabilityStatus" :class="['availability-badge', availabilityStatus]">
                                @{{ availabilityMessage }}
                            </span>
                        </label>
                        <input type="date"
                               v-model="form.session_date"
                               :min="todayDate"
                               @change="handleDateChange"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Preferred Time Slot</label>
                        <select v-model="form.start_time" required>
                            <option value="10:00 AM">Morning (10:00 AM - 01:00 PM)</option>
                            <option value="02:30 PM">Golden Hour / Afternoon (02:30 PM - 06:30 PM)</option>
                            <option value="09:00 AM">Full Day Comprehensive (09:00 AM - 05:00 PM)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Session Specialty / Type</label>
                    <!-- ========================================================================= -->
                    <!-- 👩‍💻 [TEAMMATE AREA - UI HOOK 2]: Dynamic Session Specialty Dropdown         -->
                    <!-- Populated by fetchDynamicServices() calling GET /api/services             -->
                    <!-- ========================================================================= -->
                    <select v-model="form.session_type" required>
                        <option value="" disabled>Select Session Specialty</option>
                        <option v-for="item in availableServices" :key="item" :value="item">
                            @{{ item }}
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Venue / Shoot Location</label>
                    <input type="text" v-model="form.location" required placeholder="e.g. St. Jude Estate, Kenwood or Negombo Beachside">
                </div>

                <div class="form-group">
                    <label>Special Requests or Notes (Optional)</label>
                    <textarea v-model="form.notes" rows="3" placeholder="Share your vision, preferred aesthetics, or specific requests..."></textarea>
                </div>

                <!-- ========================================================================= -->
                <!-- 👨‍💻 [LEAD AREA - UI HOOK 3]: Form Submission Action & Pending Dispatch      -->
                <!-- Submits payload to POST /api/bookings and triggers Confirmation Modal     -->
                <!-- ========================================================================= -->
                <button type="submit" class="btn-submit" :disabled="submitting">
                    <span v-if="submitting">Submitting Request...</span>
                    <span v-else>Request Booking (Submit as Pending)</span>
                </button>
            </form>
        </div>
    </section>

    <!-- =========================================================================
         FEATURE 2 (LEAD): BOOKING CONFIRMATION MODAL & DOSSIER
         ========================================================================= -->
    <div v-if="showConfirmationModal && confirmation" class="confirmation-overlay" @click.self="closeConfirmation">
        <div class="confirmation-card">
            <!-- Modal Header -->
            <div class="confirmation-header">
                <div class="confirmation-icon-circle">✓</div>
                <h2>Booking Request Received</h2>
                <p>Thank you, @{{ confirmation.client_name }}! Your session request has been submitted to Ashan Rumaiz studio.</p>

                <div class="ref-box-row">
                    <span class="reference-code-badge">REF: @{{ confirmation.reference_number }}</span>
                    <button class="btn-copy-code" @click="copyReferenceCode">
                        @{{ copied ? '✓ Copied' : '📋 Copy Ref Code' }}
                    </button>
                </div>
            </div>

            <!-- Modal Body Details -->
            <div class="confirmation-body">
                <!-- Status Banner -->
                <div class="status-pill-banner">
                    <div class="status-pill-title">
                        <span class="pulsing-dot"></span>
                        <span>Status: @{{ confirmation.status_label || 'Pending Review' }}</span>
                    </div>
                    <div class="status-pill-eta">Review SLA: Under 24 Hours</div>
                </div>

                <!-- Shoot Dossier Grid -->
                <div class="dossier-grid">
                    <div class="dossier-item">
                        <span class="label">Session Date</span>
                        <span class="value">@{{ formatDisplayDate(confirmation.session_date) }}</span>
                    </div>

                    <div class="dossier-item">
                        <span class="label">Time Slot</span>
                        <span class="value">@{{ confirmation.start_time }} - @{{ confirmation.end_time || '05:00 PM' }}</span>
                    </div>

                    <div class="dossier-item">
                        <span class="label">Specialty</span>
                        <span class="value">@{{ confirmation.session_type }}</span>
                    </div>

                    <div class="dossier-item">
                        <span class="label">Lead Photographer</span>
                        <span class="value">@{{ confirmation.lead_photographer }}</span>
                    </div>

                    <div class="dossier-item" style="grid-column: span 2;">
                        <span class="label">Shoot Venue / Location</span>
                        <span class="value">@{{ confirmation.location }}</span>
                    </div>

                    <div class="dossier-item">
                        <span class="label">Primary Contact Email</span>
                        <span class="value">@{{ confirmation.client_email }}</span>
                    </div>

                    <div class="dossier-item">
                        <span class="label">Contact Phone</span>
                        <span class="value">@{{ confirmation.client_phone }}</span>
                    </div>
                </div>

                <!-- Next Steps Progress -->
                <div class="timeline-box">
                    <h3>What to Expect Next</h3>
                    <div class="timeline-steps">
                        <div class="timeline-step">
                            <span class="step-num active">1</span>
                            <div>
                                <strong>Request Logged:</strong> Your session details and preferred date are queued in the studio CRM.
                            </div>
                        </div>

                        <div class="timeline-step">
                            <span class="step-num active">2</span>
                            <div>
                                <strong>Studio Verification (Under 24h):</strong> Ashan Rumaiz reviews the schedule, gear, and location requirements.
                            </div>
                        </div>

                        <div class="timeline-step">
                            <span class="step-num">3</span>
                            <div>
                                <strong>Retainer & Contract:</strong> Upon acceptance, an official confirmation email with digital contract & 50% retainer invoice will be issued.
                            </div>
                        </div>

                        <div class="timeline-step">
                            <span class="step-num">4</span>
                            <div>
                                <strong>Creative Consultation:</strong> 7 days prior to your shoot date, we coordinate wardrobe, lighting, and custom shot list.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer Actions -->
            <div class="confirmation-actions">
                <div class="action-group-left">
                    <button class="btn-action-outline" @click="printDocket">
                        🖨️ Print / Save Summary
                    </button>
                    <button class="btn-action-outline" @click="downloadCalendarInvite">
                        📅 Add to Calendar (.ics)
                    </button>
                </div>

                <button class="btn-action-primary" @click="resetAndNewBooking">
                    Book Another Session
                </button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="footer-brand">
            <img src="/images/logo.png" alt="Ashan Rumaiz Photography">
        </div>

        <div class="footer-about">
            <h4>Ashan Rumaiz Photography</h4>
            <p>Ashan Rumaiz Photography provides bespoke photography services across Sri Lanka. We capture every moment with warmth, precision, and a timeless touch.</p>
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
            const today = new Date().toISOString().split('T')[0];
            return {
                todayDate: today,
                // Default specialty list (fallback if dynamic API is loading or not seeded)
                availableServices: [
                    'Weddings & Couples',
                    'Maternity',
                    'Newbaby & Born',
                    'Portraits & Lifestyle',
                    'Events & Corporate'
                ],
                form: {
                    client_name: '',
                    client_phone: '',
                    client_email: '',
                    session_date: '',
                    start_time: '10:00 AM',
                    session_type: '',
                    location: '',
                    notes: '',
                },
                submitting: false,
                errorMessage: null,

                // Availability hook state [Feature 1 Teammate Hook]
                availabilityStatus: null, // 'checking' | 'available' | 'busy'
                availabilityMessage: '',

                // Confirmation modal state [Feature 2 Lead Feature]
                showConfirmationModal: false,
                confirmation: null,
                copied: false,
            }
        },
        mounted() {
            // [FEATURE 1 - TEAMMATE EXTENSION POINT]: Fetch Dynamic Services from API
            this.fetchDynamicServices();
        },
        methods: {
            // =========================================================================
            // 👩‍💻 [TEAMMATE AREA - METHOD 1]: Fetch Dynamic Services from Catalog API
            // Endpoint: GET /api/services
            // Scope: Populates the session specialty dropdown from backend services
            // =========================================================================
            fetchDynamicServices() {
                fetch('/api/services')
                    .then(res => res.json())
                    .then(resData => {
                        if (resData.status === 'success' && Array.isArray(resData.data) && resData.data.length > 0) {
                            const serviceNames = resData.data.map(s => s.name || s.title).filter(Boolean);
                            if (serviceNames.length > 0) {
                                this.availableServices = serviceNames;
                            }
                        }
                    })
                    .catch(err => {
                        console.log('Using default services list:', err);
                    });
            },

            // =========================================================================
            // 👩‍💻 [TEAMMATE AREA - METHOD 2]: Live Date Availability Verification
            // Endpoint: GET /api/bookings/availability?date=YYYY-MM-DD
            // Scope: Queries date availability and updates live status badge
            // =========================================================================
            handleDateChange() {
                if (!this.form.session_date) {
                    this.availabilityStatus = null;
                    return;
                }

                this.availabilityStatus = 'checking';
                this.availabilityMessage = 'Checking date...';

                fetch(`/api/bookings/availability?date=${this.form.session_date}`)
                    .then(res => res.json())
                    .then(resData => {
                        if (resData.status === 'success') {
                            if (resData.available) {
                                this.availabilityStatus = 'available';
                                this.availabilityMessage = '✓ Date Available';
                            } else {
                                this.availabilityStatus = 'busy';
                                this.availabilityMessage = '✕ Fully Booked';
                            }
                        } else {
                            this.availabilityStatus = null;
                        }
                    })
                    .catch(() => {
                        // Graceful fallback if availability endpoint is not yet connected
                        this.availabilityStatus = 'available';
                        this.availabilityMessage = '✓ Date Available';
                    });
            },

            // =========================================================================
            // 👨‍💻 [LEAD AREA - METHOD 3]: Submit Booking as 'Pending' & Open Confirmation
            // Endpoint: POST /api/bookings
            // Scope: Validates payload, saves booking as 'pending', triggers dossier modal
            // =========================================================================
            submitBooking() {
                this.submitting = true;
                this.errorMessage = null;

                const payload = {
                    client_name: this.form.client_name,
                    client_phone: this.form.client_phone,
                    client_email: this.form.client_email,
                    session_date: this.form.session_date,
                    start_time: this.form.start_time,
                    end_time: this.form.start_time === '10:00 AM' ? '01:00 PM' : (this.form.start_time === '02:30 PM' ? '06:30 PM' : '05:00 PM'),
                    session_type: this.form.session_type,
                    location: this.form.location,
                    notes: this.form.notes,
                };

                fetch('/api/bookings', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                })
                .then(res => res.json())
                .then(resData => {
                    this.submitting = false;
                    if (resData.status === 'success') {
                        // Store rich confirmation data returned by the API
                        this.confirmation = resData.confirmation || {
                            reference_number: (resData.data && resData.data.reference_number) || 'ARP-' + Date.now().toString().slice(-6),
                            client_name: payload.client_name,
                            client_email: payload.client_email,
                            client_phone: payload.client_phone,
                            session_date: payload.session_date,
                            start_time: payload.start_time,
                            end_time: payload.end_time,
                            session_type: payload.session_type,
                            location: payload.location,
                            lead_photographer: 'Ashan Rumaiz (Principal)',
                            status_label: 'Pending Studio Review',
                        };
                        this.showConfirmationModal = true;
                    } else {
                        this.errorMessage = resData.message || (resData.errors ? Object.values(resData.errors).flat().join(', ') : 'Failed to submit booking.');
                    }
                })
                .catch(err => {
                    this.submitting = false;
                    console.error('Error submitting booking:', err);
                    this.errorMessage = 'Network error occurred. Please check your connection and try again.';
                });
            },

            // =========================================================================
            // 👨‍💻 [LEAD AREA - METHOD 4]: Confirmation Dossier Utilities (Print, Copy, .ICS)
            // Scope: Date formatting, clipboard copy, print docket, iCalendar export
            // =========================================================================
            formatDisplayDate(dateStr) {
                if (!dateStr) return '';
                const parts = dateStr.split('-');
                if (parts.length === 3) {
                    const date = new Date(parts[0], parts[1] - 1, parts[2]);
                    return date.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
                }
                return dateStr;
            },

            copyReferenceCode() {
                if (!this.confirmation || !this.confirmation.reference_number) return;
                navigator.clipboard.writeText(this.confirmation.reference_number).then(() => {
                    this.copied = true;
                    setTimeout(() => { this.copied = false; }, 2500);
                });
            },

            printDocket() {
                window.print();
            },

            /**
             * Generates and downloads an iCalendar (.ics) appointment file.
             */
            downloadCalendarInvite() {
                if (!this.confirmation) return;
                const c = this.confirmation;
                const dateClean = (c.session_date || '').replace(/-/g, '');
                const icsContent = [
                    'BEGIN:VCALENDAR',
                    'VERSION:2.0',
                    'PRODID:-//Ashan Rumaiz Photography//Booking Confirmation//EN',
                    'BEGIN:VEVENT',
                    `UID:${c.reference_number}@ashanrumaiz.lk`,
                    `DTSTAMP:${dateClean}T090000Z`,
                    `DTSTART:${dateClean}T100000Z`,
                    `DTEND:${dateClean}T170000Z`,
                    `SUMMARY:Photography Session - ${c.session_type} (${c.reference_number})`,
                    `DESCRIPTION:Session with Ashan Rumaiz Photography\\nStatus: Pending Review\\nClient: ${c.client_name}\\nLocation: ${c.location}`,
                    `LOCATION:${c.location}`,
                    'STATUS:TENTATIVE',
                    'END:VEVENT',
                    'END:VCALENDAR'
                ].join('\r\n');

                const blob = new Blob([icsContent], { type: 'text/calendar;charset=utf-8' });
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.setAttribute('download', `Booking-${c.reference_number}.ics`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            },

            closeConfirmation() {
                this.showConfirmationModal = false;
            },

            resetAndNewBooking() {
                this.showConfirmationModal = false;
                this.confirmation = null;
                this.availabilityStatus = null;
                this.form = {
                    client_name: '',
                    client_phone: '',
                    client_email: '',
                    session_date: '',
                    start_time: '10:00 AM',
                    session_type: '',
                    location: '',
                    notes: '',
                };
            }
        }
    }).mount('#app');
</script>

</body>
</html>
