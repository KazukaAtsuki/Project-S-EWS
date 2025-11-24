<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <div class="rounded-circle bg-label-primary p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                    <span class="fw-bold text-primary" style="font-size: 18px;">EWS</span>
                </div>
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">CEMS Early<br><small style="font-size: 11px;">Warning System</small></span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- MENUS Section -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">MENUS</span>
        </li>

        <!-- Monitoring Report -->
        <li class="menu-item {{ request()->routeIs('monitoring.*') ? 'active' : '' }}">
            <a href="{{ route('monitoring.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Monitoring Report">Monitoring Report</div>
            </a>
        </li>

        <!-- Support -->
        <li class="menu-item {{ request()->routeIs('support.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-headphone"></i>
                <div data-i18n="Support">Support</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('support.tickets') ? 'active' : '' }}">
                    <a href="{{ route('support.tickets') }}" class="menu-link">
                        <div data-i18n="Tickets">Tickets</div>
                    </a>
                </li>
                </li>
            </ul>
        </li>

        <!-- CONFIGURATION Section -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">CONFIGURATION</span>
        </li>

        <!-- Settings -->
        <li class="menu-item {{ request()->routeIs('settings.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-slider"></i>
                <div data-i18n="Settings">Settings</div>
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

        <!-- Accounts -->
<li class="menu-item">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Accounts">Accounts</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item">
            <a href="{{ route('accounts.profile') }}" class="menu-link">
                <div data-i18n="Profile">Profile</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('accounts.security') }}" class="menu-link">
                <div data-i18n="Change Password">Change Password</div>
            </a>
        </li>
    </ul>
</li>

        <!-- MASTER DATA Section -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">MASTER DATA</span>
        </li>

        <!-- Master Data with Submenu -->
        <li class="menu-item {{ request()->routeIs('master.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-data"></i>
                <div data-i18n="Master Data">Master Data</div>
            </a>
            <ul class="menu-sub">
                <!-- Levels -->
                <li class="menu-item {{ request()->routeIs('master.levels') ? 'active' : '' }}">
                    <a href="{{ route('master.levels') }}" class="menu-link">
                        <i class="bx bx-lock me-1"></i>
                        <div data-i18n="Role">Role</div>
                    </a>
                </li>

                <!-- User Management -->
                <li class="menu-item {{ request()->routeIs('master.users') ? 'active' : '' }}">
                    <a href="{{ route('master.users') }}" class="menu-link">
                        <i class="bx bx-user me-1"></i>
                        <div data-i18n="User Management">User Management</div>
                    </a>
                </li>

                <!-- Companies -->
                <li class="menu-item {{ request()->routeIs('master.companies') ? 'active' : '' }}">
                    <a href="{{ route('master.companies') }}" class="menu-link">
                        <i class="bx bx-buildings me-1"></i>
                        <div data-i18n="Companies">Companies</div>
                    </a>
                </li>

                <!-- Stacks -->
                <li class="menu-item {{ request()->routeIs('master.stacks') ? 'active' : '' }}">
                    <a href="{{ route('master.stacks') }}" class="menu-link">
                        <i class="bx bx-coin-stack me-1"></i>
                        <div data-i18n="Stacks">Stacks</div>
                    </a>
                </li>

                <!-- Priorities -->
                <li class="menu-item {{ request()->routeIs('master.priorities') ? 'active' : '' }}">
                    <a href="{{ route('master.priorities') }}" class="menu-link">
                        <i class="bx bx-star me-1"></i>
                        <div data-i18n="Priorities">Priorities</div>
                    </a>
                </li>

                <!-- Categories -->
                <li class="menu-item {{ request()->routeIs('master.categories') ? 'active' : '' }}">
                    <a href="{{ route('master.categories') }}" class="menu-link">
                        <i class="bx bx-category me-1"></i>
                        <div data-i18n="Categories">Categories</div>
                    </a>
                </li>

                <!-- Industry -->
                <li class="menu-item {{ request()->routeIs('master.industry') ? 'active' : '' }}">
                    <a href="{{ route('master.industry') }}" class="menu-link">
                        <i class="bx bx-building me-1"></i>
                        <div data-i18n="Industry">Industry</div>
                    </a>
                </li>

                <!-- Notification Medias -->
                <li class="menu-item {{ request()->routeIs('master.notification-medias') ? 'active' : '' }}">
                    <a href="{{ route('master.notification-medias') }}" class="menu-link">
                        <i class="bx bx-bell me-1"></i>
                        <div data-i18n="Notification Medias">Notification Medias</div>
                    </a>
                </li>

                <!-- Receiver Notification -->
                <li class="menu-item {{ request()->routeIs('master.receiver-notification') ? 'active' : '' }}">
                    <a href="{{ route('master.receiver-notification') }}" class="menu-link">
                        <i class="bx bx-envelope me-1"></i>
                        <div data-i18n="Receiver Notification">Receiver Notification</div>
                    </a>
                </li>

                <!-- Parameter -->
                <li class="menu-item {{ request()->routeIs('master.parameter') ? 'active' : '' }}">
                    <a href="{{ route('master.parameter') }}" class="menu-link">
                        <i class="bx bx-slider-alt me-1"></i>
                        <div data-i18n="Parameter">Parameter</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>