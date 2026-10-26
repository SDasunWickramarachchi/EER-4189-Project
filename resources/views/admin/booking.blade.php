<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management | Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #0b3954;
            --sidebar-active: #086390;
            --main-bg: #e5ebf0;
            --card-bg: #ffffff;
            --maroon-btn: #672635;
            --text-dark: #1f2937;
            --border-color: #e2e8f0;
            --status-confirmed: #dbeafe;
            --status-confirmed-text: #1d4ed8;
            --status-pending: #fce7f3;
            --status-pending-text: #be185d;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--main-bg);
            color: var(--text-dark);
            height: 100vh;
            overflow: hidden;
        }

        .admin-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 1.5rem 1rem;
            flex-shrink: 0;
        }

        .sidebar-logo {
            background-color: #fff;
            border-radius: 6px;
            padding: 0.8rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .sidebar-logo img {
            max-width: 100%;
            height: 35px;
            object-fit: contain;
        }

        .nav-section-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #8da4b5;
            margin-bottom: 1rem;
            padding-left: 0.5rem;
        }

        .sidebar-menu {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: #d1e2ed;
            text-decoration: none;
            padding: 0.7rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: var(--sidebar-active);
            color: #fff;
        }

        .logout-btn {
            background: var(--sidebar-active);
            color: #fff;
            border: none;
            padding: 0.8rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-weight: 600;
            margin-top: auto;
        }

        /* Main Workspace */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .top-bar {
            background: #d6eaf5;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }

        .search-box {
            width: 45%;
        }

        .search-box input {
            width: 100%;
            padding: 0.6rem 1rem;
            border: none;
            border-radius: 6px;
            background: #c3e2f4;
            font-size: 0.9rem;
            outline: none;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .user-profile {
            background: #0b3954;
            color: #fff;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Content Area */
        .workspace {
            padding: 2rem 2.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.8rem;
        }

        .title-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .title-bar h1 {
            font-size: 2.2rem;
            font-family: 'Playfair Display', serif;
            color: #0b3954;
            font-weight: 600;
        }

        .title-bar p {
            color: #555;
            font-size: 0.95rem;
            margin-top: 0.3rem;
        }

        .btn-group-top {
            display: flex;
            gap: 1rem;
        }

        .btn-calendar {
            background: #fff;
            border: 1px solid #ccc;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.85rem;
            cursor: pointer;
        }

        .btn-new-booking {
            background-color: var(--maroon-btn);
            color: #fff;
            border: none;
            padding: 0.6rem 1.4rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
        }

        /* Summary Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .stat-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-info h4 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #777;
            margin-bottom: 0.5rem;
        }

        .stat-info .num {
            font-size: 2.2rem;
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #111;
        }

        .stat-info .sub {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.3rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: #e9f2f8;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        /* Tabs & Filter Bar */
        .tabs-row {
            display: flex;
            gap: 0.6rem;
        }

        .tab-btn {
            background: #e2eaef;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            color: #444;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-btn.active {
            background: #1e293b;
            color: #fff;
        }

        .tab-count {
            background: rgba(255,255,255,0.3);
            padding: 0.1rem 0.5rem;
            border-radius: 10px;
            font-size: 0.75rem;
        }

        .quick-filter-bar {
            display: flex;
            gap: 1.5rem;
            background: rgba(255, 255, 255, 0.6);
            padding: 0.8rem 1.2rem;
            border-radius: 8px;
            align-items: center;
        }

        .filter-item {
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .filter-item label {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #666;
            font-weight: 600;
        }

        .filter-item input, .filter-item select {
            background: transparent;
            border: none;
            font-size: 0.85rem;
            font-weight: 500;
            outline: none;
        }

        /* Bookings Table */
        .table-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
        }

        .bookings-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bookings-table th {
            text-align: left;
            padding: 1rem 1.4rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #555;
            background-color: #fafafa;
            border-bottom: 2px solid var(--border-color);
        }

        .bookings-table td {
            padding: 1.2rem 1.4rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .client-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar-circle {
            width: 42px;
            height: 42px;
            background-color: #cbd5e1;
            color: #334155;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .client-info strong {
            display: block;
            color: #111;
            font-size: 0.95rem;
        }

        .client-info span {
            display: block;
            color: #666;
            font-size: 0.8rem;
        }

        .date-cell strong {
            display: block;
            color: #111;
        }

        .date-cell span {
            color: #666;
            font-size: 0.8rem;
        }

        .status-pill {
            display: inline-block;
            padding: 0.35rem 0.9rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .status-pill.confirmed {
            background-color: var(--status-confirmed);
            color: var(--status-confirmed-text);
        }

        .status-pill.pending {
            background-color: var(--status-pending);
            color: var(--status-pending-text);
        }

        .status-pill.completed {
            background-color: #dcfce7;
            color: #15803d;
        }

        .status-pill.cancelled {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .status-select {
            padding: 0.4rem 0.6rem;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 0.8rem;
            font-weight: 500;
            outline: none;
        }
    </style>
</head>
<body>

<div id="admin-app" class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="sidebar-logo">
                <img src="/images/logo.png" alt="Ashan Rumaiz">
            </div>

            <div class="nav-section-title">Admin Console</div>

            <ul class="sidebar-menu">
                <li><a href="#">📊 Dashboard</a></li>
                <li><a href="/admin/booking" class="active">📖 Booking</a></li>
                <li><a href="#">🖼️ Portfolio</a></li>
                <li><a href="#">✉️ Inquiries</a></li>
                <li><a href="/admin/services">⚙️ Services</a></li>
                <li><a href="#">📦 Packages</a></li>
                <li><a href="#">📅 Calendar</a></li>
                <li><a href="#">🤖 Chatbot Settings</a></li>
                <li><a href="#">⚙️ Settings</a></li>
            </ul>
        </div>

        <button class="logout-btn">
            🚪 Log Out
        </button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Search Bar -->
        <header class="top-bar">
            <div class="search-box">
                <input type="text" v-model="filters.search" @input="fetchBookings" placeholder="Search clients, shoots, catalog, invoices...">
            </div>

            <div class="profile-area">
                <span style="cursor: pointer;">🔔</span>
                <span style="cursor: pointer;">ℹ️</span>
                <div class="user-profile">
                    👤 Ashan Rumaiz
                </div>
            </div>
        </header>

        <!-- Main Workspace -->
        <div class="workspace">
            <div class="title-bar">
                <div>
                    <h1>Booking Management</h1>
                    <p>Manage bookings, confirm sessions, and keep every shoot on schedule, all in one place.</p>
                </div>
                <div class="btn-group-top">
                    <button class="btn-calendar">📅 Calendar View</button>
                    <button class="btn-new-booking">+ New Booking</button>
                </div>
            </div>

            <!-- Stats Overview Cards (Dynamic from API) -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Total Bookings</h4>
                        <div class="num">{{ stats.total_bookings || 0 }}</div>
                        <div class="sub">↑ +18.4% this month</div>
                    </div>
                    <div class="stat-icon">📑</div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Confirmed Shoots</h4>
                        <div class="num">{{ stats.confirmed_shoots || 0 }}</div>
                        <div class="sub">Contracts executed</div>
                    </div>
                    <div class="stat-icon">✔️</div>
                </div>

                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Awaiting Retainer</h4>
                        <div class="num">{{ stats.awaiting_retainer || 0 }}</div>
                        <div class="sub" style="color: #b91c1c;">Requires follow-up</div>
                    </div>
                    <div class="stat-icon">📋</div>
                </div>
            </div>

            <!-- Status Filter Tabs -->
            <div class="tabs-row">
                <button :class="['tab-btn', activeTab === 'all' ? 'active' : '']" @click="setTab('all')">
                    All Bookings <span class="tab-count">{{ stats.counts_by_status?.all || 0 }}</span>
                </button>
                <button :class="['tab-btn', activeTab === 'confirmed' ? 'active' : '']" @click="setTab('confirmed')">
                    Confirmed <span class="tab-count">{{ stats.counts_by_status?.confirmed || 0 }}</span>
                </button>
                <button :class="['tab-btn', activeTab === 'pending' ? 'active' : '']" @click="setTab('pending')">
                    Pending Review <span class="tab-count">{{ stats.counts_by_status?.pending || 0 }}</span>
                </button>
                <button :class="['tab-btn', activeTab === 'completed' ? 'active' : '']" @click="setTab('completed')">
                    Completed <span class="tab-count">{{ stats.counts_by_status?.completed || 0 }}</span>
                </button>
                <button :class="['tab-btn', activeTab === 'cancelled' ? 'active' : '']" @click="setTab('cancelled')">
                    Cancelled <span class="tab-count">{{ stats.counts_by_status?.cancelled || 0 }}</span>
                </button>
            </div>

            <!-- Quick Filter Bar -->
            <div class="quick-filter-bar">
                <div class="filter-item">
                    <label>Service Type</label>
                    <select v-model="filters.session_type" @change="fetchBookings">
                        <option value="All Specialties">All Specialties</option>
                        <option value="Weddings & Couples">Weddings & Couples</option>
                        <option value="Maternity">Maternity</option>
                        <option value="Portraits & Lifestyle">Portraits & Lifestyle</option>
                        <option value="Events & Corporate">Events & Corporate</option>
                    </select>
                </div>

                <div class="filter-item">
                    <label>Lead Photographer</label>
                    <select>
                        <option>Ashan Rumaiz (Principal)</option>
                    </select>
                </div>
            </div>

            <!-- Table Card -->
            <div class="table-card">
                <table class="bookings-table">
                    <thead>
                        <tr>
                            <th>Client Matter & Contact</th>
                            <th>Date & Time</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td colspan="5" style="text-align: center; color: #888;">Loading bookings...</td>
                        </tr>
                        <tr v-else-if="bookings.length === 0">
                            <td colspan="5" style="text-align: center; color: #888;">No bookings found for this filter.</td>
                        </tr>
                        <tr v-else v-for="b in bookings" :key="b._id || b.id">
                            <td>
                                <div class="client-cell">
                                    <div class="avatar-circle">{{ getInitials(b.client_name) }}</div>
                                    <div class="client-info">
                                        <strong>{{ b.client_name }}</strong>
                                        <span>{{ b.client_email }} • {{ b.client_phone }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="date-cell">
                                <strong>{{ formatDate(b.session_date) }}</strong>
                                <span>{{ b.start_time || '10:00 AM' }} – {{ b.end_time || '05:00 PM' }}</span>
                            </td>
                            <td>{{ b.location }}</td>
                            <td>
                                <span :class="['status-pill', b.status]">
                                    {{ b.status }}
                                </span>
                            </td>
                            <td>
                                <select class="status-select" :value="b.status" @change="updateStatus(b, $event.target.value)">
                                    <option value="pending">PENDING</option>
                                    <option value="confirmed">CONFIRMED</option>
                                    <option value="completed">COMPLETED</option>
                                    <option value="cancelled">CANCELLED</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script src="https://unpkg.com/vue@3.4.38/dist/vue.global.prod.js"></script>
<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                bookings: [],
                stats: {},
                loading: true,
                activeTab: 'all',
                filters: {
                    search: '',
                    session_type: 'All Specialties',
                }
            }
        },
        mounted() {
            this.fetchBookings();
        },
        methods: {
            fetchBookings() {
                this.loading = true;
                let url = `/api/admin/bookings?status=${this.activeTab}&search=${encodeURIComponent(this.filters.search)}&session_type=${encodeURIComponent(this.filters.session_type)}`;

                fetch(url)
                    .then(res => res.json())
                    .then(resData => {
                        if (resData.status === 'success') {
                            this.bookings = resData.data || [];
                            this.stats = resData.stats || {};
                        }
                        this.loading = false;
                    })
                    .catch(err => {
                        console.error('Error fetching admin bookings:', err);
                        this.loading = false;
                    });
            },

            setTab(status) {
                this.activeTab = status;
                this.fetchBookings();
            },

            getInitials(name) {
                if (!name) return 'BK';
                const parts = name.split(' ');
                if (parts.length >= 2) {
                    return (parts[0][0] + parts[1][0]).toUpperCase();
                }
                return name.substring(0, 2).toUpperCase();
            },

            formatDate(dateStr) {
                if (!dateStr) return '';
                const date = new Date(dateStr);
                return date.toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });
            },

            updateStatus(booking, newStatus) {
                const bookingId = booking._id || booking.id;
                fetch(`/api/admin/bookings/${bookingId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ status: newStatus }),
                })
                .then(res => res.json())
                .then(resData => {
                    if (resData.status === 'success') {
                        this.fetchBookings();
                    } else {
                        alert('Error updating booking status: ' + resData.message);
                    }
                })
                .catch(err => console.error('Error updating status:', err));
            }
        }
    }).mount('#admin-app');
</script>

</body>
</html>
