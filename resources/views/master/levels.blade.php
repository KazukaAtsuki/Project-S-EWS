@extends('layouts.admin')

@section('title', 'Role Levels')

@section('content')

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="javascript:void(0);" class="text-muted">Master Data</a>
        </li>
        <li class="breadcrumb-item active">Role Levels</li>
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
                            <i class="bx bx-shield-quarter"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">Role Management</h3>
                            <p class="text-muted mb-0">Define access levels and permissions</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('master.levels.create') }}" class="btn samu-btn-primary px-4">
                            <i class="bx bx-plus me-2"></i> Create Role
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table Section -->
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

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show m-4 border-0 shadow-sm" role="alert" style="background-color: #ffe5e5; color: #ff3e1d;">
                    <div class="d-flex align-items-center">
                        <i class="bx bx-error-circle fs-4 me-2"></i>
                        <strong>Error!</strong>&nbsp; {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table samu-table table-hover align-middle mb-0" id="levelsTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%">Code</th>
                                <th width="25%">Level Name</th>
                                <th width="20%">Created At</th>
                                <th width="20%">Last Updated</th>
                                <th width="15%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables load here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form (Hidden) -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
        border-left: 5px solid var(--samu-gold);
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

    /* Buttons */
    .samu-btn-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(30, 107, 168, 0.2);
        padding: 0.6rem 1.5rem;
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
    .samu-table thead {
        background: #f8f9fa;
    }

    .samu-table thead th {
        color: #566a7f;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        padding: 1.2rem 1rem;
        border-bottom: 1px solid #d9dee3;
    }

    .samu-table tbody td {
        padding: 1rem 1rem;
        color: #697a8d;
        font-weight: 500;
    }

    .samu-table tbody tr:hover {
        background-color: var(--samu-soft-blue);
    }

    /* Custom Badges for Code */
    .badge.bg-primary {
        background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%) !important;
        box-shadow: 0 2px 4px rgba(30, 107, 168, 0.2);
        border-radius: 6px;
        padding: 6px 10px;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    /* DataTables Customization */
    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e8ecef;
        border-radius: 20px;
        padding: 6px 15px;
        transition: all 0.3s;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: var(--samu-cyan);
        box-shadow: 0 0 0 0.2rem rgba(46, 186, 198, 0.15);
        outline: none;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--samu-blue) !important;
        border: none !important;
        color: white !important;
        border-radius: 50%;
    }
</style>
@endpush

@push('scripts')
<script>
function deleteLevel(levelId) {
    if (confirm('Are you sure you want to delete this role level?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/levels/${levelId}`;
        form.submit();
    }
}

$(document).ready(function() {
    $('#levelsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("master.levels.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'code_badge', name: 'code' },
            { data: 'level', name: 'level', render: function(data) {
                return `<span class="fw-bold text-dark">${data}</span>`;
            }},
            { data: 'created_at_formatted', name: 'created_at' },
            { data: 'updated_at_formatted', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
        ],
        order: [[3, 'desc']],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            search: "_INPUT_",
            searchPlaceholder: "Search roles...",
            paginate: {
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        dom: '<"row mx-2 py-3"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mx-2 py-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>',
        lengthMenu: [10, 25, 50]
    });
});
</script>
@endpush