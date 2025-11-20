@extends('layouts.admin')

@section('title', 'My Profile')

@section('content')

@php
    $user = auth()->user();
@endphp

@if(!$user)
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger">
            <i class="bx bx-error-circle me-2"></i>
            User session not found. Please <a href="{{ route('login') }}" class="alert-link">login</a> again.
        </div>
    </div>
</div>
@else

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Profile Details</h5>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('accounts.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Avatar Section -->
                        <div class="col-md-3 text-center mb-4">
                            <div class="d-flex align-items-center justify-content-center flex-column">
                                <div class="mb-3">
                                    <div class="avatar avatar-xl">
                                        <span class="avatar-initial rounded-circle bg-label-primary" style="width: 120px; height: 120px; font-size: 48px; display: flex; align-items: center; justify-content: center;">
                                            {{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <h5 class="mb-1">{{ $user->name ?? 'Unknown' }}</h5>
                                    <span class="badge bg-label-{{ $user->is_active ? 'success' : 'secondary' }}">
                                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Section -->
                        <div class="col-md-9">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name ?? '') }}"
                                           placeholder="Enter your full name"
                                           required
                                           autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email ?? '') }}"
                                           placeholder="Enter your email"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $user->phone ?? '') }}"
                                           placeholder="628123456789"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: 628xxxxxxxxxx</small>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text"
                                           class="form-control"
                                           id="role"
                                           value="{{ $user->role ?? 'N/A' }}"
                                           disabled
                                           readonly>
                                    <small class="text-muted">Role cannot be changed</small>
                                </div>

                                <div class="mb-3 col-md-12">
                                    <label for="company" class="form-label">Company <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control @error('company') is-invalid @enderror"
                                           id="company"
                                           name="company"
                                           value="{{ old('company', $user->company ?? '') }}"
                                           placeholder="Enter your company name"
                                           required>
                                    @error('company')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="bx bx-save me-1"></i> Save Changes
                                </button>
                                <button type="reset" class="btn btn-outline-secondary me-2">
                                    <i class="bx bx-reset me-1"></i> Reset
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                    <i class="bx bx-arrow-back me-1"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account Info Card -->
        <div class="card">
            <h5 class="card-header">Account Information</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted mb-1">
                            <i class="bx bx-calendar me-1"></i> Account Created
                        </label>
                        <p class="mb-0 fw-semibold">
                            {{ $user->created_at ? $user->created_at->format('d F Y, H:i') : 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted mb-1">
                            <i class="bx bx-time me-1"></i> Last Updated
                        </label>
                        <p class="mb-0 fw-semibold">
                            {{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted mb-1">
                            <i class="bx bx-id-card me-1"></i> User ID
                        </label>
                        <p class="mb-0 fw-semibold">#{{ $user->id ?? 'N/A' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted mb-1">
                            <i class="bx bx-check-circle me-1"></i> Account Status
                        </label>
                        <p class="mb-0">
                            <span class="badge bg-{{ $user->is_active ? 'success' : 'secondary' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>

                <hr class="my-4">

                <div class="alert alert-info mb-0" role="alert">
                    <h6 class="alert-heading mb-2">
                        <i class="bx bx-info-circle me-1"></i> Important Information
                    </h6>
                    <ul class="mb-0">
                        <li>Your profile information is used across the entire system</li>
                        <li>Make sure your email is valid for important notifications</li>
                        <li>Phone number should be in international format (e.g., 628123456789)</li>
                        <li>Contact administrator to change your role or account status</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@endsection

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