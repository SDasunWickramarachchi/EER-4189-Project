/* put <script src="{{ asset('js/admin-guard.js') }}"></script> in every admin pages except login and forgot*/
(function () {
    'use strict';

    var TOKEN_KEY = 'admin_token';
    var LOGIN_URL = '/admin/login';
    var LOGOUT_API = '/api/admin/logout';   

    function getToken() {
        try {
            return localStorage.getItem(TOKEN_KEY) || sessionStorage.getItem(TOKEN_KEY);
        } catch (e) {
            return null;
        }
    }

    function clearToken() {
        try { localStorage.removeItem(TOKEN_KEY); } catch (e){}
        try { sessionStorage.removeItem(TOKEN_KEY); } catch (e){}
        }

    function goToLogin() {
        var here = window.location.pathname + window.location.search;
        window.location.replace(LOGIN_URL + '?next=' + encodeURIComponent(here));
    }

    if (!getToken()) {
        document.documentElement.style.display = 'none';   
        goToLogin();
        return;
    }

    window.addEventListener('pageshow', function (event) {
        if (event.persisted && !getToken()) {
            goToLogin();
        }
    });

    function adminFetch(url, options) {
        options = options || {};

        var token = getToken();
        if (!token) {
            goToLogin();
            return Promise.reject(new Error('Not signed in'));
        }

        var headers = Object.assign({ 'Accept': 'application/json' }, options.headers || {});
        headers['Authorization'] = 'Bearer ' + token;

        var body = options.body;
        var isPlainObject = body && typeof body === 'object' && !(body instanceof FormData);
        if (isPlainObject) {
            body = JSON.stringify(body);
            headers['Content-Type'] = 'application/json';
        }

        return fetch(url, Object.assign({}, options, { headers: headers, body: body })).then(function (response) {
            if (response.status === 401) {
                clearToken();   
                goToLogin();
                throw new Error('Session expired');
            }
            return response;
        });
    }

    function adminJson(url, options) {
        return adminFetch(url, options).then(function (response) {
            return response.json().catch(function () { return {}; }).then(function (data) {
                if (!response.ok) {
                    var error = new Error(data.message || 'Request failed (' + response.status + ')');
                    error.status = response.status;
                    error.errors = data.errors || {};
                    throw error;
                }
                return data;
            });
        });
    }

    function logout() {
        var token = getToken();
        clearToken();

        if (token) {
            try {
                fetch(LOGOUT_API, {
                    method: 'POST',
                    keepalive: true,
                    headers: { 'Accept': 'application/json', 'Authorization': 'Bearer ' + token }
                }).catch(function () {});
            } catch (e) {
            }
        }

        window.location.replace(LOGIN_URL);
    }

    window.adminAuth = {
        token: getToken,
        fetch: adminFetch,
        json: adminJson,
        logout: logout
    };

    document.addEventListener('click', function (event) {
        var button = event.target.closest('[data-admin-logout], .btn-sidebar-logout');
        if (button) {
            event.preventDefault();
            logout();
        }
    });
})();