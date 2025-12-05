<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - SAMU EWS</title>
    <meta name="description" content="SAMU Early Warning System Platform" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- GLOBAL STYLES (Dark Mode & Mobile Fixes) -->
    <style>
        /* ==================================================================
           GLOBAL DARK MODE VARIABLES & OVERRIDES
           ================================================================== */
        [data-theme="dark"] {
            --bs-body-bg: #0f111a;
            --bs-body-color: #a0a6b1;
            --bs-heading-color: #e4e6eb;
            --samu-card-bg: #1c1f2e;
            --samu-border-color: #2d324a;
            --samu-input-bg: #151824;
        }

        [data-theme="dark"] body {
            background-color: var(--bs-body-bg) !important;
            color: var(--bs-body-color) !important;
        }

        [data-theme="dark"] .card,
        [data-theme="dark"] .layout-menu,
        [data-theme="dark"] .layout-navbar,
        [data-theme="dark"] .footer,
        [data-theme="dark"] .dropdown-menu,
        [data-theme="dark"] .modal-content {
            background-color: var(--samu-card-bg) !important;
            border-color: var(--samu-border-color) !important;
            color: var(--bs-heading-color) !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.4) !important;
        }

        [data-theme="dark"] .text-dark,
        [data-theme="dark"] .fw-bold,
        [data-theme="dark"] h1, [data-theme="dark"] h2, [data-theme="dark"] h3,
        [data-theme="dark"] h4, [data-theme="dark"] h5, [data-theme="dark"] h6,
        [data-theme="dark"] strong, [data-theme="dark"] b {
            color: #e4e6eb !important;
        }

        [data-theme="dark"] .text-muted {
            color: #788393 !important;
        }

        [data-theme="dark"] .bg-white {
            background-color: var(--samu-card-bg) !important;
        }

        [data-theme="dark"] .bg-light,
        [data-theme="dark"] .app-brand {
            background-color: #151824 !important;
        }

        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select,
        [data-theme="dark"] .input-group-text {
            background-color: var(--samu-input-bg) !important;
            border-color: var(--samu-border-color) !important;
            color: #e4e6eb !important;
        }

        [data-theme="dark"] .table {
            color: var(--bs-body-color) !important;
            border-color: var(--samu-border-color) !important;
        }

        [data-theme="dark"] .table thead th {
            background-color: #252a3d !important;
            color: #e4e6eb !important;
            border-bottom-color: var(--samu-border-color) !important;
        }

        [data-theme="dark"] .table-hover tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }

        [data-theme="dark"] .border-bottom,
        [data-theme="dark"] .border-top,
        [data-theme="dark"] .border-end,
        [data-theme="dark"] .border-start,
        [data-theme="dark"] .border,
        [data-theme="dark"] hr {
            border-color: var(--samu-border-color) !important;
        }

        /* ==========================================
           MOBILE RESPONSIVE FIXES (< 768px)
           ========================================== */
        @media (max-width: 767.98px) {
            .samu-navbar { padding: 0.5rem !important; }
            .samu-search-group { width: 100% !important; margin-bottom: 10px; }
            .navbar-nav-right {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 10px;
                width: 100%;
            }
            .navbar-nav.flex-row {
                width: 100%;
                justify-content: flex-end;
                margin-top: -50px;
            }
            .samu-divider, .samu-date-text, .samu-widget-box, .user-name-text {
                display: none !important;
            }
            .samu-page-header .card-body { padding: 1.25rem !important; text-align: center; }
            .samu-page-header .d-flex { flex-direction: column; gap: 15px; }
            .samu-btn-primary, .btn { width: 100%; display: block; margin-bottom: 5px; }

            /* Table Scroll Fix */
            .table-responsive {
                border: 1px solid #eee;
                border-radius: 10px;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .samu-table th, .samu-table td {
                white-space: nowrap;
                font-size: 0.8rem;
                padding: 0.75rem 0.5rem;
            }
            .modal-dialog { margin: 0.5rem; }
        }

        /* Alert Animation */
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .alert { animation: slideDown 0.3s ease-out; }
    </style>

    <!-- Page CSS -->
    @stack('styles')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <!-- Layout page -->
            <div class="layout-page">

                <!-- Navbar -->
                @include('layouts.partials.navbar')

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.partials.footer')

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Global Logic (Dark Mode & DataTables) -->
    <script>
        // --- 1. GLOBAL DARK MODE LOGIC ---
        (function() {
            const savedTheme = localStorage.getItem('samu_theme');
            const body = document.body;
            const themeIcon = document.getElementById('themeIcon');

            // Apply Theme saat loading
            if (savedTheme === 'dark') {
                body.setAttribute('data-theme', 'dark');
                if(themeIcon) themeIcon.classList.replace('bx-moon', 'bx-sun');
            }

            // Fungsi Toggle (Dipanggil dari Navbar)
            window.toggleSamuTheme = function() {
                const currentTheme = body.getAttribute('data-theme');
                const icon = document.getElementById('themeIcon');

                if (currentTheme === 'dark') {
                    body.removeAttribute('data-theme');
                    localStorage.setItem('samu_theme', 'light');
                    if(icon) icon.classList.replace('bx-sun', 'bx-moon');
                } else {
                    body.setAttribute('data-theme', 'dark');
                    localStorage.setItem('samu_theme', 'dark');
                    if(icon) icon.classList.replace('bx-moon', 'bx-sun');
                }
            }
        })();

        // --- 2. GLOBAL DATATABLES CONFIG ---
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                lengthMenu: "_MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_",
                paginate: {
                    first: '<i class="bx bx-chevrons-left"></i>',
                    last: '<i class="bx bx-chevrons-right"></i>',
                    next: '<i class="bx bx-chevron-right"></i>',
                    previous: '<i class="bx bx-chevron-left"></i>'
                }
            },
            pageLength: 10,
            responsive: true,
            scrollX: true, // Wajib untuk mobile responsive
            autoWidth: false,
            dom: '<"row mx-2 py-3"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mx-2 py-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>'
        });

        // --- 3. AUTO DISMISS ALERTS ---
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert:not(.alert-permanent)').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        });
    </script>

    <!-- Page JS -->
    @stack('scripts')
</body>
</html>