<!-- Navbar Modern SAMU Theme -->
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

            <!-- LEFT SIDE: Search & Date -->
            <div class="d-flex align-items-center gap-4">

                <!-- Modern Search Bar -->
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <div class="input-group samu-search-group">
                            <span class="input-group-text border-0 bg-transparent ps-3">
                                <i class="bx bx-search fs-4 text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-transparent shadow-none"
                                   placeholder="Search data..." aria-label="Search...">
                            <span class="input-group-text border-0 bg-transparent pe-3">
                                <span class="badge samu-badge-shortcut">Ctrl + /</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Date Display with Vertical Divider -->
                <div class="d-none d-md-flex align-items-center">
                    <div class="samu-divider me-3"></div>
                    <div>
                        <small class="text-muted d-block" style="font-size: 0.7rem; font-weight: 600; letter-spacing: 0.5px;">TODAY</small>
                        <span class="samu-date-text">{{ now()->format('D, d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE: Notification & Profile -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                @auth
                <!-- Notification -->
                <li class="nav-item me-3">
                    <a class="nav-link position-relative samu-icon-btn" href="javascript:void(0);">
                        <i class="bx bx-bell bx-sm"></i>
                        <span class="badge rounded-pill samu-badge-notif position-absolute">
                            3
                        </span>
                    </a>
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
                                        <span class="fw-bold d-block text-dark">{{ auth()->user()->name }}</span>
                                        <small class="text-muted">{{ auth()->user()->role }}</small>
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
                        <li>
                            <a class="dropdown-item" href="#">
                                <span class="d-flex align-items-center align-middle">
                                    <i class="bx bx-building me-2 samu-icon-cyan"></i>
                                    <span class="flex-grow-1 align-middle text-truncate" style="max-width: 150px;">
                                        {{ auth()->user()->company }}
                                    </span>
                                </span>
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

<!-- CSS Khusus Navbar SAMU -->
@push('styles')
<style>
    /* Variables sesuai Logo SAMU */
    :root {
        --samu-gold: #D4A12A;
        --samu-blue: #1E6BA8;
        --samu-cyan: #2EBAC6;
        --samu-bg-glass: rgba(255, 255, 255, 0.9);
    }

    /* 1. Navbar Base */
    .samu-navbar {
        backdrop-filter: blur(12px);
        background-color: var(--samu-bg-glass) !important;
        z-index: 1000;
        border-bottom: 3px solid transparent;
        border-image: linear-gradient(to right, var(--samu-gold), var(--samu-blue), var(--samu-cyan));
        border-image-slice: 1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.03) !important;
    }

    /* 2. Search Bar Modern */
    .samu-search-group {
        background-color: #f3f4f6;
        border-radius: 50px;
        border: 1px solid transparent;
        transition: all 0.3s ease;
        width: 280px;
    }

    .samu-search-group:hover,
    .samu-search-group:focus-within {
        background-color: #ffffff;
        border-color: var(--samu-blue);
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.1);
    }

    .samu-badge-shortcut {
        background-color: white;
        color: var(--samu-blue);
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 4px 8px;
    }

    /* 3. Date & Divider */
    .samu-divider {
        width: 1px;
        height: 30px;
        background: linear-gradient(to bottom, transparent, #d1d5db, transparent);
    }

    .samu-date-text {
        color: #2b2c40;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* 4. Icons & Notifications */
    .samu-icon-btn {
        color: #566a7f;
        transition: all 0.3s ease;
    }

    .samu-icon-btn:hover {
        color: var(--samu-blue);
        transform: translateY(-2px);
    }

    .samu-badge-notif {
        background: var(--samu-gold) !important; /* Warna Emas untuk notif */
        border: 2px solid white;
        top: 5px !important;
        right: 5px !important;
    }

    /* 5. Avatar & Profile */
    .samu-avatar-initial {
        background: linear-gradient(135deg, var(--samu-blue), var(--samu-cyan));
        color: white;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .samu-avatar-container {
        padding: 2px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--samu-gold), var(--samu-cyan)); /* Ring Gradient */
        transition: transform 0.3s ease;
    }

    .samu-avatar-container:hover {
        transform: scale(1.05);
    }

    /* 6. Dropdown Menu Rapi */
    .samu-dropdown-menu {
        border: none;
        border-radius: 12px;
        padding: 0.5rem;
        margin-top: 10px !important;
    }

    .samu-dropdown-menu .dropdown-item {
        border-radius: 8px;
        padding: 10px 15px;
        font-weight: 500;
        color: #566a7f;
        transition: all 0.2s ease;
        margin-bottom: 2px;
    }

    /* Efek Hover pada Menu */
    .samu-dropdown-menu .dropdown-item:hover {
        background-color: #f0f7ff; /* Biru sangat muda */
        color: var(--samu-blue);
        padding-left: 20px; /* Efek geser sedikit */
    }

    /* Icon Colors */
    .samu-icon-gold { color: var(--samu-gold); }
    .samu-icon-blue { color: var(--samu-blue); }
    .samu-icon-cyan { color: var(--samu-cyan); }

</style>
@endpush