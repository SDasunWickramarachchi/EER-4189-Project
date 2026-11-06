(function () {
    const TOKEN_KEY = 'admin_token';
    const API_URL = '/api/admin/login';
    const DASHBOARD_URL = '/admin/dashboard';   
    
    // Testing bypass: off for everyone by default.
    // To turn it on in YOUR browser only, run this in the console (F12):
    //   localStorage.setItem('dev_mode', '1')
    let DEV_MODE = false;
    try { DEV_MODE = localStorage.getItem('dev_mode') === '1'; } catch (e) {}

    function nextUrl() {
        const next = new URLSearchParams(window.location.search).get('next');
        const insideAdmin = next && /^\/admin(\/|\?|$)/.test(next) && next.indexOf('//') === -1;
        const isLoginPage = next && /^\/admin\/(login|forgot-password)/.test(next);

        return insideAdmin && !isLoginPage ? next : DASHBOARD_URL;
    }

    const form = document.getElementById('login-form');
    const errorBox = document.getElementById('error-message');
    const button = document.getElementById('login-button');

    if (!form || !errorBox || !button) {
        return;
    }

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    try {
        if (
            localStorage.getItem(TOKEN_KEY) ||
            sessionStorage.getItem(TOKEN_KEY)
        ) {
            window.location.href = nextUrl();
            return;
        }
    } catch (e) {
    }

    function showError(message) {
        errorBox.textContent = message;
        errorBox.hidden = false;
    }

    function clearError() {
        errorBox.textContent = '';
        errorBox.hidden = true;
    }

    function validateEmail() {
        const value = email.value.trim();

        if (value === '') {
            emailError.textContent = 'Please enter your email address.';
            email.classList.add('input-error');
            return false;
        }

        if (!email.validity.valid) {
            emailError.textContent = 'Please enter a valid email address.';
            email.classList.add('input-error');
            return false;
        }

        emailError.textContent = '';
        email.classList.remove('input-error');
        return true;
    }

    function validatePassword() {
        if (password.value.trim() === '') {
            passwordError.textContent = 'Please enter your password.';
            password.classList.add('input-error');
            return false;
        }

        passwordError.textContent = '';
        password.classList.remove('input-error');
        return true;
    }

    email.addEventListener('input', function () {
        validateEmail();
        clearError();
    });

    password.addEventListener('input', function () {
        validatePassword();
        clearError();
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        clearError();

        const emailIsValid = validateEmail();
        const passwordIsValid = validatePassword();

        if (!emailIsValid || !passwordIsValid) {
            if (!emailIsValid) {
                email.focus();
            } else {
                password.focus();
            }
            return;
        }

        const emailValue = email.value.trim();
        const passwordValue = password.value;
        const rememberCheckbox = form.querySelector('input[name="remember"]');
        const remember = rememberCheckbox ? rememberCheckbox.checked : false;

        if (DEV_MODE) {
            try {
                const devStorage = remember ? localStorage : sessionStorage;
                devStorage.setItem(TOKEN_KEY, 'dev-token');
            } catch (e) {
                showError('Unable to save your login session. Please check your browser settings.');
                return;
            }

            window.location.href = nextUrl();
            return;
        }

        button.disabled = true;
        button.textContent = 'Signing in...';

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    email: emailValue,
                    password: passwordValue
                })
            });

            const data = await response.json().catch(function () {
                return {};
            });

            if (!response.ok || !data.token) {
                showError(data.message || 'Invalid email or password.');
                return;
            }

            try {
                const storage = remember ? localStorage : sessionStorage;
                storage.setItem(TOKEN_KEY, data.token);
            } catch (e) {
                showError('Unable to save your login session. Please check your browser settings.');
                return;
            }

            window.location.href = nextUrl();

        } catch (e) {
            showError('Could not reach the server. Please try again.');
        } finally {
            button.disabled = false;
            button.textContent = 'Login';
        }
    });
})();