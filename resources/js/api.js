function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
}

async function request(method, url, data = null) {
    const options = {
        method,
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    };

    if (method !== 'GET') {
        options.headers['Content-Type'] = 'application/json';
        options.headers['X-CSRF-TOKEN'] = csrfToken();
    }
    if (data !== null) {
        options.body = JSON.stringify(data);
    }

    const response = await fetch(url, options);

    let body = null;
    try {
        body = await response.json();
    } catch (e) {

    }

    if (!response.ok) {
        const error = new Error(body?.message || `Request failed (${response.status})`);
        error.status = response.status;      
        error.errors = body?.errors || {};     
        throw error;
    }

    return body;
}

export function firstErrors(error) {
    const result = {};
    for (const field in error.errors || {}) {
        result[field] = error.errors[field][0];
    }
    return result;
}

export const api = {
    get:    (url)       => request('GET', url),
    post:   (url, data) => request('POST', url, data),
    put:    (url, data) => request('PUT', url, data),
    patch:  (url, data) => request('PATCH', url, data),
    delete: (url)       => request('DELETE', url),
};