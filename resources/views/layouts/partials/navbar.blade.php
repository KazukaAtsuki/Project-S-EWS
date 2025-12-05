<!-- Navbar Modern SAMU Theme (Dark Mode Ready) -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme w-100 samu-navbar"
     id="layout-navbar">

    <!-- Container Fluid -->
    <div class="container-fluid px-4">

        <!-- Mobile Menu Toggle -->
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm text-primary"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">

            <!-- LEFT SIDE: Search & Widgets -->
            <div class="d-flex align-items-center gap-4 w-100 w-md-auto">

                <!-- 1. Modern Search Bar -->
                <div class="navbar-nav align-items-center w-100 w-md-auto">
                    <div class="nav-item d-flex align-items-center w-100">
                        <div class="input-group samu-search-group w-100">
                            <span class="input-group-text border-0 bg-transparent ps-3">
                                <i class="bx bx-search fs-4 text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-transparent shadow-none"
                                   placeholder="Search..." aria-label="Search...">
                            <span class="input-group-text border-0 bg-transparent pe-3 d-none d-md-flex">
                                <span class="badge samu-badge-shortcut">Ctrl + K</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 2. System Status Widget -->
                <div class="d-none d-xl-flex align-items-center samu-widget-box px-3 py-1 rounded-pill bg-light">
                    <span class="position-relative d-flex h-2 w-2 me-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $sysPulse ?? 'bg-success' }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ $sysPulse ?? 'bg-success' }}"></span>
                    </span>
                    <div class="d-flex flex-column">
                        <small class="text-muted" style="font-size: 0.65rem; line-height: 1;">SYSTEM STATUS</small>
                        <span class="text-{{ $sysColor ?? 'success' }} fw-bold" style="font-size: 0.75rem;">
                            {{ $sysStatus ?? 'OPTIMAL' }}
                        </span>
                    </div>
                </div>

                <!-- 3. Date & Live Clock -->
                <div class="d-none d-md-flex align-items-center">
                    <div class="samu-divider me-3"></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.65rem; font-weight: 700; letter-spacing: 0.5px;">
                            {{ strtoupper(now()->format('l, d M')) }}
                        </small>
                        <span class="samu-date-text" id="liveClock">
                            {{ now()->format('H:i') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Dark Mode, Notification & Profile -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- [NEW] Dark Mode Toggle -->
                <li class="nav-item me-2">
                    <a class="nav-link samu-icon-btn" href="javascript:void(0);" id="themeToggle" title="Switch Theme">
                        <i class="bx bx-moon bx-sm" id="themeIcon"></i>
                    </a>
                </li>

                @auth

                <!-- Greeting Text -->
                <li class="nav-item me-3 d-none d-lg-block">
                    <span class="text-muted" style="font-size: 0.85rem;">Hello, </span>
                    <span class="fw-bold text-dark user-name-text">{{ explode(' ', auth()->user()->name)[0] }}</span>
                </li>

                <!-- [FIXED] Notification Dropdown -->
                <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3">
                    <!-- Tambahkan data-bs-toggle="dropdown" agar bisa diklik -->
                    <a class="nav-link dropdown-toggle hide-arrow samu-icon-btn" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                        <i class="bx bx-bell bx-sm"></i>
                        <!-- Badge Jumlah Notif -->
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge rounded-pill samu-badge-notif position-absolute">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    <!-- Isi Dropdown Notifikasi -->
                    <ul class="dropdown-menu dropdown-menu-end py-0 samu-dropdown-menu shadow-lg">
                        <li class="dropdown-header border-bottom p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold text-dark">Notifications</span>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.readAll') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-xs btn-link text-primary p-0" style="font-size: 0.75rem;">
                                            Mark all as read
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                        <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                            @forelse(auth()->user()->notifications as $notification)
                                <a href="{{ $notification->data['link'] ?? '#' }}" class="list-group-item list-group-item-action dropdown-item {{ $notification->read_at ? '' : 'bg-label-secondary' }}">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="avatar">
                                                <span class="avatar-initial rounded-circle bg-label-{{ $notification->data['color'] ?? 'primary' }}">
                                                    <i class='bx {{ $notification->data['icon'] ?? 'bx-bell' }}'></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 small fw-bold text-dark">{{ $notification->data['title'] ?? 'Notification' }}</h6>
                                            <p class="mb-0 small text-muted">{{ Str::limit($notification->data['message'] ?? '', 50) }}</p>
                                            <small class="text-muted" style="font-size: 0.65rem;">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center p-4">
                                    <i class="bx bx-bell-off fs-1 text-muted mb-2"></i>
                                    <p class="mb-0 small text-muted">No notifications yet.</p>
                                </div>
                            @endforelse
                        </div>
                        <li class="dropdown-menu-footer border-top p-2 text-center">
                            <a href="{{ route('monitoring.index') }}" class="small fw-bold text-primary">
                                View All Alerts
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- User Profile Dropdown -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="samu-avatar-container">
                            <div class="avatar avatar-online">
                                <span class="avatar-initial rounded-circle samu-avatar-initial">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end samu-dropdown-menu shadow-lg">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <span class="avatar-initial rounded-circle samu-avatar-initial">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-bold d-block text-dark dropdown-text-main">{{ auth()->user()->name }}</span>
                                        <small class="text-muted dropdown-text-sub">{{ auth()->user()->role }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><div class="dropdown-divider my-2"></div></li>

                        <li>
                            <a class="dropdown-item" href="{{ route('accounts.profile') }}">
                                <i class="bx bx-user me-2 samu-icon-gold"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('accounts.security') }}">
                                <i class="bx bx-cog me-2 samu-icon-blue"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>

                        <li><div class="dropdown-divider my-2"></div></li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                @csrf
                                <a class="dropdown-item text-danger fw-semibold" href="javascript:void(0);"
                                   onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Log Out</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <!-- Guest State -->
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bx bx-log-in me-1"></i> Login
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- CSS Khusus Navbar & Dark Mode Logic -->
@push('styles')
<style>
    /* --- 1. ROOT VARIABLES (LIGHT) --- */
    :root {
        --samu-gold: #D4A12A;
        --samu-blue: #1E6BA8;
        --samu-cyan: #2EBAC6;
        --samu-bg-glass: rgba(255, 255, 255, 0.95);
        --samu-text-main: #2b2c40;
        --samu-text-muted: #697a8d;
        --samu-bg-body: #f5f5f9;
        --samu-bg-card: #ffffff;
        --samu-border: #d9dee3;
        --samu-input-bg: #f3f4f6;
    }

    /* --- 2. DARK MODE OVERRIDES --- */
    [data-theme="dark"] {
        /* Backgrounds */
        --bs-body-bg: #0f111a;
        --samu-bg-body: #0f111a;
        --samu-bg-card: #1c1f2e;
        --samu-bg-glass: rgba(28, 31, 46, 0.95);

        /* Text */
        --samu-text-main: #e4e6eb;
        --samu-text-muted: #a0a6b1;
        --bs-heading-color: #e4e6eb;
        --bs-body-color: #b0b3b8;

        /* Inputs & Borders */
        --samu-border: #2d324a;
        --samu-input-bg: #151824;
    }

    /* Apply Dark Variables to Elements */
    [data-theme="dark"] body {
        background-color: var(--samu-bg-body) !important;
        color: var(--bs-body-color) !important;
    }

    [data-theme="dark"] .card,
    [data-theme="dark"] .layout-menu,
    [data-theme="dark"] .dropdown-menu {
        background-color: var(--samu-bg-card) !important;
        border-color: var(--samu-border) !important;
        color: var(--samu-text-main) !important;
    }

    [data-theme="dark"] .text-dark,
    [data-theme="dark"] .fw-bold,
    [data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3, [data-theme="dark"] h4, [data-theme="dark"] h5, [data-theme="dark"] h6 {
        color: var(--samu-text-main) !important;
    }

    [data-theme="dark"] .text-muted {
        color: var(--samu-text-muted) !important;
    }

    [data-theme="dark"] .form-control,
    [data-theme="dark"] .form-select,
    [data-theme="dark"] .input-group-text,
    [data-theme="dark"] .samu-search-group {
        background-color: var(--samu-input-bg) !important;
        border-color: var(--samu-border) !important;
        color: var(--samu-text-main) !important;
    }

    [data-theme="dark"] .bg-white {
        background-color: var(--samu-bg-card) !important;
    }

    [data-theme="dark"] .bg-light {
        background-color: #252a3d !important;
    }

    [data-theme="dark"] .samu-widget-box {
        background-color: #252a3d !important;
        border-color: var(--samu-border) !important;
    }

    /* --- NAVBAR STYLES --- */
    .samu-navbar {
        backdrop-filter: blur(12px);
        background-color: var(--samu-bg-glass) !important;
        z-index: 1000;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
        transition: background-color 0.3s ease;
    }

    .samu-search-group {
        background-color: var(--samu-input-bg);
        border-radius: 12px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
        width: 260px;
    }

    .samu-search-group:hover,
    .samu-search-group:focus-within {
        border-color: var(--samu-blue);
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.1);
    }

    .samu-badge-shortcut {
        background-color: var(--samu-bg-card);
        color: var(--samu-text-muted);
        border: 1px solid var(--samu-border);
        border-radius: 6px;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 3px 6px;
    }

    .samu-widget-box {
        border: 1px solid #eee;
        background-color: #fafafa;
    }

    /* Pulsing Dot Animation */
    .h-2 { height: 0.5rem; }
    .w-2 { width: 0.5rem; }
    .rounded-full { border-radius: 9999px; }
    .bg-success { background-color: #10b981; }
    .absolute { position: absolute; }
    .relative { position: relative; }
    .inline-flex { display: inline-flex; }

    @keyframes ping {
        75%, 100% { transform: scale(2); opacity: 0; }
    }
    .animate-ping {
        animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    .samu-divider {
        width: 1px;
        height: 35px;
        background: var(--samu-border);
    }

    .samu-date-text {
        color: var(--samu-text-main);
        font-weight: 800;
        font-size: 1.1rem;
        line-height: 1;
    }

    .samu-icon-btn {
        color: var(--samu-text-muted);
        transition: all 0.3s ease;
    }

    .samu-icon-btn:hover {
        color: var(--samu-blue);
        transform: translateY(-2px);
    }

    .samu-badge-notif {
        background: var(--samu-gold) !important;
        border: 2px solid white;
        top: 5px !important;
        right: 5px !important;
    }

    [data-theme="dark"] .samu-badge-notif {
        border-color: var(--samu-bg-card);
    }

    .samu-avatar-initial {
        background: linear-gradient(135deg, var(--samu-blue), var(--samu-cyan));
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .samu-avatar-container {
        padding: 2px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--samu-gold), var(--samu-cyan));
        transition: transform 0.3s ease;
    }

    .samu-avatar-container:hover {
        transform: scale(1.05);
    }

    .samu-dropdown-menu {
        border: 1px solid var(--samu-border);
        border-radius: 16px;
        padding: 0.75rem;
        margin-top: 15px !important;
    }

    .samu-dropdown-menu .dropdown-item {
        border-radius: 10px;
        padding: 10px 15px;
        font-weight: 500;
        color: var(--samu-text-muted);
        margin-bottom: 2px;
    }

    .samu-dropdown-menu .dropdown-item:hover {
        background-color: var(--samu-blue);
        color: white; /* Hover jadi putih biar kontras */
        transform: translateX(3px);
    }

    /* Fix hover icon color */
    .samu-dropdown-menu .dropdown-item:hover i {
        color: white !important;
    }

    .samu-icon-gold { color: var(--samu-gold); }
    .samu-icon-blue { color: var(--samu-blue); }
    .samu-icon-cyan { color: var(--samu-cyan); }

</style>
@endpush

@push('scripts')
<script>
    // 1. Live Clock
    function updateClock() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        document.getElementById('liveClock').textContent = `${hours}:${minutes}`;
    }
    setInterval(updateClock, 1000);
    updateClock();

    // 2. Dark Mode Logic
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    const body = document.body;

    // Cek LocalStorage saat load
    const savedTheme = localStorage.getItem('samu_theme');
    if (savedTheme === 'dark') {
        body.setAttribute('data-theme', 'dark');
        themeIcon.classList.replace('bx-moon', 'bx-sun'); // Ubah ikon jadi matahari
    }

    // Handle Klik
    themeToggle.addEventListener('click', () => {
        if (body.getAttribute('data-theme') === 'dark') {
            // Switch to Light
            body.removeAttribute('data-theme');
            localStorage.setItem('samu_theme', 'light');
            themeIcon.classList.replace('bx-sun', 'bx-moon');
        } else {
            // Switch to Dark
            body.setAttribute('data-theme', 'dark');
            localStorage.setItem('samu_theme', 'dark');
            themeIcon.classList.replace('bx-moon', 'bx-sun');
        }
    });
</script>
@endpush