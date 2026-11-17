@extends('layouts.admin')

@section('title', 'Chatbot Settings')

@push('styles')
    <link rel="stylesheet" href="/css/admin-chatbot.css">
@endpush

@section('content')
<div class="chatbot-page" id="chatbot-page">

    <h1>AI Chatbot Management</h1>
    <p class="lead">Configure automated inquiry qualification, studio rate card dissemination, and live human handoff protocols.</p>

    <div id="demo-banner" class="banner" hidden>
        Demo data: the chatbot API does not exist yet, so nothing here is saved on the server.
    </div>
    <div id="toast" class="toast" role="status" hidden></div>

    <!-- The four number cards -->
    <section class="stats" aria-label="Chatbot numbers">
        <article class="stat">
            <header><span class="stat-label">TOTAL BOT CONVS</span><i class="ti ti-messages" aria-hidden="true"></i></header>
            <div class="stat-value"><strong data-stat="total_conversations">0</strong><span class="trend" data-stat="total_change" hidden></span></div>
            <p class="stat-foot"><span>Current Month Cycle</span><span><b data-stat="automated_percent">0</b>% automated</span></p>
        </article>
        <article class="stat">
            <header><span class="stat-label">LEAD QUALIFICATION RATE</span><i class="ti ti-circle-check" aria-hidden="true"></i></header>
            <div class="stat-value"><strong data-stat="qualification_rate">0%</strong><span class="trend" data-stat="qualification_change" hidden></span></div>
            <p class="stat-foot"><span>Forwarded to Bookings</span><span><b data-stat="forwarded_leads">0</b> leads</span></p>
        </article>
        <article class="stat">
            <header><span class="stat-label">AVG. RESPONSE TIME</span><i class="ti ti-bolt" aria-hidden="true"></i></header>
            <div class="stat-value"><strong data-stat="avg_response">0s</strong><span class="trend neutral">Sub-second edge</span></div>
            <p class="stat-foot"><span>Global CDN Latency</span><span>Instant 24/7</span></p>
        </article>
        <article class="stat">
            <header><span class="stat-label">HUMAN HANDOFF REQUESTS</span><i class="ti ti-headset" aria-hidden="true"></i></header>
            <div class="stat-value"><strong data-stat="handoff_requests">0</strong><span class="trend alert">NEEDS ACTION</span></div>
            <p class="stat-foot"><span>Average Takeover SLA</span><span class="alert-text">&lt; 15 mins</span></p>
        </article>
    </section>

    <div class="cb-grid">

        <div class="cb-col">

            <!-- Bot settings -->
            <section class="card" id="settings-card">
                <h2><i class="ti ti-robot" aria-hidden="true"></i> Bot Settings</h2>

                <div class="two">
                    <label class="field">
                        <span>BOT DISPLAY NAME</span>
                        <input type="text" name="bot_name" maxlength="60">
                        <em class="field-error" data-error-for="bot_name"></em>
                    </label>
                    <label class="field">
                        <span>HANDOFF NOTIFICATION CHANNEL</span>
                        <input type="text" name="handoff_channel" maxlength="120">
                        <em class="field-error" data-error-for="handoff_channel"></em>
                    </label>
                </div>

                <div class="tones" role="radiogroup" aria-labelledby="tones-label">
                    <span class="tones-label" id="tones-label">PERSONA TONE PROFILE</span>
                    <label class="tone"><input type="radio" name="tone" value="luxury_warm"><span><i class="ti ti-diamond" aria-hidden="true"></i>Luxury &amp; Warm</span></label>
                    <label class="tone"><input type="radio" name="tone" value="formal_editorial"><span><i class="ti ti-book" aria-hidden="true"></i>Formal Editorial</span></label>
                    <label class="tone"><input type="radio" name="tone" value="playful_creative"><span><i class="ti ti-palette" aria-hidden="true"></i>Playful Creative</span></label>
                    <label class="tone"><input type="radio" name="tone" value="concise_direct"><span><i class="ti ti-gauge" aria-hidden="true"></i>Concise &amp; Direct</span></label>
                    <em class="field-error" data-error-for="tone"></em>
                </div>

                <label class="toggle-row">
                    <span>
                        <strong>Instant Calendar Availability Check</strong>
                        <small>Live query Google/Admin Master Calendar to report provisional open slots.</small>
                    </span>
                    <input type="checkbox" class="switch" name="calendar_check">
                </label>
                <label class="toggle-row">
                    <span>
                        <strong>High-Value Lead WhatsApp/SMS Instant Alert</strong>
                        <small>Triggers high-priority push dispatch if client quotes a budget above $3,500.</small>
                    </span>
                    <input type="checkbox" class="switch" name="high_value_alert">
                </label>
                <label class="toggle-row">
                    <span>
                        <strong>Require Human Approval Before Confirming Bookings</strong>
                        <small>Bot offers provisional holds; payment invoice link requires studio sign-off.</small>
                    </span>
                    <input type="checkbox" class="switch" name="human_approval">
                </label>

                <div class="actions between">
                    <button type="button" class="btn btn-link" id="settings-revert">REVERT TO DEFAULTS</button>
                    <button type="button" class="btn btn-blue" id="settings-save">Save Settings</button>
                </div>
            </section>

            <!-- Bot answers: add, edit, activate, deactivate -->
            <section class="card" id="answers-card">
                <div class="card-head">
                    <div>
                        <h2>Bot Answers</h2>
                        <p class="hint">Questions the chatbot can answer. Switch an answer off to stop the bot from using it.</p>
                    </div>
                    <button type="button" class="btn btn-blue" id="answer-add">Add Answer</button>
                </div>

                <form id="answer-form" class="answer-form" hidden novalidate>
                    <h3 id="answer-form-title">Add answer</h3>
                    <input type="hidden" name="id">

                    <label class="field">
                        <span>Question visitors ask</span>
                        <input type="text" name="question" maxlength="150" placeholder="For example: What are your prices?">
                        <em class="field-error" data-error-for="question"></em>
                    </label>
                    <label class="field">
                        <span>Keywords (separated by commas)</span>
                        <input type="text" name="keywords" placeholder="price, cost, package">
                        <em class="field-error" data-error-for="keywords"></em>
                    </label>
                    <label class="field">
                        <span>Answer</span>
                        <textarea name="answer" rows="3" maxlength="1000"></textarea>
                        <em class="field-error" data-error-for="answer"></em>
                    </label>
                    <div class="two">
                        <label class="field">
                            <span>Link button text (optional)</span>
                            <input type="text" name="link_label" maxlength="60" placeholder="View packages">
                            <em class="field-error" data-error-for="link_label"></em>
                        </label>
                        <label class="field">
                            <span>Link address (optional)</span>
                            <input type="text" name="link_url" maxlength="255" placeholder="/packages">
                            <em class="field-error" data-error-for="link_url"></em>
                        </label>
                    </div>

                    <div class="actions">
                        <button type="button" class="btn btn-light" id="answer-cancel">Cancel</button>
                        <button type="submit" class="btn btn-blue">Save Answer</button>
                    </div>
                </form>

                <ul class="answer-list" id="answer-list"></ul>
                <p class="muted" id="answer-empty" hidden>No answers yet. Click Add Answer to create the first one.</p>
            </section>
        </div>

        <!-- Inquiry streams -->
        <section class="card" id="streams-card">
            <div class="card-head">
                <h2><i class="ti ti-inbox" aria-hidden="true"></i> Inquiry Streams</h2>
                <span class="sync">REAL-TIME SYNC</span>
            </div>

            <div class="tabs" role="tablist">
                <button type="button" class="tab active" role="tab" aria-selected="true" data-filter="all">All (<b data-count="all">0</b>)</button>
                <button type="button" class="tab" role="tab" aria-selected="false" data-filter="ai_active">AI Active (<b data-count="ai_active">0</b>)</button>
                <button type="button" class="tab" role="tab" aria-selected="false" data-filter="booked">Booked (<b data-count="booked">0</b>)</button>
            </div>

            <div class="search-box">
                <i class="ti ti-search" aria-hidden="true"></i>
                <input type="search" id="stream-search" placeholder="Search client name, phone, or package inquiry..." aria-label="Search conversations">
            </div>

            <ul class="stream-list" id="stream-list"></ul>
            <p class="muted" id="stream-empty" hidden>No conversations match.</p>
        </section>
    </div>
</div>
@endsection

@push('scripts')
    <script src="/js/admin-chatbot.js"></script>
@endpush