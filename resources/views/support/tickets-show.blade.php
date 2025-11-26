@extends('layouts.admin')

@section('title', 'Ticket Details #' . $ticket->id)

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('support.tickets') }}" class="text-muted">Support</a>
        </li>
        <li class="breadcrumb-item active">Ticket #{{ $ticket->id }}</li>
    </ol>
</nav>

<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark mb-1">Ticket Details</h4>
        <p class="text-muted mb-0">View issue details and status updates</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('support.tickets') }}" class="btn btn-light shadow-sm fw-semibold">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
        @if(auth()->user()->role === 'Admin')
        <form action="{{ route('support.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger shadow-sm">
                <i class="bx bx-trash me-1"></i> Delete
            </button>
        </form>
        @endif
    </div>
</div>

<div class="row">
    <!-- LEFT COLUMN: Main Content (Subject, Description, Attachment) -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <!-- Ticket Header -->
            <div class="card-header bg-white border-bottom p-4">
                <div class="d-flex align-items-start gap-3">
                    <div class="samu-icon-header flex-shrink-0">
                        <i class="bx bx-message-square-detail"></i>
                    </div>
                    <div>
                        <span class="badge bg-label-secondary mb-2">#{{ $ticket->id }}</span>
                        <h5 class="mb-1 fw-bold text-dark lh-base">{{ $ticket->subject }}</h5>
                        <small class="text-muted">
                            Created {{ $ticket->created_at->format('d F Y, H:i') }} 
                            ({{ $ticket->created_at->diffForHumans() }})
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <!-- Description Box -->
                <h6 class="fw-bold text-uppercase text-muted small mb-3">Issue Description</h6>
                <div class="samu-description-box">
                    {{ $ticket->description }}
                </div>

                <!-- Attachment Section -->
                @if($ticket->attachment)
                <div class="mt-4">
                    <h6 class="fw-bold text-uppercase text-muted small mb-3">Attachment</h6>
                    <div class="card border border-dashed bg-light rounded-3">
                        <div class="card-body d-flex align-items-center p-3">
                            <div class="avatar avatar-md me-3">
                                <span class="avatar-initial rounded bg-white text-primary shadow-sm">
                                    <i class="bx bx-file fs-4"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0 fw-semibold">Attached Document</h6>
                                <small class="text-muted">Click download to view file</small>
                            </div>
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="btn samu-btn-primary btn-sm px-3">
                                <i class="bx bx-download me-1"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
                @else
                <div class="mt-4 pt-3 border-top">
                    <small class="text-muted fst-italic"><i class="bx bx-info-circle me-1"></i>No files attached to this ticket.</small>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: Sidebar (Meta Data) -->
    <div class="col-lg-4">
        
        <!-- 1. Status Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <h6 class="fw-bold text-uppercase text-muted small mb-3">Current Status</h6>
                
                @php
                    $statusClass = match($ticket->status) {
                        'Open' => 'success', // Green for Open (Active)
                        'In Progress' => 'warning',
                        'Closed' => 'secondary',
                        default => 'primary'
                    };
                    $statusIcon = match($ticket->status) {
                        'Open' => 'bx-radio-circle-marked',
                        'In Progress' => 'bx-loader-circle',
                        'Closed' => 'bx-check-circle',
                        default => 'bx-info-circle'
                    };
                @endphp

                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-{{ $statusClass }}-subtle border border-{{ $statusClass }}-subtle">
                    <div class="d-flex align-items-center">
                        <i class='bx {{ $statusIcon }} fs-4 me-2 text-{{ $statusClass }}'></i>
                        <span class="fw-bold text-{{ $statusClass }}">{{ $ticket->status }}</span>
                    </div>
                    <!-- Placeholder for update status button if needed later -->
                </div>
            </div>
        </div>

        <!-- 2. Ticket Info Card -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h6 class="mb-0 fw-bold"><i class="bx bx-list-ul me-2 text-primary"></i>Ticket Properties</h6>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <!-- Priority -->
                    <li class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <span class="text-muted small">Priority</span>
                        @php
                            $prioColor = match($ticket->priority->name) {
                                'Critical' => 'danger',
                                'High' => 'warning',
                                'Medium' => 'info',
                                'Low' => 'secondary',
                                default => 'primary'
                            };
                        @endphp
                        <span class="badge bg-label-{{ $prioColor }}">{{ $ticket->priority->name }}</span>
                    </li>
                    
                    <!-- Stack -->
                    <li class="list-group-item px-4 py-3">
                        <span class="text-muted small d-block mb-1">Stack Location</span>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-map text-danger me-2"></i>
                            <span class="fw-semibold text-dark">{{ $ticket->stack->stack_name }}</span>
                        </div>
                        <small class="text-muted ms-4">{{ $ticket->stack->companyRelation->name }}</small>
                    </li>

                    <!-- Category -->
                    <li class="list-group-item px-4 py-3">
                        <span class="text-muted small d-block mb-1">Problem Category</span>
                        <div class="d-flex align-items-center">
                            <i class="bx bx-category text-info me-2"></i>
                            <span class="fw-semibold text-dark">{{ $ticket->category->name }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- 3. Issuer Profile -->
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4 text-center">
                <div class="avatar avatar-xl mx-auto mb-3">
                    <span class="avatar-initial rounded-circle bg-label-primary" style="font-size: 1.5rem;">
                        {{ strtoupper(substr($ticket->user->name, 0, 2)) }}
                    </span>
                </div>
                <h6 class="fw-bold mb-1">{{ $ticket->user->name }}</h6>
                <p class="text-muted small mb-3">{{ $ticket->user->email }}</p>
                
                <a href="mailto:{{ $ticket->user->email }}" class="btn btn-outline-primary btn-sm rounded-pill w-100">
                    <i class="bx bx-envelope me-1"></i> Contact Issuer
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
    :root {
        --samu-blue: #1E6BA8;
        --samu-cyan: #2EBAC6;
        --samu-soft-blue: #f0f7ff;
    }

    .samu-icon-header {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.2);
    }

    .samu-description-box {
        background-color: #fcfcfc;
        border: 1px solid #f0f0f0;
        border-radius: 12px;
        padding: 20px;
        color: #4a5568;
        line-height: 1.6;
        font-size: 0.95rem;
        white-space: pre-line; /* Agar enter/paragraf terbaca */
    }

    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.3);
        color: white;
    }

    /* Background Subtles */
    .bg-success-subtle { background-color: #e8fadf !important; border-color: #c9ebbc !important; }
    .text-success { color: #28a745 !important; }
    
    .bg-warning-subtle { background-color: #fff2d6 !important; border-color: #ffe0b5 !important; }
    .text-warning { color: #ffab00 !important; }

    .border-dashed {
        border-style: dashed !important;
    }
</style>
@endpush