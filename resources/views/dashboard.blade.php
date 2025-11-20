@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<!-- Welcome Card -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Welcome back, {{ auth()->user()->name }}! 🎉</h5>
                        <p class="mb-4">
                            You are logged in as <span class="fw-bold">{{ auth()->user()->role }}</span>.
                            Here's an overview of your CEMS Early Warning System.
                        </p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('accounts.profile') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-user me-1"></i> View Profile
                            </a>
                            <a href="{{ route('master.companies') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-building me-1"></i> Manage Companies
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                             height="140"
                             alt="Dashboard Illustration"
                             class="rounded" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <!-- Total Companies -->
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="avatar avatar-xl mx-auto">
                        <div class="avatar-initial rounded" style="width: 60px; height: 60px; background-color: rgba(105, 108, 255, 0.1); display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-building' style="font-size: 32px; color: #696cff;"></i>
                        </div>
                    </div>
                </div>
                <span class="d-block text-muted mb-1">Total Companies</span>
                <h2 class="mb-1 fw-bold">{{ $totalCompanies }}</h2>
                <small class="text-muted">Registered companies</small>
            </div>
        </div>
    </div>

    <!-- Total Users -->
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="avatar avatar-xl mx-auto">
                        <div class="avatar-initial rounded" style="width: 60px; height: 60px; background-color: rgba(40, 167, 69, 0.1); display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-user' style="font-size: 32px; color: #28a745;"></i>
                        </div>
                    </div>
                </div>
                <span class="d-block text-muted mb-1">Total Users</span>
                <h2 class="mb-1 fw-bold">{{ $totalUsers }}</h2>
                <small class="text-success fw-semibold">
                    <i class="bx bx-up-arrow-alt"></i> {{ $activeUsers }} active users
                </small>
            </div>
        </div>
    </div>

    <!-- Total Levels -->
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="avatar avatar-xl mx-auto">
                        <div class="avatar-initial rounded" style="width: 60px; height: 60px; background-color: rgba(23, 162, 184, 0.1); display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-layer' style="font-size: 32px; color: #17a2b8;"></i>
                        </div>
                    </div>
                </div>
                <span class="d-block text-muted mb-1">Total Levels</span>
                <h2 class="mb-1 fw-bold">{{ $totalLevels }}</h2>
                <small class="text-muted">Role levels</small>
            </div>
        </div>
    </div>

    <!-- Your Role -->
    <div class="col-lg-3 col-md-6 col-12 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <div class="avatar avatar-xl mx-auto">
                        <div class="avatar-initial rounded" style="width: 60px; height: 60px; background-color: rgba(255, 193, 7, 0.1); display: flex; align-items: center; justify-content: center;">
                            <i class='bx bx-shield' style="font-size: 32px; color: #ffc107;"></i>
                        </div>
                    </div>
                </div>
                <span class="d-block text-muted mb-1">Your Role</span>
                <div class="mb-1">
                    @if(auth()->user()->role === 'Admin')
                        <span class="badge bg-success px-3 py-2" style="font-size: 0.875rem;">ADMINISTRATOR</span>
                    @elseif(auth()->user()->role === 'NOC')
                        <span class="badge bg-info px-3 py-2" style="font-size: 0.875rem;">NOC</span>
                    @else
                        <span class="badge bg-primary px-3 py-2" style="font-size: 0.875rem;">CEMS OPERATOR</span>
                    @endif
                </div>
                <small class="text-muted">Current access level</small>
            </div>
        </div>
    </div>
</div>

<!-- Companies Dashboard -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">
                    <i class="bx bx-building me-2 text-primary"></i> Companies Dashboard
                </h5>
                <div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="filterBtn">
                        <i class="bx bx-filter me-1"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body p-4">
                @if($companies->isEmpty())
                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="bx bx-info-circle fs-4 me-3"></i>
                        <div>
                            No companies registered yet.
                            <a href="{{ route('master.companies') }}" class="alert-link fw-bold">Add your first company</a>
                        </div>
                    </div>
                @else
                    <div class="row">
                        @foreach($companies as $company)
                        <div class="col-md-6 col-xl-4 mb-4">
                            <div class="card h-100 shadow-sm border-0 hover-lift">
                                <!-- Card Header with Gradient -->
                                <div class="card-header bg-gradient-primary text-white border-0 d-flex justify-content-between align-items-center py-3">
                                    <h6 class="mb-0 text-white fw-semibold text-truncate" style="max-width: 200px;" title="{{ $company->name }}">
                                        {{ $company->name }}
                                    </h6>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Company Info -->
                                    <div class="mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-code-alt text-primary me-2"></i>
                                            <small class="text-muted mb-0">Company Code</small>
                                        </div>
                                        <h6 class="mb-0 fw-bold">{{ $company->company_code }}</h6>
                                    </div>

                                    <div class="mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-category text-info me-2"></i>
                                            <small class="text-muted mb-0">Industry</small>
                                        </div>
                                        <span class="badge bg-label-info">
                                            {{ $company->industryRelation->name ?? 'N/A' }}
                                        </span>
                                    </div>

                                    <div class="mb-3 pb-2 border-bottom">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-user text-success me-2"></i>
                                            <small class="text-muted mb-0">Contact Person</small>
                                        </div>
                                        <p class="mb-0">{{ $company->contact_person ?? '-' }}</p>
                                    </div>

                                    @if($company->contact_phone)
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bx bx-phone text-warning me-2"></i>
                                            <small class="text-muted mb-0">Contact Phone</small>
                                        </div>
                                        <a href="tel:{{ $company->contact_phone }}" class="text-decoration-none">
                                            <i class="bx bx-phone-call me-1"></i>{{ $company->contact_phone }}
                                        </a>
                                    </div>
                                    @endif

                                    <!-- Status Alerts -->
                                    <div class="alert alert-warning border-start border-4 border-warning mb-2 py-2" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-error-circle me-2"></i>
                                            <div>
                                                <strong class="d-block small">Highlight Parameter</strong>
                                                <small class="text-muted">Monitoring active parameters...</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="alert alert-danger border-start border-4 border-danger mb-0 py-2" role="alert">
                                        <div class="d-flex align-items-center">
                                            <i class="bx bx-error me-2"></i>
                                            <div>
                                                <strong class="d-block small">Problem</strong>
                                                <small class="text-muted">No critical issues detected</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="card-footer bg-light border-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bx bx-time me-1"></i>
                                            {{ $company->created_at->diffForHumans() }}
                                        </small>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('master.companies') }}"
                                               class="btn btn-outline-primary"
                                               title="View Details">
                                                <i class="bx bx-show"></i>
                                            </a>
                                            <a href="{{ route('master.companies') }}"
                                               class="btn btn-outline-info"
                                               title="Settings">
                                                <i class="bx bx-cog"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Hover effect for company cards */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15) !important;
}

/* Gradient background for company card headers */
.bg-gradient-primary {
    background: linear-gradient(135deg, #2B6BA6, #3DAFE5) !important;
}

/* Avatar container styling */
.avatar-initial {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
}

/* Ensure consistent card heights */
.h-100 {
    height: 100% !important;
}
</style>
@endpush

@push('scripts')
<script>
// Filter functionality with toast notification
document.getElementById('filterBtn')?.addEventListener('click', function() {
    const toast = document.createElement('div');
    toast.className = 'position-fixed bottom-0 end-0 p-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <div class="toast show align-items-center text-white bg-primary border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bx bx-info-circle me-2"></i>
                    Filter feature coming soon!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.toast').remove()"></button>
            </div>
        </div>
    `;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
});
</script>
@endpush