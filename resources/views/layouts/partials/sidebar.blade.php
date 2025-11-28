<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme shadow-sm" style="border-right: 1px solid rgba(0,0,0,0.03);">

    <!-- BRAND LOGO AREA -->
    <div class="app-brand demo py-3 mb-1" style="height: 90px;">
        <a href="{{ route('dashboard') }}" class="app-brand-link gap-3">
            <!-- Modern Icon -->
            <span class="app-brand-logo demo">
                <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm"
                     style="width: 45px; height: 45px; background: linear-gradient(135deg, #D4A12A 0%, #1E6BA8 100%);">
                    <i class='bx bx-radar fs-2 text-white'></i>
                </div>
            </span>
            <!-- Text Brand -->
            <span class="app-brand-text demo menu-text fw-bold ms-1 lh-1">
                <span class="d-block" style="color: #2b2c40; font-size: 22px; letter-spacing: -0.5px;">SAMU</span>
                <small class="text-muted text-uppercase" style="font-size: 10px; letter-spacing: 1px; font-weight: 600;">EWS Platform</small>
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <!-- Gradient Divider -->
    <div class="mx-3 mb-2" style="height: 2px; background: linear-gradient(90deg, #D4A12A, #1E6BA8, #2EBAC6); opacity: 0.2; border-radius: 10px;"></div>

    <div class="menu-inner-shadow"></div>

    <!-- MENU LIST -->
    <ul class="menu-inner py-2">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active samu-active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-grid-alt"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- SECTION: MONITORING -->
        <li class="menu-header small text-uppercase mt-3">
            <span class="menu-header-text" style="color: #D4A12A; font-weight: 800; letter-spacing: 0.5px;">MONITORING</span>
        </li>

        <li class="menu-item {{ request()->routeIs('monitoring.*') ? 'active samu-active' : '' }}">
            <a href="{{ route('monitoring.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                <div data-i18n="Monitoring Report">Analytics Report</div>
            </a>
        </li>

        <!-- SECTION: SUPPORT -->
        <li class="menu-item {{ request()->routeIs('support.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Support">Help Center</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('support.tickets') ? 'active' : '' }}">
                    <a href="{{ route('support.tickets') }}" class="menu-link">
                        <div data-i18n="Tickets">Support Tickets</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SECTION: CONFIGURATION -->
        <li class="menu-header small text-uppercase mt-3">
            <span class="menu-header-text" style="color: #1E6BA8; font-weight: 800; letter-spacing: 0.5px;">SETTINGS</span>
        </li>

        <li class="menu-item {{ request()->routeIs('settings.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-slider-alt"></i>
                <div data-i18n="System">System Config</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('settings.general') ? 'active' : '' }}">
                    <a href="{{ route('settings.general') }}" class="menu-link">
                        <div data-i18n="General">General</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('settings.notifications') ? 'active' : '' }}">
                    <a href="{{ route('settings.notifications') }}" class="menu-link">
                        <div data-i18n="Notifications">Notifications</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-item {{ request()->routeIs('accounts.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Account">My Account</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('accounts.profile') ? 'active' : '' }}">
                    <a href="{{ route('accounts.profile') }}" class="menu-link">
                        <div data-i18n="Profile">Profile Info</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('accounts.security') ? 'active' : '' }}">
                    <a href="{{ route('accounts.security') }}" class="menu-link">
                        <div data-i18n="Security">Security</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SECTION: MASTER DATA (ADMIN ONLY) -->
        @if(auth()->user()->role === 'Admin')
        <li class="menu-header small text-uppercase mt-3">
            <span class="menu-header-text" style="color: #2EBAC6; font-weight: 800; letter-spacing: 0.5px;">ADMINISTRATION</span>
        </li>

        <li class="menu-item {{ request()->routeIs('master.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Master Data">Master Data</div>
            </a>

            <ul class="menu-sub">
                <!-- Role -->
                <li class="menu-item {{ request()->routeIs('master.levels') ? 'active' : '' }}">
                    <a href="{{ route('master.levels') }}" class="menu-link">
                        <i class="bx bx-shield-quarter me-2 text-warning"></i>
                        <div data-i18n="Role">Role Access</div>
                    </a>
                </li>

                <!-- User -->
                <li class="menu-item {{ request()->routeIs('master.users') ? 'active' : '' }}">
                    <a href="{{ route('master.users') }}" class="menu-link">
                        <i class="bx bx-group me-2 text-primary"></i>
                        <div data-i18n="Users">Users</div>
                    </a>
                </li>

                <!-- Companies -->
                <li class="menu-item {{ request()->routeIs('master.companies') ? 'active' : '' }}">
                    <a href="{{ route('master.companies') }}" class="menu-link">
                        <i class="bx bx-buildings me-2 text-info"></i>
                        <div data-i18n="Companies">Companies</div>
                    </a>
                </li>

                <!-- Stacks -->
                <li class="menu-item {{ request()->routeIs('master.stacks') ? 'active' : '' }}">
                    <a href="{{ route('master.stacks') }}" class="menu-link">
                        <i class="bx bx-server me-2 text-secondary"></i>
                        <div data-i18n="Stacks">Stacks</div>
                    </a>
                </li>

                <!-- Parameter -->
                <li class="menu-item {{ request()->routeIs('master.parameter') ? 'active' : '' }}">
                    <a href="{{ route('master.parameter') }}" class="menu-link">
                        <i class="bx bx-tachometer me-2 text-danger"></i>
                        <div data-i18n="Parameter">Parameter</div>
                    </a>
                </li>

                <!-- Other Masters Group -->
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="bx bx-list-ul me-2"></i>
                        <div data-i18n="Others">Others</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('master.industry') ? 'active' : '' }}">
                            <a href="{{ route('master.industry') }}" class="menu-link">Industry</a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('master.priorities') ? 'active' : '' }}">
                            <a href="{{ route('master.priorities') }}" class="menu-link">Priorities</a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('master.categories') ? 'active' : '' }}">
                            <a href="{{ route('master.categories') }}" class="menu-link">Categories</a>
                        </li>
                    </ul>
                </li>

                <!-- Notification Config -->
                <li class="menu-item">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="bx bx-bell me-2 text-success"></i>
                        <div data-i18n="Notification">Notification</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('master.notification-medias') ? 'active' : '' }}">
                            <a href="{{ route('master.notification-medias') }}" class="menu-link">Media Channels</a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('master.receiver-notification') ? 'active' : '' }}">
                            <a href="{{ route('master.receiver-notification') }}" class="menu-link">Receivers</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        @endif

    </ul>
</aside>

<style>
    /* ========================================
       SAMU SIDEBAR STYLING
       ======================================== */

    /* Active State: Gradient Background + Border Left */
    .menu-item.samu-active > .menu-link {
        background: linear-gradient(90deg, rgba(30, 107, 168, 0.08) 0%, rgba(255, 255, 255, 0) 100%) !important;
        color: #1E6BA8 !important;
        border-left: 4px solid #1E6BA8 !important; /* SAMU Blue */
        font-weight: 600;
    }

    .menu-item.samu-active .menu-icon {
        color: #1E6BA8 !important;
    }

    /* Hover State */
    .menu-item .menu-link:hover {
        background-color: #f8f9fa !important;
        color: #1E6BA8 !important;
    }

    /* Submenu Styling */
    .menu-sub .menu-item.active > .menu-link {
        color: #2b2c40 !important;
        font-weight: 600;
        background-color: transparent !important;
    }

    /* Custom Bullet for Submenu */
    .menu-sub .menu-item.active > .menu-link::before {
        background-color: #D4A12A !important; /* Gold Bullet */
        box-shadow: 0 0 0 2px rgba(212, 161, 42, 0.2);
    }

    /* Header Text Color */
    .menu-header-text {
        font-size: 0.7rem !important;
        opacity: 0.9;
    }

    /* Sidebar Scrollbar */
    .layout-menu::-webkit-scrollbar {
        width: 5px;
    }
    .layout-menu::-webkit-scrollbar-thumb {
        background: #e0e0e0;
        border-radius: 10px;
    }
</style>