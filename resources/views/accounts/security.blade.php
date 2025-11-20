@extends('layouts.admin')

@section('title', 'Security Settings')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Change Password</h5>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('accounts.security.update') }}" method="POST" id="formChangePassword">
                    @csrf
                    @method('PUT')

                    <div class="alert alert-info mb-4">
                        <h6 class="alert-heading mb-1">Password Requirements:</h6>
                        <ul class="mb-0">
                            <li>Minimum 8 characters</li>
                            <li>Must contain letters and numbers</li>
                            <li>New password must be different from current password</li>
                        </ul>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="current_password" class="form-label">Current Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password"
                                       name="current_password"
                                       placeholder="Enter current password"
                                       required>
                                <span class="input-group-text cursor-pointer" onclick="togglePassword('current_password')">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="new_password" class="form-label">New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       class="form-control @error('new_password') is-invalid @enderror"
                                       id="new_password"
                                       name="new_password"
                                       placeholder="Enter new password"
                                       required>
                                <span class="input-group-text cursor-pointer" onclick="togglePassword('new_password')">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                       class="form-control"
                                       id="new_password_confirmation"
                                       name="new_password_confirmation"
                                       placeholder="Confirm new password"
                                       required>
                                <span class="input-group-text cursor-pointer" onclick="togglePassword('new_password_confirmation')">
                                    <i class="bx bx-hide"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bx bx-lock me-1"></i> Change Password
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Activity Card -->
        <div class="card">
            <h5 class="card-header">Security Information</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted mb-1">Account Email</label>
                        <p class="mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-muted mb-1">Last Password Change</label>
                        <p class="mb-0">{{ auth()->user()->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>

                <div class="alert alert-warning mt-3" role="alert">
                    <h6 class="alert-heading mb-1">Security Tips</h6>
                    <ul class="mb-0">
                        <li>Never share your password with anyone</li>
                        <li>Use a unique password for this account</li>
                        <li>Change your password regularly</li>
                        <li>Enable two-factor authentication if available</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = field.nextElementSibling.querySelector('i');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        field.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
}

// Password strength indicator (optional)
document.getElementById('new_password')?.addEventListener('input', function(e) {
    const password = e.target.value;
    const strength = checkPasswordStrength(password);
    // You can add visual feedback here
});

function checkPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;
    return strength;
}
</script>
@endpush