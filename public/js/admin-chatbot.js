(function () {
    'use strict';

    const API = '/api/admin/chatbot';

    const page = document.getElementById('chatbot-page');
    if (!page) {
        return;
    }

    function $(selector, root) { return (root || page).querySelector(selector); }
    function $$(selector, root) { return Array.from((root || page).querySelectorAll(selector)); }

    function el(tag, className, text) {
        const node = document.createElement(tag);
        if (className) { node.className = className; }
        if (text !== undefined && text !== null) { node.textContent = text; }
        return node;
    }

    const toastBox = $('#toast');
    let toastTimer = null;

    function toast(message, isError) {
        toastBox.textContent = message;
        toastBox.classList.toggle('error', !!isError);
        toastBox.hidden = false;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { toastBox.hidden = true; }, 4000);
    }

    function clearErrors(root) {
        $$('[data-error-for]', root).forEach(function (box) { box.textContent = ''; });
        $$('.has-error', root).forEach(function (field) { field.classList.remove('has-error'); });
    }

    function showErrors(root, errors) {
        Object.keys(errors || {}).forEach(function (key) {
            const name = key.split('.')[0];
            const box = $('[data-error-for="' + name + '"]', root);
            const message = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
            if (box) { box.textContent = message; }
            $$('[name="' + name + '"]', root).forEach(function (field) { field.classList.add('has-error'); });
        });
    }

    if (!window.adminAuth) {
        toast('admin-guard.js is not loaded, so the page cannot talk to the server.', true);
        return;
    }

    const DEFAULTS = {
        bot_name: 'Ashan Studio Concierge',
        tone: 'luxury_warm',
        handoff_channel: 'Studio Producer WhatsApp + Ashan Mobile',
        calendar_check: true,
        high_value_alert: true,
        human_approval: true
    };

    const demo = {
        settings: Object.assign({}, DEFAULTS),
        stats: {
            total_conversations: 342, total_change: 18.4, automated_percent: 94,
            qualification_rate: 76.5, qualification_change: 4.2, forwarded_leads: 262,
            avg_response_seconds: 1.4, handoff_requests: 14
        },
        counts: { all: 28, ai_active: 21, booked: 12 },
        conversations: [
            { id: 1, client_name: 'Ananya Perera', status: 'ai_responded', minutes_ago: 4, groups: ['ai_active'],
              snippet: 'Asked for Signature Wedding package pricing and availability in...', meta: ['Dec 14, 2025', '$2,800 Retainer'] },
            { id: 2, client_name: 'Mark & Sophie Davies', status: 'needs_human', minutes_ago: 12, groups: [],
              snippet: 'Requesting custom destination elopement shoot with seaplane...', meta: ['Mirissa / Weligama', 'Budget $4,500+'] },
            { id: 3, client_name: 'Dilshan Abeywickrama', status: 'lead_qualified', minutes_ago: 60, groups: ['ai_active', 'booked'],
              snippet: 'Inquired about Corporate headshot corporate rates for 15...', meta: ['Brand Studio', 'Lookbook Sent'] },
            { id: 4, client_name: 'Nadeesha Fernando', status: 'calendar_sent', minutes_ago: 120, groups: ['ai_active'],
              snippet: 'Checking newborn studio availability for next Sunday morning...', meta: ['Studio Bay B'] }
        ],
        answers: [
            { id: 1, question: 'What services do you offer?', keywords: ['service', 'offer'],
              answer: 'We photograph weddings and couples, maternity and newborn sessions, portraits and lifestyle, and events.',
              link_label: 'See our services', link_url: '/services', is_active: true },
            { id: 2, question: 'How do I book?', keywords: ['book', 'deposit', 'reserve'],
              answer: 'A 50% non-refundable deposit is required to secure your date. The remaining balance is due before the final photos are delivered.',
              link_label: 'Book now', link_url: '/booking', is_active: true },
            { id: 3, question: 'How can I contact you?', keywords: ['contact', 'phone', 'email'],
              answer: 'You can reach us by phone or email, or send an inquiry from the contact page.',
              link_label: 'Contact page', link_url: '/contact', is_active: false }
        ],
        nextId: 4
    };

    function demoStreams(filter, search) {
        const term = (search || '').toLowerCase();
        const items = demo.conversations.filter(function (c) {
            const inFilter = filter === 'all' || c.groups.indexOf(filter) !== -1;
            const text = (c.client_name + ' ' + c.snippet + ' ' + c.meta.join(' ')).toLowerCase();
            return inFilter && (term === '' || text.indexOf(term) !== -1);
        });
        return { counts: demo.counts, items: items };
    }

    let demoMode = false;

    async function call(method, path, body, demoFn) {
        if (!demoMode) {
            try {
                const result = await window.adminAuth.json(API + path, { method: method, body: body });
                return result.data;
            } catch (e) {
                if (!(e.status === 404 || e instanceof TypeError)) {
                    throw e;
                }
                demoMode = true;
                $('#demo-banner').hidden = false;
            }
        }
        return demoFn();
    }

    const getSettings = function () {
        return call('GET', '/settings', undefined, function () { return Object.assign({}, demo.settings); });
    };
    const saveSettings = function (data) {
        return call('PUT', '/settings', data, function () {
            Object.assign(demo.settings, data);
            return Object.assign({}, demo.settings);
        });
    };
    const getStats = function () {
        return call('GET', '/stats', undefined, function () { return Object.assign({}, demo.stats); });
    };
    const getStreams = function (filter, search) {
        return call('GET', '/conversations?filter=' + encodeURIComponent(filter) + '&search=' + encodeURIComponent(search),
            undefined, function () { return demoStreams(filter, search); });
    };
    const getAnswers = function () {
        return call('GET', '/answers', undefined, function () {
            return demo.answers.map(function (a) { return Object.assign({}, a); });
        });
    };
    const createAnswer = function (data) {
        return call('POST', '/answers', data, function () {
            const item = Object.assign({ id: demo.nextId++, is_active: true }, data);
            demo.answers.push(item);
            return Object.assign({}, item);
        });
    };
    const updateAnswer = function (id, data) {
        return call('PUT', '/answers/' + id, data, function () {
            const item = demo.answers.find(function (a) { return String(a.id) === String(id); });
            Object.assign(item, data);
            return Object.assign({}, item);
        });
    };
    const setAnswerActive = function (id, active) {
        return call('PATCH', '/answers/' + id + '/active', { is_active: active }, function () {
            demo.answers.find(function (a) { return String(a.id) === String(id); }).is_active = active;
        });
    };
    const deleteAnswer = function (id) {
        return call('DELETE', '/answers/' + id, undefined, function () {
            demo.answers = demo.answers.filter(function (a) { return String(a.id) !== String(id); });
        });
    };

    function setStat(name, text) {
        $$('[data-stat="' + name + '"]').forEach(function (node) { node.textContent = text; });
    }

    function setTrend(name, value) {
        $$('[data-stat="' + name + '"]').forEach(function (node) {
            if (value === undefined || value === null) { node.hidden = true; return; }
            node.hidden = false;
            node.textContent = (value >= 0 ? '+' : '') + value + '%';
        });
    }

    function renderStats(s) {
        setStat('total_conversations', s.total_conversations);
        setTrend('total_change', s.total_change);
        setStat('automated_percent', s.automated_percent);
        setStat('qualification_rate', s.qualification_rate + '%');
        setTrend('qualification_change', s.qualification_change);
        setStat('forwarded_leads', s.forwarded_leads);
        setStat('avg_response', Number(s.avg_response_seconds).toFixed(1) + 's');
        setStat('handoff_requests', s.handoff_requests);
    }

    const settingsCard = $('#settings-card');

    function fillSettings(s) {
        $$('[name]', settingsCard).forEach(function (field) {
            if (field.type === 'radio') {
                field.checked = field.value === s.tone;
            } else if (field.type === 'checkbox') {
                field.checked = !!s[field.name];
            } else if (field.name in s) {
                field.value = s[field.name] === null ? '' : s[field.name];
            }
        });
    }

    function collectSettings() {
        const payload = {};
        $$('[name]', settingsCard).forEach(function (field) {
            if (field.type === 'radio') {
                if (field.checked) { payload.tone = field.value; }
            } else if (field.type === 'checkbox') {
                payload[field.name] = field.checked;
            } else {
                payload[field.name] = field.value.trim();
            }
        });
        return payload;
    }

    $('#settings-save').addEventListener('click', async function () {
        clearErrors(settingsCard);
        const payload = collectSettings();

        if (payload.bot_name === '') {
            showErrors(settingsCard, { bot_name: ['Please enter a display name for the bot.'] });
            return;
        }
        if (!payload.tone) {
            showErrors(settingsCard, { tone: ['Choose a tone.'] });
            return;
        }

        const button = $('#settings-save');
        button.disabled = true;
        try {
            fillSettings(await saveSettings(payload));
            toast(demoMode ? 'Saved in the demo only (the API does not exist yet).' : 'Bot settings saved.');
        } catch (e) {
            if (e.status === 422) { showErrors(settingsCard, e.errors); }
            toast(e.status === 422 ? 'Please fix the highlighted fields.' : (e.message || 'Could not save.'), true);
        } finally {
            button.disabled = false;
        }
    });

    $('#settings-revert').addEventListener('click', async function () {
        if (!window.confirm('Restore the default bot settings?')) { return; }
        clearErrors(settingsCard);
        try {
            fillSettings(await saveSettings(DEFAULTS));
            toast('Default settings restored.');
        } catch (e) {
            toast(e.message || 'Could not restore the defaults.', true);
        }
    });

    const STATUS_LABELS = {
        ai_responded: 'AI RESPONDED',
        needs_human: 'NEEDS HUMAN',
        lead_qualified: 'LEAD QUALIFIED',
        calendar_sent: 'CALENDAR SENT',
        booked: 'BOOKED'
    };

    let streamFilter = 'all';
    let searchTimer = null;

    function agoText(item) {
        let minutes = item.minutes_ago;
        if ((minutes === undefined || minutes === null) && item.created_at) {
            minutes = Math.max(0, Math.round((Date.now() - new Date(item.created_at).getTime()) / 60000));
        }
        if (minutes === undefined || minutes === null) { return ''; }
        if (minutes < 60) { return minutes + 'm ago'; }
        if (minutes < 1440) { return Math.round(minutes / 60) + 'h ago'; }
        return Math.round(minutes / 1440) + 'd ago';
    }

    function renderStreams(data) {
        const list = $('#stream-list');
        list.textContent = '';
        const items = data.items || [];

        items.forEach(function (item) {
            const li = el('li', 'stream');

            const head = el('div', 'stream-head');
            head.appendChild(el('strong', null, item.client_name));
            head.appendChild(el('span', 'status status-' + item.status, STATUS_LABELS[item.status] || item.status));
            head.appendChild(el('span', 'ago', agoText(item)));
            li.appendChild(head);

            li.appendChild(el('p', 'snippet', item.snippet || ''));

            const chips = el('div', 'chips');
            (item.meta || []).forEach(function (text) { chips.appendChild(el('span', 'chip', text)); });
            li.appendChild(chips);

            list.appendChild(li);
        });

        $$('[data-count]').forEach(function (node) {
            const counts = data.counts || {};
            node.textContent = counts[node.dataset.count] !== undefined ? counts[node.dataset.count] : 0;
        });
        $('#stream-empty').hidden = items.length > 0;
    }

    async function loadStreams() {
        try {
            renderStreams(await getStreams(streamFilter, $('#stream-search').value.trim()));
        } catch (e) {
            toast(e.message || 'Could not load the conversations.', true);
        }
    }

    $$('[data-filter]').forEach(function (tab) {
        tab.addEventListener('click', function () {
            streamFilter = tab.dataset.filter;
            $$('[data-filter]').forEach(function (other) {
                const active = other === tab;
                other.classList.toggle('active', active);
                other.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            loadStreams();
        });
    });

    $('#stream-search').addEventListener('input', function () {
        clearTimeout(searchTimer);
        searchTimer = setTimeout(loadStreams, 300);  
    });

    const answerForm = $('#answer-form');
    let answers = [];

    function openForm(answer) {
        clearErrors(answerForm);
        answerForm.reset();
        $('[name="id"]', answerForm).value = answer ? answer.id : '';
        $('#answer-form-title').textContent = answer ? 'Edit answer' : 'Add answer';

        if (answer) {
            $('[name="question"]', answerForm).value = answer.question || '';
            $('[name="keywords"]', answerForm).value = (answer.keywords || []).join(', ');
            $('[name="answer"]', answerForm).value = answer.answer || '';
            $('[name="link_label"]', answerForm).value = answer.link_label || '';
            $('[name="link_url"]', answerForm).value = answer.link_url || '';
        }

        answerForm.hidden = false;
        $('[name="question"]', answerForm).focus();
    }

    function closeForm() {
        answerForm.hidden = true;
        answerForm.reset();
        clearErrors(answerForm);
    }

    function renderAnswers() {
        const list = $('#answer-list');
        list.textContent = '';

        answers.forEach(function (answer) {
            const li = el('li', 'answer' + (answer.is_active ? '' : ' is-off'));

            const main = el('div', 'answer-main');
            main.appendChild(el('strong', null, answer.question));
            main.appendChild(el('p', 'answer-text', answer.answer));
            const chips = el('div', 'chips');
            (answer.keywords || []).forEach(function (word) { chips.appendChild(el('span', 'chip', word)); });
            if (answer.link_url) {
                chips.appendChild(el('span', 'chip chip-link', 'Link: ' + (answer.link_label || answer.link_url)));
            }
            main.appendChild(chips);
            li.appendChild(main);

            const side = el('div', 'answer-actions');

            const toggle = el('label', 'switch-wrap');
            const input = document.createElement('input');
            input.type = 'checkbox';
            input.className = 'switch';
            input.checked = !!answer.is_active;
            input.setAttribute('aria-label', 'Active: ' + answer.question);
            input.addEventListener('change', async function () {
                try {
                    await setAnswerActive(answer.id, input.checked);
                    toast(input.checked ? 'Answer activated.' : 'Answer deactivated.');
                } catch (e) {
                    input.checked = !input.checked;
                    toast(e.message || 'Could not change the answer.', true);
                }
                loadAnswers();
            });
            toggle.appendChild(input);
            toggle.appendChild(el('span', 'switch-label', answer.is_active ? 'Active' : 'Off'));
            side.appendChild(toggle);

            const edit = el('button', 'btn btn-light', 'Edit');
            edit.type = 'button';
            edit.addEventListener('click', function () { openForm(answer); });
            side.appendChild(edit);

            const remove = el('button', 'btn btn-link', 'Delete');
            remove.type = 'button';
            remove.addEventListener('click', async function () {
                if (!window.confirm('Delete this answer?')) { return; }
                try {
                    await deleteAnswer(answer.id);
                    toast('Answer deleted.');
                    loadAnswers();
                } catch (e) {
                    toast(e.message || 'Could not delete the answer.', true);
                }
            });
            side.appendChild(remove);

            li.appendChild(side);
            list.appendChild(li);
        });

        $('#answer-empty').hidden = answers.length > 0;
    }

    async function loadAnswers() {
        try {
            answers = await getAnswers();
            renderAnswers();
        } catch (e) {
            toast(e.message || 'Could not load the answers.', true);
        }
    }

    $('#answer-add').addEventListener('click', function () { openForm(null); });
    $('#answer-cancel').addEventListener('click', closeForm);

    answerForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        clearErrors(answerForm);

        const id = $('[name="id"]', answerForm).value;
        const question = $('[name="question"]', answerForm).value.trim();
        const answerText = $('[name="answer"]', answerForm).value.trim();
        const linkLabel = $('[name="link_label"]', answerForm).value.trim();
        const linkUrl = $('[name="link_url"]', answerForm).value.trim();

        const keywords = [];
        $('[name="keywords"]', answerForm).value.split(',').forEach(function (word) {
            const clean = word.trim().toLowerCase();
            if (clean !== '' && keywords.indexOf(clean) === -1) { keywords.push(clean); }
        });

        const errors = {};
        if (question === '') { errors.question = ['Please enter the question.']; }
        else if (question.length > 150) { errors.question = ['Use 150 characters or fewer.']; }
        if (keywords.length === 0) { errors.keywords = ['Add at least one keyword, separated by commas.']; }
        if (answerText === '') { errors.answer = ['Please write the answer.']; }
        else if (answerText.length > 1000) { errors.answer = ['Use 1000 characters or fewer.']; }
        if (linkUrl !== '' && !/^(\/|https?:\/\/)/.test(linkUrl)) {
            errors.link_url = ['Start with / (a page on this site) or https://.'];
        }
        if (Object.keys(errors).length) {
            showErrors(answerForm, errors);
            return;
        }

        const payload = {
            question: question,
            keywords: keywords,
            answer: answerText,
            link_label: linkLabel === '' ? null : linkLabel,
            link_url: linkUrl === '' ? null : linkUrl
        };

        const button = $('[type="submit"]', answerForm);
        button.disabled = true;
        try {
            if (id) { await updateAnswer(id, payload); }
            else { await createAnswer(payload); }
            closeForm();
            toast(id ? 'Answer updated.' : 'Answer added.');
            loadAnswers();
        } catch (e) {
            if (e.status === 422) { showErrors(answerForm, e.errors); }
            toast(e.status === 422 ? 'Please fix the highlighted fields.' : (e.message || 'Could not save the answer.'), true);
        } finally {
            button.disabled = false;
        }
    });

    async function start() {
        try { fillSettings(await getSettings()); } catch (e) { toast(e.message || 'Could not load the settings.', true); }
        try { renderStats(await getStats()); } catch (e) { toast(e.message || 'Could not load the numbers.', true); }
        loadStreams();
        loadAnswers();
    }

    start();
})();