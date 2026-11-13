(function () {
    var logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            logoutButton.disabled = true;
            if (window.adminAuth) {
                window.adminAuth.logout();
            } else {
                window.location.replace('/admin/login');
            }
        });
    }

    var toggle = document.getElementById('menu-toggle');
    var backdrop = document.getElementById('sidebar-backdrop');

    function setMenu(open) {
        document.body.classList.toggle('sidebar-open' , open);
        if (toggle) {
            toggle.setAttribute('aria-expanded' , open ? 'true' : 'false');
        }
    }

    if (toggle) {
        toggle.addEventListener('click' , function () {
            setMenu(!document.body.classList.contains('sidebar-open'));
        });
    }
    if (backdrop) {
        backdrop.addEventListener('click' , function () { setMenu(false); });
    }
    document.addEventListener('keydown' , function (event) {
        if (event.key === 'Escape') {
            setMenu(false);
        }
    });

    var nameBox = document.getElementById('topbar-name');
    var avatarImg = document.getElementById('topbar-avatar');
    var avatarIcon = document.getElementById('topbar-avatar-icon');

    if (nameBox && window.adminAuth) {
        window.adminAuth.json('/api/admin/settings').then(function (result) {
            var settings = result && result.data;
            if (!settings) {
                return;
            }
            if (settings.studio_name) {
                nameBox.textContent = settings.studio_name;
            }
            if (settingsavatar_url && avatarImg) {
                avatarImg.srcsrc = settings.avatar_url;
                avatarImg.hidden = false;
                if (avatarIcon) {
                    avatarIcon.hidden = true;
                }
            }
        })
        .catch(function () {});
    }
})();