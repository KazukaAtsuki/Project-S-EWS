@extends('layouts.admin')

@section('title', 'Notification Settings')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Notifications</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm samu-page-header">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="samu-icon-header me-3">
                        <i class="bx bx-bell-ring"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">Notification Preferences</h3>
                        <p class="text-muted mb-0">Manage how and where you receive system alerts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-check-circle fs-4 me-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('settings.notifications.update') }}" method="POST" id="notifForm">
                    @csrf
                    @method('PUT')

                    <div class="table-responsive">
                        <table class="table samu-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4" style="width: 40%;">Event Type</th>
                                    <th class="text-center" style="width: 20%;">
                                        <i class="bx bx-envelope me-1"></i> Email
                                    </th>
                                    <th class="text-center" style="width: 20%;">
                                        <i class="bx bxl-telegram me-1"></i> Telegram
                                    </th>
                                    <th class="text-center" style="width: 20%;">
                                        <i class="bx bxl-whatsapp me-1"></i> WhatsApp
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $setting)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm me-3">
                                                <span class="avatar-initial rounded-circle bg-label-primary">
                                                    <i class="bx bx-bell"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="fw-bold d-block text-dark">
                                                    {{ ucwords(str_replace('_', ' ', $setting->event_name)) }}
                                                </span>
                                                <small class="text-muted">{{ $setting->description }}</small>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Checkbox Email -->
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input samu-switch" type="checkbox"
                                                name="settings[{{ $setting->id }}][email]"
                                                {{ $setting->email_enabled ? 'checked' : '' }}>
                                        </div>
                                    </td>

                                    <!-- Checkbox Telegram -->
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input samu-switch" type="checkbox"
                                                name="settings[{{ $setting->id }}][telegram]"
                                                {{ $setting->telegram_enabled ? 'checked' : '' }}>
                                        </div>
                                    </td>

                                    <!-- Checkbox WhatsApp -->
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input samu-switch" type="checkbox"
                                                name="settings[{{ $setting->id }}][whatsapp]"
                                                {{ $setting->whatsapp_enabled ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer bg-white border-top p-4 text-end rounded-bottom-4">
                        <button type="submit" class="btn samu-btn-primary px-4 btn-save">
                            <i class="bx bx-save me-2"></i> Save Changes
                        </button>
                    </div>
                </form>
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
    }

    /* Page Header */
    .samu-page-header {
        border-radius: 1.25rem !important;
        border-left: 5px solid var(--samu-blue);
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

    /* Table Styling */
    .samu-table thead {
        background-color: #f8f9fa;
    }

    .samu-table thead th {
        color: #566a7f;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
        border-bottom: 1px solid #d9dee3;
    }

    .samu-table tbody tr:hover {
        background-color: rgba(30, 107, 168, 0.02);
    }

    /* Custom Switch */
    .form-check-input.samu-switch {
        width: 3em;
        height: 1.5em;
        cursor: pointer;
    }

    .form-check-input.samu-switch:checked {
        background-color: var(--samu-cyan);
        border-color: var(--samu-cyan);
    }

    .form-check-input.samu-switch:focus {
        border-color: var(--samu-blue);
        box-shadow: 0 0 0 0.25rem rgba(30, 107, 168, 0.25);
    }

    /* Save Button */
    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2);
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 107, 168, 0.3);
    }

    .samu-btn-primary:active {
        transform: scale(0.95);
    }
</style>
@endpush

@push('scripts')
<script>
    // Add loading state to save button
    document.querySelector('.btn-save').addEventListener('click', function() {
        let btn = this;
        let originalContent = btn.innerHTML;

        // Ganti text jadi loading
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving...';
        btn.classList.add('disabled');

        // Submit form (biarkan form submit secara natural)
    });
</script>
@endpush