<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services | Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-bg: #0b3954;
            --sidebar-active: #086390;
            --main-bg: #f4f8fa;
            --maroon-btn: #672635;
            --text-dark: #222222;
            --text-muted: #666666;
            --border-color: #e0e6ed;
            --active-badge: #27ae60;
            --draft-badge: #e67e22;
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
            transition: all 0.2s ease;
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
            font-size: 0.9rem;
            margin-top: auto;
        }

        /* Main Content Styling */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .top-bar {
            background: #e4f2f9;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
        }

        .search-box {
            position: relative;
            width: 50%;
        }

        .search-box input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.5rem;
            border: none;
            border-radius: 6px;
            background: #d6eaf5;
            font-size: 0.9rem;
            outline: none;
        }

        .search-box::before {
            content: '🔍';
            position: absolute;
            left: 0.8rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.85rem;
            color: #777;
        }

        .profile-area {
            display: flex;
            align-items: center;
            gap: 1.2rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            background: #0b3954;
            color: #fff;
            padding: 0.4rem 0.9rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Services Workspace */
        .workspace {
            display: flex;
            flex: 1;
            padding: 2rem;
            gap: 2rem;
        }

        .table-area {
            flex: 1;
        }

        .header-action-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .header-action-row h1 {
            font-size: 2.2rem;
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }

        .header-action-row p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        .btn-add-service {
            background-color: var(--maroon-btn);
            color: #fff;
            border: none;
            padding: 0.75rem 1.4rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s ease;
        }

        .btn-add-service:hover {
            background-color: #501d29;
        }

        /* Table Styling */
        .services-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        }

        .services-table th {
            text-align: left;
            padding: 1rem 1.2rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #555;
            background-color: #fafafa;
            border-bottom: 2px solid var(--border-color);
        }

        .services-table td {
            padding: 1.2rem;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .service-title-cell {
            font-weight: 600;
            color: #111;
            width: 20%;
        }

        .service-desc-cell {
            color: #555;
            width: 40%;
            line-height: 1.5;
        }

        .service-img-thumb {
            width: 70px;
            height: 50px;
            border-radius: 4px;
            object-fit: cover;
        }

        .status-badge {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.active {
            background-color: #e8f8f0;
            color: #27ae60;
        }

        .status-badge.draft {
            background-color: #fef5e7;
            color: #e67e22;
        }

        .action-btns {
            display: flex;
            gap: 0.8rem;
            align-items: center;
        }

        .btn-icon {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            color: #666;
            transition: color 0.2s ease;
        }

        .btn-icon:hover {
            color: #000;
        }

        /* Right Drawer Form */
        .drawer-panel {
            width: 380px;
            background: #fff;
            border-radius: 8px;
            padding: 1.8rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            display: flex;
            flex-direction: column;
            gap: 1.4rem;
            height: fit-content;
        }

        .drawer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1rem;
        }

        .drawer-header h3 {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-group label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #444;
            text-transform: uppercase;
        }

        .form-group input[type="text"],
        .form-group textarea {
            padding: 0.7rem 0.9rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-group input[type="text"]:focus,
        .form-group textarea:focus {
            border-color: var(--sidebar-bg);
        }

        .image-preview-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .preview-img {
            width: 90px;
            height: 65px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid #ddd;
        }

        .btn-change-image {
            background: none;
            border: none;
            color: #333;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .visibility-options {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .radio-card {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.8rem;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background: #f9f9f9;
            cursor: pointer;
        }

        .radio-card.selected {
            background: #f0f4f8;
            border-color: var(--sidebar-bg);
        }

        .radio-card input {
            accent-color: var(--maroon-btn);
        }

        .radio-card-text {
            font-size: 0.85rem;
        }

        .radio-card-text strong {
            display: block;
            color: #111;
        }

        .radio-card-text span {
            color: #777;
            font-size: 0.75rem;
        }

        .drawer-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-save {
            flex: 1;
            background-color: var(--maroon-btn);
            color: #fff;
            border: none;
            padding: 0.8rem;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-cancel {
            background-color: #e9ecef;
            color: #333;
            border: none;
            padding: 0.8rem 1.2rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div id="admin-app" class="admin-wrapper">
    <!-- Left Operations Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="sidebar-logo">
                <img src="/images/logo.png" alt="Ashan Rumaiz">
            </div>

            <div class="nav-section-title">Operations</div>

            <ul class="sidebar-menu">
                <li><a href="#">📊 Dashboard</a></li>
                <li><a href="#">📖 Booking</a></li>
                <li><a href="#">🖼️ Portfolio</a></li>
                <li><a href="#">✉️ Inquiries</a></li>
                <li><a href="/admin/services" class="active">⚙️ Services</a></li>
                <li><a href="#">📦 Packages</a></li>
                <li><a href="#">📅 Calendar</a></li>
                <li><a href="#">⚙️ Settings</a></li>
            </ul>
        </div>

        <button class="logout-btn">
            🚪 Log Out
        </button>
    </aside>

    <!-- Main Workspace Area -->
    <main class="main-content">
        <!-- Top Search Header -->
        <header class="top-bar">
            <div class="search-box">
                <input type="text" placeholder="Search clients, shoots, catalog, invoices...">
            </div>

            <div class="profile-area">
                <span style="cursor: pointer;">🔔</span>
                <span style="cursor: pointer;">➕</span>
                <div class="user-profile">
                    👤 Ashan Rumaiz
                </div>
            </div>
        </header>

        <!-- Workspace Content -->
        <div class="workspace">
            <!-- Services Table Column -->
            <div class="table-area">
                <div class="header-action-row">
                    <div>
                        <h1>Manage Services</h1>
                        <p>Configure your studio's offerings services and public visibility.</p>
                    </div>
                    <button class="btn-add-service" @click="startCreate">
                        ➕ Add Service
                    </button>
                </div>

                <table class="services-table">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Description & Scope</th>
                            <th>Images Include</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td colspan="5" style="text-align: center; color: #888;">Loading services...</td>
                        </tr>
                        <tr v-else-if="services.length === 0">
                            <td colspan="5" style="text-align: center; color: #888;">No services found. Click "+ Add Service" to create one.</td>
                        </tr>
                        <tr v-else v-for="service in services" :key="service._id || service.id">
                            <td class="service-title-cell">{{ service.name }}</td>
                            <td class="service-desc-cell">{{ truncateText(service.description, 100) }}</td>
                            <td>
                                <img :src="service.image_url" :alt="service.name" class="service-img-thumb">
                            </td>
                            <td>
                                <span :class="['status-badge', service.status]">
                                    {{ service.status === 'active' ? 'Active' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button class="btn-icon" @click="selectForEdit(service)" title="Edit Service">Edit</button>
                                    <button class="btn-icon" @click="deleteService(service)" title="Delete Service">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Right Drawer Edit/Add Form -->
            <div class="drawer-panel" v-if="editingService">
                <div class="drawer-header">
                    <h3>{{ formMode === 'create' ? 'Add Service' : 'Edit Service' }}</h3>
                    <button class="btn-icon" @click="cancelEdit">🔄</button>
                </div>

                <div class="form-group">
                    <label>Service Name</label>
                    <input type="text" v-model="form.name" placeholder="e.g. Events">
                </div>

                <div class="form-group">
                    <label>Description & Deliverables</label>
                    <textarea v-model="form.description" rows="4" placeholder="Enter full service scope..."></textarea>
                </div>

                <div class="form-group">
                    <label>Image Included</label>
                    <div class="image-preview-wrapper">
                        <img :src="imagePreviewUrl || form.image_url || '/images/hero.jpg'" class="preview-img" alt="Preview">
                        <label class="btn-change-image">
                            Change image
                            <input type="file" @change="onFileSelected" accept="image/*" style="display: none;">
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label>Public Visibility</label>
                    <div class="visibility-options">
                        <label :class="['radio-card', form.status === 'active' ? 'selected' : '']">
                            <input type="radio" v-model="form.status" value="active">
                            <div class="radio-card-text">
                                <strong>Active</strong>
                                <span>Public Pages</span>
                            </div>
                        </label>
                        <label :class="['radio-card', form.status === 'draft' ? 'selected' : '']">
                            <input type="radio" v-model="form.status" value="draft">
                            <div class="radio-card-text">
                                <strong>Draft</strong>
                                <span>Studio private</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="drawer-actions">
                    <button class="btn-save" @click="saveService" :disabled="saving">
                        {{ saving ? 'Saving...' : 'Save Changes' }}
                    </button>
                    <button class="btn-cancel" @click="cancelEdit">Cancel</button>
                </div>
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
                services: [],
                loading: true,
                saving: false,
                editingService: null,
                formMode: 'edit', // 'create' or 'edit'
                form: {
                    id: null,
                    name: '',
                    description: '',
                    image_url: '',
                    status: 'active',
                },
                selectedFile: null,
                imagePreviewUrl: null,
            }
        },
        mounted() {
            this.fetchAdminServices();
        },
        methods: {
            fetchAdminServices() {
                this.loading = true;
                fetch('/api/admin/services')
                    .then(res => res.json())
                    .then(resData => {
                        if (resData.status === 'success' && resData.data) {
                            this.services = resData.data;
                            if (this.services.length > 0 && !this.editingService) {
                                this.selectForEdit(this.services[0]);
                            }
                        }
                        this.loading = false;
                    })
                    .catch(err => {
                        console.error('Failed to fetch admin services:', err);
                        this.loading = false;
                    });
            },

            truncateText(text, length) {
                if (!text) return '';
                return text.length > length ? text.substring(0, length) + '......' : text;
            },

            selectForEdit(service) {
                this.formMode = 'edit';
                this.editingService = service;
                this.form = {
                    id: service._id || service.id,
                    name: service.name,
                    description: service.description,
                    image_url: service.image_url,
                    status: service.status || 'active',
                };
                this.selectedFile = null;
                this.imagePreviewUrl = null;
            },

            startCreate() {
                this.formMode = 'create';
                this.editingService = {};
                this.form = {
                    id: null,
                    name: '',
                    description: '',
                    image_url: '/images/gallery-1.jpg',
                    status: 'active',
                };
                this.selectedFile = null;
                this.imagePreviewUrl = null;
            },

            cancelEdit() {
                if (this.services.length > 0) {
                    this.selectForEdit(this.services[0]);
                } else {
                    this.editingService = null;
                }
            },

            onFileSelected(event) {
                const file = event.target.files[0];
                if (file) {
                    this.selectedFile = file;
                    this.imagePreviewUrl = URL.createObjectURL(file);
                }
            },

            saveService() {
                if (!this.form.name || !this.form.description) {
                    alert('Please enter a service name and description.');
                    return;
                }

                this.saving = true;
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('description', this.form.description);
                formData.append('status', this.form.status);
                formData.append('image_url', this.form.image_url);

                if (this.selectedFile) {
                    formData.append('image', this.selectedFile);
                }

                let url = '/api/admin/services';
                if (this.formMode === 'edit' && this.form.id) {
                    url = `/api/admin/services/${this.form.id}`;
                }

                fetch(url, {
                    method: 'POST',
                    body: formData,
                })
                .then(res => res.json())
                .then(resData => {
                    this.saving = false;
                    if (resData.status === 'success') {
                        alert(resData.message || 'Service saved successfully!');
                        this.fetchAdminServices();
                    } else {
                        alert('Error saving service: ' + (resData.message || 'Unknown error'));
                    }
                })
                .catch(err => {
                    this.saving = false;
                    console.error('Error saving service:', err);
                    alert('Failed to save service.');
                });
            },

            deleteService(service) {
                const serviceId = service._id || service.id;
                if (confirm(`Are you sure you want to delete "${service.name}"?`)) {
                    fetch(`/api/admin/services/${serviceId}`, {
                        method: 'DELETE'
                    })
                    .then(res => res.json())
                    .then(resData => {
                        if (resData.status === 'success') {
                            this.fetchAdminServices();
                        } else {
                            alert('Failed to delete service: ' + resData.message);
                        }
                    })
                    .catch(err => {
                        console.error('Failed to delete service:', err);
                    });
                }
            }
        }
    }).mount('#admin-app');
</script>

</body>
</html>
