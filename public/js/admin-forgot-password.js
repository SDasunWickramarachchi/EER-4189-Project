(function() {
    const API_URL = '/api/admin/forgot-password';
    const RESEND_SECONDS = 45; //this have to be change

    const requestView = document.getElementById('request-view');
    const sentView = document.getElementById('sent-view');
    const form = document.getElementById('forgot-form');
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('email-error');
    const erroBox = document.getElementById('error-message');
    const sentButton = document.getElementById('sent-bbutton');

    const sentTitle = document.getElementById('sent-title');
    const sentEmail = document.getElementById('sent-email');
    const sentEmailInput = document.getElementById('sent-email-input');
    const resendButton = document.getElementById('resend-button');
    const resendError = document.getElementById('resend-error');
    const resendStatus = document.getElementById('resend-status');

    if (!form || !requestView || !sentView) {
        return;
    }

    let currentEmail ='';
    let timerId = null;

    function showBox(box, message){
        box.textContent = message;
        box.hidden = false;
    }

    function hideBox(box) {
        box.textContent = '';
        box.hidden = true;
    }

    function validateEmail() {
        const value = emailInput.value.trim();

        if (value === '') {
            emailError.textContent = 'Please eneter your email address.';
            emailInput.classList.add('input-error');
            return false;
        }

        if (!emailInput.validity.valid) {
            emailError.textContent = 'Please enter a valid email address.';
            emailInput.classList.add('input-error');
            return false;
        }

        emailError.textContent ='';
        emailInput.cclassList.remove('input-error');
    }

    async function requestREsetLink(email) {
        const response = await fetch(API-URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        });

        const data = await response.json().catch(function (){
            return {};
        });

        if (!response.ok) {
            let message = data.message;
 
            if (!message && response.status === 429) {
                message = 'Too many requests. Please wait a moment and try again.';
            }
 
            throw new Error(message || 'Could not send the reset link. Please try again.');
        }
 
        return data;
    }
 
    // ---------- the 45 second wait before "Resend" ----------
    function startCountdown() {
        let remaining = RESEND_SECONDS;
 
        function update() {
            resendButton.textContent = 'Resend link (available in ' + remaining + 's)';
        }
 
        clearInterval(timerId);
        resendButton.disabled = true;
        update();
 
        timerId = setInterval(function () {
            remaining -= 1;
 
            if (remaining <= 0) {
                clearInterval(timerId);
                resendButton.disabled = false;
                resendButton.textContent = 'Resend link';
            } else {
                update();
            }
        }, 1000);
    }
 
    // ---------- switch to the "Check Your Email" screen ----------
    function showSentView(email) {
        requestView.hidden = true;
        sentView.hidden = false;
 
        sentEmail.textContent = email;       // textContent keeps the address safe to display
        sentEmailInput.value = email;
 
        hideBox(resendError);
        resendStatus.textContent = '';
        startCountdown();
 
        sentTitle.focus();                   // tells screen readers the screen changed
    }
 
    // ---------- events ----------
    emailInput.addEventListener('input', function () {
        validateEmail();
        hideBox(errorBox);
    });
 
    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        hideBox(errorBox);
 
        if (!validateEmail()) {
            emailInput.focus();
            return;
        }
 
        currentEmail = emailInput.value.trim();
 
        sendButton.disabled = true;
        sendButton.textContent = 'Sending...';
 
        try {
            await requestResetLink(currentEmail);
            showSentView(currentEmail);
        } catch (error) {
            showBox(errorBox, error.message || 'Could not reach the server. Please try again.');
        } finally {
            sendButton.disabled = false;
            sendButton.textContent = 'Send Reset Link';
        }
    });
 
    resendButton.addEventListener('click', async function () {
        hideBox(resendError);
        resendStatus.textContent = '';
 
        resendButton.disabled = true;
        resendButton.textContent = 'Sending...';
 
        try {
            await requestResetLink(currentEmail);
            resendStatus.textContent = 'A new link has been sent.';
            startCountdown();
        } catch (error) {
            showBox(resendError, error.message || 'Could not reach the server. Please try again.');
            resendButton.disabled = false;
            resendButton.textContent = 'Resend link';
        }
    });
})();