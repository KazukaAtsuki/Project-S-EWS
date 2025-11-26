@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')

@php
    $user = auth()->user();
@endphp

@if(!$user)
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger d-flex align-items-center rounded-4 shadow-sm border-0" role="alert">
            <i class="bx bx-error-circle fs-4 me-2"></i>
            <div>
                User session not found. Please <a href="{{ route('login') }}" class="fw-bold text-danger text-decoration-underline">login</a> again.
            </div>
        </div>
    </div>
</div>
@else

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0);" class="text-muted">Account</a>
        </li>
        <li class="breadcrumb-item active">My Profile</li>
    </ol>
</nav>

<div class="row">
    <!-- Left Column: Profile Card -->
    <div class="col-md-12 col-lg-4 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
            <!-- Decorative Header Background -->
            <div class="samu-profile-bg"></div>
            
            <div class="card-body text-center position-relative pt-0">
                <!-- Avatar -->
                <div class="samu-avatar-wrapper mx-auto mb-3">
                    <div class="samu-avatar-inner">
                        <span class="avatar-initial">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                        </span>
                    </div>
                </div>

                <h4 class="fw-bold text-dark mb-1">{{ $user->name ?? 'Unknown' }}</h4>
                <p class="text-muted mb-3">{{ $user->email }}</p>

                <div class="d-flex justify-content-center gap-2 mb-4">
                    <span class="badge rounded-pill bg-label-primary border border-primary border-opacity-10 px-3">
                        <i class="bx bx-crown me-1"></i> {{ $user->role ?? 'N/A' }}
                    </span>
                    <span class="badge rounded-pill bg-label-{{ $user->is_active ? 'success' : 'secondary' }} border border-{{ $user->is_active ? 'success' : 'secondary' }} border-opacity-10 px-3">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="samu-divider mb-4"></div>

                <!-- Short Info -->
                <div class="row text-start px-2">
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="samu-icon-box me-3">
                                <i class="bx bx-buildings text-warning"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Company</small>
                                <span class="fw-semibold text-dark">{{ $user->company ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="d-flex align-items-center">
                            <div class="samu-icon-box me-3">
                                <i class="bx bx-phone text-info"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Phone</small>
                                <span class="fw-semibold text-dark">{{ $user->phone ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex align-items-center">
                            <div class="samu-icon-box me-3">
                                <i class="bx bx-calendar-check text-success"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Joined Date</small>
                                <span class="fw-semibold text-dark">
                                    {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Edit Form -->
    <div class="col-md-12 col-lg-8">
        
        <!-- Alert Messages -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #e8fadf; color: #28a745;">
            <div class="d-flex align-items-center">
                <i class="bx bx-check-circle fs-4 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #ffe5e5; color: #ff3e1d;">
            <div class="d-flex align-items-center">
                <i class="bx bx-error-circle fs-4 me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-primary"><i class="bx bx-edit-alt me-2"></i>Edit Profile Details</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('accounts.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-user"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0 @error('name') is-invalid @enderror"
                                       id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
                            </div>
                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-envelope"></i></span>
                                <input type="email" class="form-control samu-input border-start-0 ps-0 @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
                            </div>
                            @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-phone-call"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0 @error('phone') is-invalid @enderror"
                                       id="phone" name="phone" value="{{ old('phone', $user->phone ?? '') }}" placeholder="628..." required>
                            </div>
                            <small class="text-muted" style="font-size: 0.75rem;">Format: 628xxxxxxxxxx</small>
                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Company -->
                        <div class="col-md-6">
                            <label for="company" class="form-label fw-semibold">Company <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-buildings"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0 @error('company') is-invalid @enderror"
                                       id="company" name="company" value="{{ old('company', $user->company ?? '') }}" required>
                            </div>
                            @error('company') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Role (Readonly) -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">System Role</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bx bx-shield-quarter"></i></span>
                                <input type="text" class="form-control bg-light border-start-0 ps-0 text-muted" value="{{ $user->role ?? 'N/A' }}" disabled readonly>
                            </div>
                            <small class="text-muted fst-italic">Role access cannot be changed manually.</small>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex gap-2 justify-content-end">
                        <button type="reset" class="btn btn-light fw-semibold">
                            <i class="bx bx-refresh me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn samu-btn-primary px-4">
                            <i class="bx bx-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Info Card (Horizontal Stats) -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                            <span class="avatar-initial rounded-circle bg-label-info">
                                <i class="bx bx-id-card fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">User ID</small>
                            <h6 class="mb-0 fw-bold text-dark">#{{ $user->id ?? 'N/A' }}</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body d-flex align-items-center">
                        <div class="avatar avatar-lg me-3">
                            <span class="avatar-initial rounded-circle bg-label-warning">
                                <i class="bx bx-history fs-3"></i>
                            </span>
                        </div>
                        <div>
                            <small class="text-muted d-block mb-1">Last Updated</small>
                            <h6 class="mb-0 fw-bold text-dark">
                                {{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endif

@endsection

@push('styles')
<style>
    :root {
        --samu-gold: #D4A12A;
        --samu-blue: #1E6BA8;
        --samu-cyan: #2EBAC6;
    }

    /* 1. Profile Header Background */
    .samu-profile-bg {
        height: 120px;
        background: linear-gradient(135deg, var(--samu-gold) 0%, var(--samu-blue) 100%);
        width: 100%;
    }

    /* 2. Avatar Styling */
    .samu-avatar-wrapper {
        margin-top: -60px; /* Pull up */
        width: 130px;
        height: 130px;
        padding: 5px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        position: relative;
    }

    .samu-avatar-inner {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        overflow: hidden;
        background: var(--samu-cyan);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-initial {
        font-size: 3rem;
        font-weight: 700;
        color: white;
    }

    /* 3. Inputs */
    .samu-input {
        border: 1px solid #dee2e6;
        padding: 0.6rem 1rem;
    }
    
    .samu-input:focus {
        border-color: var(--samu-blue);
        box-shadow: 0 0 0 0.2rem rgba(30, 107, 168, 0.15);
    }

    .input-group-text {
        border: 1px solid #dee2e6;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: var(--samu-blue);
    }

    /* 4. Buttons */
    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(30, 107, 168, 0.3);
        color: white;
    }

    .samu-btn-primary:active {
        transform: scale(0.95);
    }

    /* 5. Icon Box */
    .samu-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .samu-divider {
        height: 1px;
        background: #f0f0f0;
        margin: 1.5rem 0;
    }
</style>
@endpush

@push('scripts')
<script>
// Auto format phone number
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    e.target.value = value;
});

// Confirm before reset
document.querySelector('button[type="reset"]').addEventListener('click', function(e) {
    if (!confirm('Are you sure you want to reset the form?')) {
        e.preventDefault();
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const phone = document.getElementById('phone').value;

    // Validate phone format (Indonesian number)
    if (!phone.startsWith('62')) {
        e.preventDefault();
        alert('Phone number must start with 62 (e.g., 628123456789)');
        document.getElementById('phone').focus();
        return false;
    }

    if (phone.length < 10 || phone.length > 15) {
        e.preventDefault();
        alert('Phone number must be between 10-15 digits');
        document.getElementById('phone').focus();
        return false;
    }
});
</script>
@endpush