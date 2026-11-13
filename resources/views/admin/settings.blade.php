@extends('layouts.admin')
 
@section('title', 'Settings')
 
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-settings.css') }}">
@endpush
 
@section('content')
<div class="settings-page" id="settings-page">
 
    <p class="crumb">SYSTEM DOSSIER / PREFERENCES &amp; AUTHORITY</p>
    <h1>Studio Configuration &amp; Governance</h1>
    <p class="lead">Manage executive credentials, atelier presence, security parameters, and contractual dispatch rules.</p>
 
    <div id="toast" class="toast" role="status" hidden></div>
 
    <div class="settings-grid">
 
        <div class="settings-col">
 
            <section class="card" data-section="identity">
                <h2>Studio Identity &amp; Artist Dossier</h2>
                <p class="hint">Public artistic attribution and client-facing communique coordinates.</p>
 
                <div class="avatar-row">
                    <div class="avatar">
                        <img id="avatar-img" alt="Profile picture" hidden>
                        <span id="avatar-fallback">A</span>
                    </div>
                    <div>
                        <h3><span id="display-name">Studio</span> <span class="badge">ADMIN</span></h3>
                        <div class="avatar-actions">
                            <button type="button" class="btn btn-light" id="avatar-change">Change Avatar</button>
                            <button type="button" class="btn btn-link" id="avatar-remove">Remove</button>
                            <input type="file" id="avatar-input" accept="image/png,image/jpeg,image/webp" hidden>
                        </div>
                        <p class="field-error" data-error-for="avatar"></p>
                    </div>
                </div>
 
                <div class="fields two-col">
                    <label class="field">
                        <span>Studio / Artist Legal Name</span>
                        <input type="text" name="studio_name" maxlength="100">
                        <em class="field-error" data-error-for="studio_name"></em>
                    </label>
                    <label class="field">
                        <span>Studio Dispatch Email</span>
                        <input type="email" name="dispatch_email" maxlength="150">
                        <em class="field-error" data-error-for="dispatch_email"></em>
                    </label>
                    <label class="field">
                        <span>Contact Number (Direct Line)</span>
                        <input type="text" name="phone" maxlength="30">
                        <em class="field-error" data-error-for="phone"></em>
                    </label>
                    <label class="field">
                        <span>Tax ID / Business Registration</span>
                        <input type="text" name="tax_id" maxlength="100">
                        <em class="field-error" data-error-for="tax_id"></em>
                    </label>
                </div>
 
                <label class="field">
                    <span>Studio Address</span>
                    <input type="text" name="address" maxlength="255">
                    <em class="field-error" data-error-for="address"></em>
                </label>
 
                <label class="field">
                    <span>Short Bio</span>
                    <textarea name="bio" rows="3" maxlength="1000"></textarea>
                    <em class="field-error" data-error-for="bio"></em>
                </label>
 
                <label class="field">
                    <span>Artist Note</span>
                    <textarea name="artist_note" rows="3" maxlength="1000"></textarea>
                    <em class="field-error" data-error-for="artist_note"></em>
                </label>
 
                <div class="portal-row">
                    <div>
                        <strong>Client Direction Portal</strong>
                        <p>Public booking map pinned to your studio address</p>
                    </div>
                    <span class="pill">ACTIVE PIN</span>
                </div>
 
                <div class="actions">
                    <button type="button" class="btn btn-blue" data-save>Update Records</button>
                </div>
            </section>
 
            <section class="card" data-section="hours">
                <div class="card-head">
                    <div>
                        <h2>Atelier Hours &amp; Studio Bookability</h2>
                        <p class="hint">Automatic buffers applied between consecutive shoot dates.</p>
                    </div>
                    <span class="pill">STANDARD TIER</span>
                </div>
 
                <div class="tiles">
                    <div class="tile">
                        <span class="tile-label">SHOOTING DAYS</span>
                        <div class="days">
                            <label><input type="checkbox" name="shooting_days" value="1"><span>Mon</span></label>
                            <label><input type="checkbox" name="shooting_days" value="2"><span>Tue</span></label>
                            <label><input type="checkbox" name="shooting_days" value="3"><span>Wed</span></label>
                            <label><input type="checkbox" name="shooting_days" value="4"><span>Thu</span></label>
                            <label><input type="checkbox" name="shooting_days" value="5"><span>Fri</span></label>
                            <label><input type="checkbox" name="shooting_days" value="6"><span>Sat</span></label>
                            <label><input type="checkbox" name="shooting_days" value="0"><span>Sun</span></label>
                        </div>
                        <small>Days left unticked stay dark (lab and retouching).</small>
                        <em class="field-error" data-error-for="shooting_days"></em>
                    </div>
 
                    <div class="tile">
                        <span class="tile-label">DAILY WINDOW</span>
                        <div class="time-pair">
                            <input type="time" name="daily_start" aria-label="Opening time">
                            <span>to</span>
                            <input type="time" name="daily_end" aria-label="Closing time">
                        </div>
                        <small>Golden hour window</small>
                        <em class="field-error" data-error-for="daily_start"></em>
                        <em class="field-error" data-error-for="daily_end"></em>
                    </div>
 
                    <div class="tile">
                        <span class="tile-label">TURNAROUND BUFFER</span>
                        <div class="number-unit">
                            <input type="number" name="turnaround_hours" min="0" max="168" aria-label="Turnaround buffer in hours">
                            <span>hours</span>
                        </div>
                        <small>Mandatory equipment reset</small>
                        <em class="field-error" data-error-for="turnaround_hours"></em>
                    </div>
                </div>
 
                <div class="actions">
                    <button type="button" class="btn btn-blue" data-save>Save Hours</button>
                </div>
            </section>
 
            <section class="card" data-section="notifications">
                <div class="card-head">
                    <div>
                        <h2>Notification Preferences</h2>
                        <p class="hint">Select triggers for immediate SMS alerts and prioritized executive email summaries.</p>
                    </div>
                    <span class="pill">CONFIGURED</span>
                </div>
 
                <label class="check-row">
                    <span>New high-value inquiry alert (above Rs.
                        <input type="number" name="high_value_threshold" min="0" max="1000000" class="inline-number" aria-label="High-value threshold in Rs"> )
                    </span>
                    <input type="checkbox" name="notify_high_value">
                </label>
                <em class="field-error" data-error-for="high_value_threshold"></em>
 
                <label class="check-row">
                    <span>Contract electronically countersigned by client</span>
                    <input type="checkbox" name="notify_contract_signed">
                </label>
 
                <label class="check-row">
                    <span>Deposit payment clearing via Stripe / Wire</span>
                    <input type="checkbox" name="notify_deposit">
                </label>
 
                <div class="actions">
                    <button type="button" class="btn btn-blue" data-save>Save Preferences</button>
                </div>
            </section>
 
            <section class="card" data-section="protocols">
                <div class="card-head">
                    <div>
                        <h2>Booking Protocols &amp; Deposits</h2>
                        <p class="hint">Mandatory reservation retention rates and schedule hold guidelines.</p>
                    </div>
                    <span class="pill pill-rose">ENFORCED</span>
                </div>
 
                <div class="tiles two">
                    <div class="tile">
                        <span class="tile-label">RETAINER DEPOSIT</span>
                        <div class="number-unit">
                            <input type="number" name="retainer_percent" min="0" max="100" aria-label="Retainer deposit percent">
                            <span>% down</span>
                        </div>
                        <small>Due at contract issuance</small>
                        <em class="field-error" data-error-for="retainer_percent"></em>
                    </div>
                    <div class="tile">
                        <span class="tile-label">GRACE PERIOD</span>
                        <div class="number-unit">
                            <input type="number" name="grace_hours" min="0" max="720" aria-label="Grace period in hours">
                            <span>hours</span>
                        </div>
                        <small>Tentative calendar hold</small>
                        <em class="field-error" data-error-for="grace_hours"></em>
                    </div>
                </div>
 
                <div class="actions between">
                    <span class="muted">Standard Retainer Agreement v4.1</span>
                    <button type="button" class="btn btn-light" disabled title="Legal terms editing is not part of this page yet">Edit Legal Terms</button>
                    <button type="button" class="btn btn-blue" data-save>Save Protocols</button>
                </div>
            </section>
        </div>
 
        <div class="settings-col">

            <section class="card">
                <h2>Account &amp; Security</h2>
                <p class="hint">Cryptographic keys, password policies &amp; session hygiene.</p>
 
                <form id="security-form" novalidate>
                    <label class="field">
                        <span>Current Administrative Password</span>
                        <div class="password-wrap">
                            <input type="password" name="current_password" autocomplete="current-password">
                            <button type="button" class="eye" data-toggle-password aria-label="Show or hide password">Show</button>
                        </div>
                        <em class="field-error" data-error-for="current_password"></em>
                    </label>
 
                    <label class="field">
                        <span>New Administrative Password</span>
                        <div class="password-wrap">
                            <input type="password" name="new_password" autocomplete="new-password" placeholder="Min. 12 characters with a special character">
                            <button type="button" class="eye" data-toggle-password aria-label="Show or hide password">Show</button>
                        </div>
                        <em class="field-error" data-error-for="new_password"></em>
                    </label>
 
                    <label class="field">
                        <span>Confirm New Password</span>
                        <div class="password-wrap">
                            <input type="password" name="new_password_confirmation" autocomplete="new-password" placeholder="Repeat the new password">
                            <button type="button" class="eye" data-toggle-password aria-label="Show or hide password">Show</button>
                        </div>
                        <em class="field-error" data-error-for="new_password_confirmation"></em>
                    </label>
 
                    <div class="twofa">
                        <div>
                            <strong>Two-Factor Authentication</strong>
                            <p>Authenticator app code required on every admin sign-in. Managed in the two-factor task.</p>
                        </div>
                        <input type="checkbox" checked disabled aria-label="Two-factor authentication (managed separately)">
                    </div>
 
                    <h4 class="sessions-title">AUTHORIZED SESSIONS</h4>
                    <div class="session"><span>This browser</span><span class="muted">Active now</span></div>
 
                    <div class="actions">
                        <button type="reset" class="btn btn-light" id="security-cancel">Cancel</button>
                        <button type="submit" class="btn btn-plum">Save Security Changes</button>
                    </div>
                </form>
            </section>
 
            <a class="btn btn-plum wide" href="/admin/chatbot-settings">Chat Bot Settings</a>
        </div>
    </div>
</div>
@endsection
 
@push('scripts')
    <script src="{{ asset('js/admin-settings.js') }}"></script>
@endpush