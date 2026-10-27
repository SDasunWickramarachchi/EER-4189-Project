<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Ashan Rumaiz Photography</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-forgot-password.css') }}">
</head>
<body>
    <main class="login-page">

        <section class="login-image">
            <img src="{{ asset('images/admin-login.jpg') }}" alt="Photographer">
        </section>

        <section class="login-panel">
            <div class="login-content">

                <div id="request-view">
                    <header class="login-header">
                        <h1>Forgot Password</h1>
                        <p>Enter your studio email to recover your account and receive secure reset instructions.</p>
                    </header>

                    <div id="error-message" class="error-message" role="alert" hidden></div>

                    <form id="forgot-form" novalidate>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="name@example.com"
                                   autocomplete="email" required>
                            <small class="field-error" id="email-error" role="alert"></small>
                            <small class="helper-text">The link is valid for 15 minutes.</small>
                        </div>

                        <button type="submit" id="send-button" class="login-button">Send Reset Link</button>
                    </form>
                </div>

                <div id="sent-view" hidden>
                    <div class="sent-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                             stroke-linejoin="round" stroke-linecap="round">
                            <rect x="2.5" y="4.5" width="19" height="15" rx="2"/>
                            <path d="M3 6l9 7 9-7"/>
                        </svg>
                    </div>

                    <header class="login-header">
                        <h1 id="sent-title" tabindex="-1">Check Your Email</h1>
                        <p>If an admin account exists for <strong id="sent-email"></strong>,
                           a reset link is on its way. The link is valid for 15 minutes.</p>
                    </header>

                    <div class="form-group">
                        <label for="sent-email-input">Email Address</label>
                        <input type="email" id="sent-email-input" readonly disabled>
                    </div>

                    <div id="resend-error" class="error-message" role="alert" hidden></div>
                    <p id="resend-status" class="status-message" role="status" aria-live="polite"></p>

                    <button type="button" id="resend-button" class="resend-button" disabled>
                        Resend link (available in 45s)
                    </button>
                </div>

                <a href="{{ url('/admin/login') }}" class="back-link">&larr; Back to Admin Login</a>
            </div>
        </section>

    </main>
    <script src="{{ asset('js/admin-forgot-password.js') }}" defer></script>
</body>
</html>







