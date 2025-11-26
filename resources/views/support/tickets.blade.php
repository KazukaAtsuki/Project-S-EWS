@extends('layouts.admin')

@section('title', 'Ticket List')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0);" class="text-muted">Support</a>
        </li>
        <li class="breadcrumb-item active">Tickets</li>
    </ol>
</nav>

<!-- Page Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm samu-page-header">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="samu-icon-header me-3">
                            <i class="bx bx-support"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">Support Tickets</h3>
                            <p class="text-muted mb-0">Manage and track incoming issues from clients</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('support.tickets.create') }}" class="btn samu-btn-primary px-4">
                            <i class="bx bx-plus-circle me-2"></i> Create Ticket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Summary (Updated Dynamic Data) -->
<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-bottom: 4px solid #1E6BA8;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold">Total Tickets</span>
                    <!-- Ganti -- dengan variable -->
                    <h4 class="my-1 fw-bold text-dark">{{ $totalTickets ?? 0 }}</h4> 
                </div>
                <div class="avatar bg-label-primary rounded p-2">
                    <i class="bx bx-copy-alt fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100 rounded-4" style="border-bottom: 4px solid #28a745;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold">Open Status</span>
                    <!-- Ganti -- dengan variable -->
                    <h4 class="my-1 fw-bold text-dark">{{ $openTickets ?? 0 }}</h4>
                </div>
                <div class="avatar bg-label-success rounded p-2">
                    <i class="bx bx-check-circle fs-3"></i>
                </div>
            </div>
        </div>
    </div>
    <!-- Add more stats if needed -->
</div>

<!-- Ticket Table -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                
                <!-- Alerts -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-4 border-0 shadow-sm" role="alert" style="background-color: #e8fadf; color: #28a745;">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-check-circle fs-4 me-2"></i>
                        <strong>Success!</strong>&nbsp; {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table samu-table table-hover align-middle mb-0" id="ticketsTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Subject</th>
                                <th width="15%">Issuer</th>
                                <th width="15%">Stack Location</th>
                                <th width="10%">Priority</th>
                                <th width="10%">Status</th>
                                <th width="15%">Created At</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Loaded via Ajax -->
                        </tbody>
                    </table>
                </div>
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
        border-left: 5px solid var(--samu-blue); /* Blue for Support */
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    }

    .samu-icon-header {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2);
    }

    /* Button */
    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.6rem 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.2);
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(30, 107, 168, 0.3);
        color: white;
    }
    
    .samu-btn-primary:active {
        transform: scale(0.95);
    }

    /* Table Styling */
    .samu-table thead th {
        color: #566a7f;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border-bottom: 1px solid #d9dee3;
        background-color: #fcfdfd;
    }

    .samu-table tbody td {
        padding: 1rem 1rem;
        color: #697a8d;
        font-weight: 500;
    }

    .samu-table tbody tr:hover {
        background-color: var(--samu-soft-blue);
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e8ecef;
        border-radius: 20px;
        padding: 6px 15px;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--samu-cyan);
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(46, 186, 198, 0.15);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--samu-blue) !important;
        border: none !important;
        color: white !important;
        border-radius: 50%;
    }

    /* Avatar Custom */
    .table-avatar {
        width: 32px;
        height: 32px;
        background: var(--samu-cyan);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: bold;
        font-size: 0.8rem;
        margin-right: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#ticketsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('support.tickets.data') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            
            // Subject (Bold & Clickable Look)
            { data: 'subject', name: 'subject', render: function(data) {
                return `<span class="fw-bold text-dark">${data}</span>`;
            }},
            
            // Issuer with Avatar
            { data: 'issuer', name: 'user.name', render: function(data) {
                let initials = data.substring(0, 2).toUpperCase();
                return `
                    <div class="d-flex align-items-center">
                        <div class="table-avatar shadow-sm">${initials}</div>
                        <span class="text-dark">${data}</span>
                    </div>
                `;
            }},
            
            // Stack with Icon
            { data: 'stack_name', name: 'stack.stack_name', render: function(data) {
                return `<span class="text-muted"><i class="bx bx-map me-1"></i>${data}</span>`;
            }},
            
            // Priority Badge (HTML from Controller)
            { data: 'priority_badge', name: 'priority.name' },
            
            // Status Badge (HTML from Controller)
            { data: 'status', name: 'status' },
            
            // Created Date
            { data: 'created_at', name: 'created_at' },
            
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        order: [[6, 'desc']], // Sort by Created At desc
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            search: "_INPUT_",
            searchPlaceholder: "Search tickets...",
            paginate: {
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        dom: '<"row mx-2 py-3"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mx-2 py-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>'
    });
});
</script>
@endpush