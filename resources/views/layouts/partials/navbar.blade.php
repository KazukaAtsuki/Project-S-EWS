<!-- PERUBAHAN:
     1. Menghapus 'container-xxl' di tag <nav> agar tidak terpusat di tengah.
     2. Menghapus 'navbar-detached' agar navbar tidak melayang (menempel).
     3. Menambahkan 'w-100' agar lebar 100%.
-->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme shadow-sm w-100"
     id="layout-navbar"
     style="backdrop-filter: blur(10px); background-color: rgba(255, 255, 255, 0.85) !important; z-index: 1000;">

    <!-- Container Fluid agar isi navbar menyebar penuh ke kiri (sidebar) dan kanan -->
    <div class="container-fluid px-4">

        <!-- Mobile Menu Toggle -->
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center justify-content-between w-100" id="navbar-collapse">

            <!-- LEFT SIDE: Search & Info -->
            <div class="d-flex align-items-center gap-3">
                <!-- Search Bar -->
                <div class="navbar-nav align-items-center">
                    <div class="nav-item d-flex align-items-center">
                        <div class="input-group input-group-merge rounded-pill" style="background-color: #f5f5f9; border: 1px solid transparent; width: 280px; padding: 2px 5px;">
                            <span class="input-group-text border-0 bg-transparent p-2 ps-3 text-muted">
                                <i class="bx bx-search fs-4"></i>
                            </span>
                            <input type="text" class="form-control border-0 bg-transparent shadow-none" placeholder="Search..." aria-label="Search..." style="font-size: 0.9rem;">
                            <span class="input-group-text border-0 bg-transparent p-2 pe-3">
                                <span class="badge bg-white text-muted border shadow-sm" style="font-size: 0.7rem; border-radius: 6px;">Ctrl + /</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Date/Time Display -->
                <div class="d-none d-md-block ms-2">
                    <small class="text-muted d-block" style="font-size: 0.75rem; line-height: 1;">Today</small>
                    <span class="fw-semibold text-dark" style="font-size: 0.85rem;">{{ now()->format('D, d M Y') }}</span>
                </div>
            </div>

            <!-- RIGHT SIDE (Profil & Notif - Tetap Sama) -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                @auth
                <!-- Notification Badge -->
                <li class="nav-item me-3">
                    <a class="nav-link position-relative" href="javascript:void(0);">
                        <i class="bx bx-bell bx-sm text-body"></i>
                        <span class="badge rounded-pill bg-danger badge-notifications position-absolute top-0 start-100 translate-middle p-1" style="font-size: 0.6rem; border: 2px solid #fff;">
                            3
                        </span>
                    </a>
                </li>

                <!-- User Dropdown -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <span class="avatar-initial rounded-circle bg-label-primary fw-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </span>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ auth()->user()->name }}</span>
                                        <small class="text-muted">{{ auth()->user()->role }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('accounts.profile') }}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('accounts.security') }}">
                                <i class="bx bx-cog me-2"></i>
                                <span class="align-middle">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">
                                <span class="d-flex align-items-center align-middle">
                                    <i class="flex-shrink-0 bx bx-building me-2"></i>
                                    <span class="flex-grow-1 align-middle">{{ Str::limit(auth()->user()->company, 20) }}</span>
                                </span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                @csrf
                                <a class="dropdown-item text-danger" href="javascript:void(0);" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                    <i class="bx bx-power-off me-2"></i>
                                    <span class="align-middle">Log Out</span>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-4">
                        <i class="bx bx-log-in me-1"></i> Login
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>