@extends('layouts.admin')

@section('title', 'Ticket Details #' . $ticket->id)

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Support</a></li>
        <li class="breadcrumb-item"><a href="{{ route('support.tickets') }}">Tickets</a></li>
        <li class="breadcrumb-item active">Ticket #{{ $ticket->id }}</li>
    </ol>
</nav>

<div class="row justify-content-center">
    <div class="col-lg-10 col-12">
        <div class="card mb-4">
            <!-- Header: Subject & Status -->
            <div class="card-header d-flex justify-content-between align-items-center border-bottom">
                <div>
                    <h5 class="mb-1 fw-bold text-primary">
                        <i class="bx bx-message-square-detail me-2"></i>{{ $ticket->subject }}
                    </h5>
                    <small class="text-muted">Ticket ID: #{{ $ticket->id }}</small>
                </div>
                <div>
                    @php
                        $statusColor = match($ticket->status) {
                            'Open' => 'success',
                            'In Progress' => 'warning',
                            'Closed' => 'secondary',
                            default => 'primary'
                        };
                    @endphp
                    <span class="badge bg-{{ $statusColor }} fs-6 px-3 py-2 rounded-pill">
                        {{ $ticket->status }}
                    </span>
                </div>
            </div>

            <div class="card-body pt-4">
                <!-- Section 1: Ticket Meta Data (Grid) -->
                <div class="row mb-4">
                    <!-- Issuer Info -->
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="fw-semibold mb-3"><i class="bx bx-user me-1"></i> Issuer Details</h6>
                            <div class="mb-2">
                                <span class="text-muted small d-block">Name:</span>
                                <span class="fw-bold">{{ $ticket->user->name ?? 'Unknown User' }}</span>
                            </div>
                            <div class="mb-2">
                                <span class="text-muted small d-block">Email:</span>
                                <span>{{ $ticket->user->email ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-muted small d-block">Created At:</span>
                                <span>{{ $ticket->created_at->format('D, d M Y - H:i') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Classification Info -->
                    <div class="col-md-6">
                        <div class="p-3 border rounded bg-light h-100">
                            <h6 class="fw-semibold mb-3"><i class="bx bx-target-lock me-1"></i> Classification</h6>

                            <div class="d-flex justify-content-between mb-2 border-bottom pb-1">
                                <span class="text-muted">Stack / Unit:</span>
                                <span class="fw-bold text-end">
                                    {{ $ticket->stack->stack_name ?? '-' }}
                                    <small class="text-muted d-block fw-normal">({{ $ticket->stack->companyRelation->name ?? '-' }})</small>
                                </span>
                            </div>

                            <div class="d-flex justify-content-between mb-2 border-bottom pb-1">
                                <span class="text-muted">Category:</span>
                                <span>{{ $ticket->category->name ?? '-' }}</span>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">Priority:</span>
                                @php
                                    $prioColor = match($ticket->priority->name) {
                                        'Critical' => 'danger',
                                        'High' => 'warning',
                                        'Medium' => 'primary',
                                        'Low' => 'secondary',
                                        default => 'info'
                                    };
                                @endphp
                                <span class="badge bg-label-{{ $prioColor }}">
                                    {{ $ticket->priority->name ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Description -->
                <div class="mb-4">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">Description</h6>
                    <div class="p-3 rounded" style="background-color: #f8f9fa; min-height: 100px; white-space: pre-line;">
                        {{ $ticket->description }}
                    </div>
                </div>

                <!-- Section 3: Attachment -->
                @if($ticket->attachment)
                <div class="mb-4">
                    <h6 class="fw-bold border-bottom pb-2 mb-3">Attachment</h6>
                    <div class="d-flex align-items-center p-3 border rounded">
                        <i class="bx bx-file fs-1 text-primary me-3"></i>
                        <div>
                            <h6 class="mb-1">Attached File</h6>
                            <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-download me-1"></i> View / Download
                            </a>
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Footer Actions -->
            <div class="card-footer bg-light d-flex justify-content-between align-items-center">
                <a href="{{ route('support.tickets') }}" class="btn btn-secondary">
                    <i class="bx bx-arrow-back me-1"></i> Back to List
                </a>

                <!-- Optional: Delete Button (Only for Admin) -->
                @if(auth()->user()->role === 'Admin')
                <form action="{{ route('support.tickets.destroy', $ticket->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-trash me-1"></i> Delete Ticket
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection