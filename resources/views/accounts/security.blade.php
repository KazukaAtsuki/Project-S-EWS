@extends('layouts.admin')

@section('title', 'Security Settings')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0);" class="text-muted">Account</a>
        </li>
        <li class="breadcrumb-item active">Security</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm samu-page-header">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="samu-icon-header me-3">
                        <i class="bx bx-lock-open-alt"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold text-dark">Security Settings</h3>
                        <p class="text-muted mb-0">Update your password and manage account security</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Left Column: Change Password Form -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0 fw-bold text-primary"><i class="bx bx-key me-2"></i>Change Password</h5>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3 border-0 shadow-sm" role="alert" style="background-color: #e8fadf; color: #28a745;">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-check-circle fs-4 me-2"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('accounts.security.update') }}" method="POST" id="formChangePassword">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bx bx-lock-alt text-muted"></i></span>
                            <input type="password" class="form-control samu-input border-start-0 ps-0 @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password" placeholder="Enter your current password" required>
                            <span class="input-group-text bg-white border-start-0 cursor-pointer" onclick="togglePassword('current_password')">
                                <i class="bx bx-hide text-muted"></i>
                            </span>
                        </div>
                        @error('current_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <!-- New Password -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-lock-open text-muted"></i></span>
                                <input type="password" class="form-control samu-input border-start-0 ps-0 @error('new_password') is-invalid @enderror"
                                       id="new_password" name="new_password" placeholder="Enter new password" required>
                                <span class="input-group-text bg-white border-start-0 cursor-pointer" onclick="togglePassword('new_password')">
                                    <i class="bx bx-hide text-muted"></i>
                                </span>
                            </div>
                            <!-- Strength Meter -->
                            <div class="progress mt-2" style="height: 4px;">
                                <div class="progress-bar bg-danger" id="password-strength-bar" role="progressbar" style="width: 0%"></div>
                            </div>
                            <small class="text-muted" id="password-strength-text" style="font-size: 0.75rem;">Strength: None</small>
                            @error('new_password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-4">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-check-shield text-muted"></i></span>
                                <input type="password" class="form-control samu-input border-start-0 ps-0"
                                       id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password" required>
                                <span class="input-group-text bg-white border-start-0 cursor-pointer" onclick="togglePassword('new_password_confirmation')">
                                    <i class="bx bx-hide text-muted"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements Box -->
                    <div class="samu-info-box p-3 rounded-3 mb-4">
                        <h6 class="fw-bold text-dark mb-2 fs-7 text-uppercase"><i class="bx bx-list-check me-1 text-primary"></i> Password Requirements</h6>
                        <ul class="list-unstyled mb-0 small text-muted">
                            <li class="mb-1"><i class="bx bx-radio-circle me-1"></i> Minimum 8 characters long</li>
                            <li class="mb-1"><i class="bx bx-radio-circle me-1"></i> Must contain at least one letter</li>
                            <li class="mb-1"><i class="bx bx-radio-circle me-1"></i> Must contain at least one number</li>
                            <li><i class="bx bx-radio-circle me-1"></i> Different from previous password</li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-light fw-semibold">Cancel</a>
                        <button type="submit" class="btn samu-btn-primary px-4">
                            <i class="bx bx-save me-1"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right Column: Security Info & Tips -->
    <div class="col-lg-4">
        <!-- Account Info -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom p-4">
                <h5 class="mb-0 fw-bold text-dark"><i class="bx bx-shield-quarter me-2 text-warning"></i>Security Status</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Registered Email</small>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-envelope"></i></span>
                        </div>
                        <span class="fw-semibold text-dark">{{ auth()->user()->email }}</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <small class="text-muted d-block mb-1">Last Password Change</small>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-time"></i></span>
                        </div>
                        <span class="fw-semibold text-dark">
                            {{ auth()->user()->updated_at->format('d F Y, H:i') }}
                        </span>
                    </div>
                </div>

                <div>
                    <small class="text-muted d-block mb-1">2FA Status</small>
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-sm me-2">
                            <span class="avatar-initial rounded-circle bg-label-secondary"><i class="bx bx-block"></i></span>
                        </div>
                        <span class="fw-semibold text-muted">Not Enabled</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Security Tips -->
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden position-relative">
            <!-- Decorative Circle -->
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
            
            <div class="card-body p-4 position-relative">
                <h5 class="fw-bold text-white mb-3"><i class="bx bx-bulb me-2"></i>Security Tips</h5>
                <ul class="list-unstyled mb-0 small opacity-75">
                    <li class="mb-2"><i class="bx bx-check me-2"></i> Never share your password with anyone.</li>
                    <li class="mb-2"><i class="bx bx-check me-2"></i> Use a mix of characters, numbers & symbols.</li>
                    <li class="mb-2"><i class="bx bx-check me-2"></i> Update your password regularly (every 3 months).</li>
                    <li><i class="bx bx-check me-2"></i> Don't use the same password across different sites.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --samu-gold: #D4A12A;
        --samu-blue: #1E6BA8;
        --samu-cyan: #2EBAC6;
        --samu-soft-blue: #f0f7ff;
    }

    /* Page Header */
    .samu-page-header {
        border-radius: 1.25rem !important;
        border-left: 5px solid var(--samu-cyan); /* Cyan for Security */
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .samu-icon-header {
        width: 50px;
        height: 50px;
        border-radius: 1rem;
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2);
    }

    /* Input Styling */
    .samu-input {
        border: 1px solid #dee2e6;
        padding: 0.65rem 1rem;
    }
    
    .samu-input:focus {
        border-color: var(--samu-cyan);
        box-shadow: 0 0 0 0.2rem rgba(46, 186, 198, 0.15);
    }

    .input-group-text {
        border: 1px solid #dee2e6;
    }
    
    .input-group:focus-within .input-group-text {
        border-color: var(--samu-cyan);
    }

    /* Info Box */
    .samu-info-box {
        background-color: var(--samu-soft-blue);
        border: 1px solid rgba(30, 107, 168, 0.1);
    }

    /* Button */
    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.2);
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(30, 107, 168, 0.3);
        color: white;
    }

    /* Tips Card */
    .bg-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, #252941 100%) !important;
    }
</style>
@endpush

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.parentElement.querySelector('i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
        icon.classList.add('text-primary'); // Highlight icon
    } else {
        field.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.remove('text-primary');
        icon.classList.add('bx-hide');
    }
}

// Password strength indicator
document.getElementById('new_password')?.addEventListener('input', function(e) {
    const password = e.target.value;
    const bar = document.getElementById('password-strength-bar');
    const text = document.getElementById('password-strength-text');
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;

    // Update UI
    let width = (strength / 5) * 100;
    let color = 'bg-danger';
    let label = 'Weak';

    if (strength >= 3) { color = 'bg-warning'; label = 'Medium'; }
    if (strength >= 5) { color = 'bg-success'; label = 'Strong'; }

    bar.style.width = width + '%';
    bar.className = 'progress-bar transition-all ' + color;
    text.innerText = 'Strength: ' + label;
});
</script>
@endpush