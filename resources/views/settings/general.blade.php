@extends('layouts.admin')

@section('title', 'General Settings')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">General</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm samu-page-header">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div class="samu-icon-header me-3">
                        <i class="bx bx-cog"></i>
                    </div>
                    <div>
                        <h3 class="mb-1 fw-bold">General Configuration</h3>
                        <p class="text-muted mb-0">Manage application identity and basic information.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-check-circle fs-4 me-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('settings.general.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Left Column: App Info -->
                        <div class="col-md-8">
                            <h5 class="fw-bold text-primary mb-3">Application Info</h5>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Site Title / App Name</label>
                                <input type="text" class="form-control samu-input" name="site_title" value="{{ $general->site_title }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Description</label>
                                <textarea class="form-control samu-input" name="site_description" rows="3">{{ $general->site_description }}</textarea>
                                <div class="form-text">Deskripsi singkat aplikasi yang muncul di meta tag atau footer.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Footer Text</label>
                                <input type="text" class="form-control samu-input" name="footer_text" value="{{ $general->footer_text }}">
                            </div>
                        </div>

                        <!-- Right Column: Contact & Logo -->
                        <div class="col-md-4">
                            <h5 class="fw-bold text-primary mb-3">Contact & Branding</h5>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Contact Email</label>
                                <input type="email" class="form-control samu-input" name="contact_email" value="{{ $general->contact_email }}" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Contact Phone</label>
                                <input type="text" class="form-control samu-input" name="contact_phone" value="{{ $general->contact_phone }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Application Logo</label>
                                <div class="card border-2 border-dashed text-center p-3 mb-2" style="background-color: #f8f9fa;">
                                    @if($general->app_logo)
                                        <img src="{{ asset('storage/' . $general->app_logo) }}" alt="Logo" class="img-fluid mb-2" style="max-height: 80px;">
                                    @else
                                        <div class="text-muted py-3">No Logo Uploaded</div>
                                    @endif
                                </div>
                                <input type="file" class="form-control samu-input" name="app_logo" accept="image/*">
                                <div class="form-text">Format: PNG, JPG. Max: 2MB.</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-end">
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

    .samu-input {
        border: 2px solid #e8ecef;
        border-radius: 0.75rem;
        padding: 0.65rem 1rem;
        transition: all 0.3s ease;
    }

    .samu-input:focus {
        border-color: var(--samu-cyan);
        box-shadow: 0 0 0 0.25rem rgba(46, 186, 198, 0.15);
    }

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

    .border-dashed {
        border-style: dashed !important;
        border-color: #d9dee3 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    // Loading Animation
    document.querySelector('.btn-save').addEventListener('click', function() {
        let btn = this;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Saving...';
        // btn.classList.add('disabled'); // Jangan disable biar form bisa submit
    });
</script>
@endpush