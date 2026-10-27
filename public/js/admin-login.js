(function () {
    const TOKEN_KEY = 'admin_token';
    const API_URL = '/api/admin/login';
    const DASHBOARD_URL = '/admin/dashboard';

    const form = document.getElementById('login-form');
    const errorBox = document.getElementById('error-message');
    const button = document.getElementById('login-button');

    // Stop if the required HTML elements do not exist.
    if (!form || !errorBox || !button) {
        return;
    }

    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const emailError = document.getElementById('email-error');
    const passwordError = document.getElementById('password-error');

    // Redirect if an admin token is already stored.
    try {
        if (
            localStorage.getItem(TOKEN_KEY) ||
            sessionStorage.getItem(TOKEN_KEY)
        ) {
            window.location.href = DASHBOARD_URL;
            return;
        }
    } catch (e) {
        // Continue if browser storage is unavailable.
    }

    // Display a general error message.
    function showError(message) {
        errorBox.textContent = message;
        errorBox.hidden = false;
    }

    // Hide the general error message.
    function clearError() {
        errorBox.textContent = '';
        errorBox.hidden = true;
    }

    // Validate the email field.
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

    // Validate the password field.
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

    // Clear or update field errors as the user types.
    email.addEventListener('input', function () {
        validateEmail();
        clearError();
    });

    password.addEventListener('input', function () {
        validatePassword();
        clearError();
    });

    // Handle login submission.
    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        clearError();

        const emailIsValid = validateEmail();
        const passwordIsValid = validatePassword();

        // Do not send the API request if the fields are invalid.
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
        const rememberCheckbox = form.querySelector(
            'input[name="remember"]'
        );
        const remember = rememberCheckbox
            ? rememberCheckbox.checked
            : false;

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

            // Handle unsuccessful login responses.
            if (!response.ok || !data.token) {
                showError(
                    data.message || 'Invalid email or password.'
                );
                return;
            }

            // Store the token according to the Remember Me choice.
            try {
                const storage = remember
                    ? localStorage
                    : sessionStorage;

                storage.setItem(TOKEN_KEY, data.token);
            } catch (e) {
                showError(
                    'Unable to save your login session. Please check your browser settings.'
                );
                return;
            }

            // Navigate to the dashboard after successful login.
            window.location.href = DASHBOARD_URL;

        } catch (e) {
            showError(
                'Could not reach the server. Please try again.'
            );
        } finally {
            button.disabled = false;
            button.textContent = 'Login';
        }
    });
})();