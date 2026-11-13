(function () {
    const API = '/api/admin/settings';
    const PASSWORD_API = '/api/admin/change-password';

    const page = document.getElementById('settings-page');
    if (!page) {
        return;
    }

    const toastBox = document.getElementById('toast');
    let toastTimer = null;

    function toast(message, isError) {
        toastBox.textContent = message;
        toastBox.classList.toggle('error', !!isError);
        toastBox.hidden = false;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toastBox.hidden = true; }, 4000);
    }

    async function request(url, options) {
        try {
            const response = await window.adminAuth.fetch(url, options);
            const data = await response.json().catch(function () { return {}; });
            return { ok: response.ok, status: response.status, data: data };
        } catch (e) {
            if (e && (e.message === 'Session expired' || e.message === 'Not signed in')) {
                return { ok: false, status: 401, data: { message: 'Your session has ended.' } };   
            }
            return { ok: false, status: 0, data: { message: 'Could not reach the server. Please try again.' } };
        }
    }

    function clearErrors(root) {
        root.querySelectorAll('[data-error-for]').forEach(function (el) { el.textContent = ''; });
        root.querySelectorAll('.has-error').forEach(function (el) { el.classList.remove('has-error'); });
    }

    function showErrors(root, errors) {
        Object.keys(errors || {}).forEach(function (key) {
            const field = key.split('.')[0];   
            const box = root.querySelector('[data-error-for="' + field + '"]');
            const message = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
            if (box) {
                box.textContent = message;
            }
            root.querySelectorAll('[name="' + field + '"]').forEach(function (el) { el.classList.add('has-error'); });
        });
    }

    const avatarImg = document.getElementById('avatar-img');
    const avatarFallback = document.getElementById('avatar-fallback');
    const displayName = document.getElementById('display-name');

    function showAvatar(settings) {
        const name = (settings.studio_name || 'Studio').trim();
        displayName.textContent = name;
        avatarFallback.textContent = name.charAt(0).toUpperCase();

        if (settings.avatar_url) {
            avatarImg.src = settings.avatar_url;
            avatarImg.hidden = false;
            avatarFallback.hidden = true;
        } else {
            avatarImg.removeAttribute('src');
            avatarImg.hidden = true;
            avatarFallback.hidden = false;
        }
    }

    function fill(settings) {
        page.querySelectorAll('[data-section] [name]').forEach(function (el) {
            const name = el.name;

            if (name === 'shooting_days') {
                el.checked = (settings.shooting_days || []).map(Number).indexOf(Number(el.value)) !== -1;
            } else if (el.type === 'checkbox') {
                el.checked = !!settings[name];
            } else if (name in settings) {
                el.value = settings[name] === null ? '' : settings[name];
            }
        });
        showAvatar(settings);
    }

    async function load() {
        const result = await request(API);
        if (result.ok && result.data.data) {
            fill(result.data.data);
        } else {
            toast(result.data.message || 'Could not load the settings.', true);
        }
    }

    function collect(section) {
        const payload = {};
        const days = [];

        section.querySelectorAll('[name]').forEach(function (el) {
            const name = el.name;

            if (name === 'shooting_days') {
                if (el.checked) {
                    days.push(Number(el.value));
                }
            } else if (el.type === 'checkbox') {
                payload[name] = el.checked;
            } else if (el.type === 'number') {
                payload[name] = el.value === '' ? null : Number(el.value);
            } else {
                const value = el.value.trim();
                payload[name] = value === '' ? null : value;
            }
        });

        if (section.querySelector('[name="shooting_days"]')) {
            payload.shooting_days = days;
        }
        return payload;
    }

    page.querySelectorAll('[data-section]').forEach(function (section) {
        const button = section.querySelector('[data-save]');
        if (!button) {
            return;
        }

        button.addEventListener('click', async function () {
            clearErrors(section);

            const label = button.textContent;
            button.disabled = true;
            button.textContent = 'Saving...';

            const result = await request(API, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(collect(section))
            });

            button.disabled = false;
            button.textContent = label;

            if (result.ok) {
                fill(result.data.data);
                toast(result.data.message || 'Settings saved.');
            } else if (result.status === 422) {
                showErrors(section, result.data.errors);
                toast('Please fix the highlighted fields.', true);
            } else {
                toast(result.data.message || 'Could not save. Please try again.', true);
            }
        });
    });

    const avatarInput = document.getElementById('avatar-input');
    const avatarBox = avatarInput.closest('.avatar-row');

    document.getElementById('avatar-change').addEventListener('click', function () {
        avatarInput.click();
    });

    avatarInput.addEventListener('change', async function () {
        if (!avatarInput.files.length) {
            return;
        }
        clearErrors(avatarBox);

        const form = new FormData();
        form.append('avatar', avatarInput.files[0]);

        const result = await request(API + '/avatar', { method: 'POST', body: form });
        avatarInput.value = '';

        if (result.ok) {
            showAvatar(result.data.data);
            toast(result.data.message || 'Avatar updated.');
        } else if (result.status === 422) {
            showErrors(avatarBox, result.data.errors);
        } else {
            toast(result.data.message || 'Could not upload the picture.', true);
        }
    });

    document.getElementById('avatar-remove').addEventListener('click', async function () {
        const result = await request(API + '/avatar', { method: 'DELETE' });

        if (result.ok) {
            showAvatar(result.data.data);
            toast(result.data.message || 'Avatar removed.');
        } else {
            toast(result.data.message || 'Could not remove the picture.', true);
        }
    });

    const securityForm = document.querySelector('form');

    page.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = button.parentElement.querySelector('input');
            const hide = input.type === 'text';
            input.type = hide ? 'password' : 'text';
            button.textContent = hide ? 'Show' : 'Hide';
        });
    });

    securityForm.addEventListener('reset', function () {
        clearErrors(securityForm);
        securityForm.querySelectorAll('input[type="text"]').forEach(function (input) {
            input.type = 'password';
        });
        securityForm.querySelectorAll('[data-toggle-password]').forEach(function (b) { b.textContent = 'Show'; });
    });

    securityForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors(securityForm);

        const current = securityForm.querySelector('[name="current_password"]').value;
        const next = securityForm.querySelector('[name="new_password"]').value;
        const confirm = securityForm.querySelector('[name="new_password_confirmation"]').value;

        const errors = {};
        if (current === '') {
            errors.current_password = ['Please enter your current password.'];
        }
        if (next.length < 12) {
            errors.new_password = ['Use at least 12 characters.'];
        } else if (!/[^A-Za-z0-9]/.test(next)) {
            errors.new_password = ['Include at least one special character, for example ! or #.'];
        }
        if (confirm !== next) {
            errors.new_password_confirmation = ['The passwords do not match.'];
        }
        if (Object.keys(errors).length) {
            showErrors(securityForm, errors);
            return;
        }

        const button = securityForm.querySelector('button[type="submit"]');
        const label = button.textContent;
        button.disabled = true;
        button.textContent = 'Saving...';

        const result = await request(PASSWORD_API, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                current_password: current,
                new_password: next,
                new_password_confirmation: confirm
            })
        });

        button.disabled = false;
        button.textContent = label;

        if (result.ok) {
            securityForm.reset();
            toast(result.data.message || 'Password changed.');
        } else if (result.status === 404) {
            toast('Password change is not available yet.', true);
        } else if (result.status === 422) {
            showErrors(securityForm, result.data.errors);
        } else {
            toast(result.data.message || 'Could not change the password.', true);
        }
    });

    load();
})();