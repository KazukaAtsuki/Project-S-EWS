@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- 1. Hero / Welcome Section with SAMU Colors -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-lg overflow-hidden samu-hero-card">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    <div class="col-md-8 text-white">
                        <div class="mb-3">
                            <span class="badge samu-badge-gold fs-6 px-3 py-2 mb-2">
                                <i class="bx bx-shield-alt-2 me-1"></i> SAMU EWS Platform
                            </span>
                        </div>
                        <h2 class="fw-bold text-white mb-3">Welcome back, {{ auth()->user()->name }}! 👋</h2>
                        <p class="mb-4 fs-5" style="color: rgba(255,255,255,0.9);">
                            Sistem EWS (Early Warning System) siap memantau performa perusahaan Anda secara real-time.
                        </p>
                        <div class="mb-3">
                            <span class="text-white-50">Login sebagai:</span>
                            <span class="badge bg-white text-primary fw-bold ms-2 px-3 py-2">
                                <i class="bx bx-user-circle me-1"></i>{{ strtoupper(auth()->user()->role) }}
                            </span>
                        </div>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('master.companies') }}" class="btn btn-light btn-lg samu-btn-white shadow">
                                <i class="bx bx-building me-2"></i> Manage Companies
                            </a>
                            <a href="{{ route('accounts.profile') }}" class="btn btn-outline-light btn-lg samu-btn-outline">
                                <i class="bx bx-user me-2"></i> My Profile
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4 text-center d-none d-md-block">
                        <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                             height="180" class="hero-illustration" alt="Dashboard">
                    </div>
                </div>
            </div>
            <!-- Decorative Wave -->
            <div class="samu-wave"></div>
        </div>
    </div>
</div>

<!-- 2. Statistics Cards with SAMU Theme -->
<div class="row g-4 mb-5">
    <!-- Total Companies -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 samu-stat-card samu-card-gold h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="samu-icon-wrapper samu-icon-gold">
                        <i class="bx bx-building fs-2"></i>
                    </div>
                    <span class="badge samu-badge-gold-soft">Active</span>
                </div>
                <h3 class="mb-1 fw-bold display-6">{{ $totalCompanies }}</h3>
                <p class="text-muted mb-0 fw-semibold">Total Companies</p>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bx bx-trending-up text-success me-1"></i>Registered units
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 samu-stat-card samu-card-blue h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="samu-icon-wrapper samu-icon-blue">
                        <i class="bx bx-group fs-2"></i>
                    </div>
                    <span class="badge samu-badge-blue-soft">{{ $activeUsers }} Active</span>
                </div>
                <h3 class="mb-1 fw-bold display-6">{{ $totalUsers }}</h3>
                <p class="text-muted mb-0 fw-semibold">Total Users</p>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bx bx-user-check text-success me-1"></i>System members
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Levels -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 samu-stat-card samu-card-cyan h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="samu-icon-wrapper samu-icon-cyan">
                        <i class="bx bx-layer fs-2"></i>
                    </div>
                    <span class="badge samu-badge-cyan-soft">Levels</span>
                </div>
                <h3 class="mb-1 fw-bold display-6">{{ $totalLevels }}</h3>
                <p class="text-muted mb-0 fw-semibold">Role Levels</p>
                <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                        <i class="bx bx-shield-quarter text-primary me-1"></i>Access types
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Your Access -->
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 samu-stat-card samu-card-dark h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="samu-icon-wrapper samu-icon-dark">
                        <i class="bx bx-shield-alt-2 fs-2"></i>
                    </div>
                    <span class="badge bg-white text-dark">Granted</span>
                </div>
                <h3 class="mb-1 fw-bold text-white display-6">{{ strtoupper(auth()->user()->role) }}</h3>
                <p class="text-white-50 mb-0 fw-semibold">Your Access Level</p>
                <div class="mt-3 pt-3 border-top border-white border-opacity-25">
                    <small class="text-white-50">
                        <i class="bx bx-check-shield text-white me-1"></i>System authorized
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3. Live Monitoring Section -->
<div class="card border-0 shadow-sm mb-4 samu-section-header">
    <div class="card-body p-4">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center mb-2">
                    <div class="samu-icon-sm samu-icon-gold me-3">
                        <i class="bx bx-radar"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold">Live Monitoring Dashboard</h4>
                        <p class="text-muted mb-0">Real-time status overview of all registered company stacks</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <button type="button" class="btn samu-btn-primary" id="filterBtn">
                    <i class="bx bx-filter-alt me-2"></i> Filter View
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Companies Grid -->
@if($companies->isEmpty())
    <div class="card border-0 shadow-sm text-center p-5 samu-empty-state">
        <div class="card-body">
            <div class="samu-empty-icon mx-auto mb-4">
                <i class='bx bx-data fs-1'></i>
            </div>
            <h3 class="fw-bold mb-3">No Data Available</h3>
            <p class="text-muted mb-4">Belum ada perusahaan yang terdaftar di sistem EWS SAMU.</p>
            <a href="{{ route('master.companies') }}" class="btn samu-btn-primary btn-lg px-5">
                <i class="bx bx-plus-circle me-2"></i> Add New Company
            </a>
        </div>
    </div>
@else
    <div class="row g-4">
        @foreach($companies as $company)
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 samu-company-card h-100">
                <!-- Top Gradient Bar -->
                <div class="samu-card-top-bar"></div>

                <div class="card-body p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="badge samu-badge-primary px-3 py-2">
                            <i class="bx bx-hash me-1"></i>{{ $company->company_code }}
                        </span>
                        <span class="badge bg-light text-muted px-3 py-2">
                            {{ $company->industryRelation->name ?? 'General' }}
                        </span>
                    </div>

                    <!-- Company Name -->
                    <h5 class="fw-bold mb-2 samu-company-title" title="{{ $company->name }}">
                        {{ $company->name }}
                    </h5>

                    <!-- Contact Info -->
                    <div class="d-flex align-items-center text-muted mb-4 flex-wrap" style="font-size: 0.9rem;">
                        <i class="bx bx-user me-1"></i>
                        <span class="me-2">{{ $company->contact_person }}</span>
                        @if($company->contact_phone)
                            <span class="mx-2">•</span>
                            <i class="bx bx-phone me-1"></i>
                            <span>{{ $company->contact_phone }}</span>
                        @endif
                    </div>

                    <!-- Monitoring Status -->
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="samu-status-box samu-box-warning">
                                <div class="d-flex align-items-center mb-2">
                                    <i class='bx bx-radar fs-5 me-2'></i>
                                    <small class="fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Parameter</small>
                                </div>
                                <h6 class="fw-bold mb-1">Monitoring</h6>
                                <small class="text-muted">Active Sensors</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="samu-status-box samu-box-success">
                                <div class="d-flex align-items-center mb-2">
                                    <i class='bx bx-check-circle fs-5 me-2'></i>
                                    <small class="fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">Status</small>
                                </div>
                                <h6 class="fw-bold mb-1">Safe</h6>
                                <small class="text-muted">No Issues</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="card-footer bg-transparent border-top p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
                            <i class='bx bx-time-five me-1'></i> {{ $company->updated_at->diffForHumans() }}
                        </small>
                        <a href="{{ route('master.companies') }}" class="btn btn-sm samu-btn-primary-sm">
                            Details <i class='bx bx-chevron-right ms-1'></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection

@push('styles')
<style>
    /* ========================================
       SAMU COLOR PALETTE
       Gold: #D4A12A / #E5B13A
       Blue Dark: #1E6BA8 / #2874B5
       Blue Cyan: #2EBAC6 / #40C4CF
       ======================================== */

    :root {
        --samu-gold: #D4A12A;
        --samu-gold-light: #E5B13A;
        --samu-gold-soft: #FFF8E7;
        --samu-blue: #1E6BA8;
        --samu-blue-light: #2874B5;
        --samu-blue-soft: #E8F4FF;
        --samu-cyan: #2EBAC6;
        --samu-cyan-light: #40C4CF;
        --samu-cyan-soft: #E6F9FB;
        --samu-dark: #1a1d2e;
        --samu-shadow: rgba(30, 107, 168, 0.15);
    }

    /* ========================================
       HERO SECTION
       ======================================== */
    .samu-hero-card {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border-radius: 1.5rem !important;
        position: relative;
        overflow: hidden;
    }

    .samu-hero-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .samu-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff' fill-opacity='0.1'/%3E%3C/svg%3E") no-repeat;
        background-size: cover;
    }

    .samu-badge-gold {
        background: var(--samu-gold);
        color: white;
        font-weight: 600;
        border-radius: 50px;
    }

    .samu-btn-white {
        background: white;
        color: var(--samu-blue);
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .samu-btn-white:hover {
        background: var(--samu-gold);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212, 161, 42, 0.3);
    }

    .samu-btn-outline {
        border: 2px solid rgba(255,255,255,0.5);
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .samu-btn-outline:hover {
        background: rgba(255,255,255,0.2);
        border-color: white;
        transform: translateY(-2px);
    }

    .hero-illustration {
        filter: drop-shadow(0 15px 35px rgba(0,0,0,0.2));
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    /* ========================================
       STATISTICS CARDS
       ======================================== */
    .samu-stat-card {
        border-radius: 1.25rem !important;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        position: relative;
        overflow: hidden;
    }

    .samu-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(30%, -30%);
    }

    .samu-stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px var(--samu-shadow);
    }

    .samu-card-gold { background: linear-gradient(135deg, #FFF8E7 0%, #FFFBF0 100%); }
    .samu-card-blue { background: linear-gradient(135deg, #E8F4FF 0%, #F0F8FF 100%); }
    .samu-card-cyan { background: linear-gradient(135deg, #E6F9FB 0%, #F0FCFD 100%); }
    .samu-card-dark {
        background: linear-gradient(135deg, var(--samu-dark) 0%, #252941 100%);
        color: white;
    }

    .samu-icon-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .samu-icon-gold { background: linear-gradient(135deg, var(--samu-gold) 0%, var(--samu-gold-light) 100%); color: white; }
    .samu-icon-blue { background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-blue-light) 100%); color: white; }
    .samu-icon-cyan { background: linear-gradient(135deg, var(--samu-cyan) 0%, var(--samu-cyan-light) 100%); color: white; }
    .samu-icon-dark { background: linear-gradient(135deg, #3a3f5c 0%, #4a5073 100%); color: white; }

    .samu-stat-card:hover .samu-icon-wrapper {
        transform: rotate(5deg) scale(1.1);
    }

    .samu-badge-gold-soft { background: var(--samu-gold-soft); color: var(--samu-gold); font-weight: 600; }
    .samu-badge-blue-soft { background: var(--samu-blue-soft); color: var(--samu-blue); font-weight: 600; }
    .samu-badge-cyan-soft { background: var(--samu-cyan-soft); color: var(--samu-cyan); font-weight: 600; }

    /* ========================================
       SECTION HEADER
       ======================================== */
    .samu-section-header {
        border-radius: 1.25rem !important;
        border-left: 5px solid var(--samu-gold);
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }

    .samu-icon-sm {
        width: 48px;
        height: 48px;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.65rem 1.75rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2);
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 107, 168, 0.3);
        background: linear-gradient(135deg, var(--samu-cyan) 0%, var(--samu-blue) 100%);
    }

    /* ========================================
       COMPANY CARDS
       ======================================== */
    .samu-company-card {
        border-radius: 1.25rem !important;
        border: 2px solid #f0f4f8;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    .samu-company-card:hover {
        border-color: var(--samu-cyan);
        box-shadow: 0 12px 40px rgba(46, 186, 198, 0.2);
        transform: translateY(-8px);
    }

    .samu-card-top-bar {
        height: 6px;
        background: linear-gradient(90deg, var(--samu-gold) 0%, var(--samu-blue) 50%, var(--samu-cyan) 100%);
    }

    .samu-company-title {
        color: var(--samu-dark);
        font-size: 1.15rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .samu-badge-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        color: white;
        font-weight: 600;
    }

    .samu-status-box {
        padding: 1rem;
        border-radius: 0.75rem;
        border: 2px solid;
        transition: all 0.3s ease;
    }

    .samu-box-warning {
        background: var(--samu-gold-soft);
        border-color: var(--samu-gold);
        color: var(--samu-gold);
    }

    .samu-box-success {
        background: var(--samu-cyan-soft);
        border-color: var(--samu-cyan);
        color: var(--samu-cyan);
    }

    .samu-status-box:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .samu-btn-primary-sm {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.5rem 1.25rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .samu-btn-primary-sm:hover {
        transform: translateX(3px);
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2);
    }

    /* ========================================
       EMPTY STATE
       ======================================== */
    .samu-empty-state {
        border-radius: 1.5rem !important;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .samu-empty-icon {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--samu-blue-soft) 0%, var(--samu-cyan-soft) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--samu-blue);
    }

    /* ========================================
       RESPONSIVE
       ======================================== */
    @media (max-width: 768px) {
        .samu-hero-card .card-body { padding: 2rem 1.5rem !important; }
        .display-6 { font-size: 1.75rem; }
        .samu-stat-card { margin-bottom: 1rem; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('filterBtn')?.addEventListener('click', function() {
        // Animation on click
        this.classList.add('btn-loading');
        setTimeout(() => {
            this.classList.remove('btn-loading');
            alert('🎨 Fitur filter dengan SAMU theme akan segera hadir!');
        }, 300);
    });

    // Add smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endpush