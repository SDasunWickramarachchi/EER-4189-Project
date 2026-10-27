<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Admin Login | Ashan Rumaiz Photography</title>
        
        <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">    </head>
<body>
    
    <main class="login-page">
        
        <section class="login-image">
            <img src="{{ asset('images/admin-login.jpg') }}" alt="Photogrpher">
        </section>

        <section class="login-panel">
            <div class="login-content"> 

                <header class="login-header">
                    <h1>Admin Login</h1>
                    <p>Enter your studio credentials to manage bookings, portfolio and client enquiries.</p>
                </header>

                <div id="error-message" class="error-message"role="alert" hidden></div>

                <form id="login-form" novalidate>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" placeholder="name@exmaple.com" autocomplete="username" required>
                        <small class="field-error" id="email-error"></small>
                    </div>

                    <div class="form-group">
                        <label forr="passowrd">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                        <small class="field-error" id="password-error"></small>
                    </div>


                    <div class="form-options">
                        <label class="remeber-option">
                            <input type="checkbox" name="remeber"value="1">
                            <span>Remeber me</span>
                        </label>
                        <a href="{{ url('/admin/forgot-password') }}" class="forgot-link">Forgot Password?</a>
                    </div>

                    <button type="submit" id="login-button" class="login-button">Login</button>
                </form>

            </div>
        </section>

    </main>

    <script src="{{ asset('js/admin-login.js') }}" defer></script>

</body>
</html>

