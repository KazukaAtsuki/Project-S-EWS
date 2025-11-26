@extends('layouts.admin')

@section('title', 'Stacks Management')

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
        <li class="breadcrumb-item active">Stacks</li>
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
                            <i class="bx bx-coin-stack"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">Stacks Management</h3>
                            <p class="text-muted mb-0">Manage emission stacks and monitoring points</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn samu-btn-primary px-4" data-bs-toggle="modal" data-bs-target="#stackModal" onclick="resetForm()">
                            <i class="bx bx-plus me-2"></i> Add Stack
                        </button>
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

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-4 border-0 shadow-sm" role="alert" style="background-color: #ffe5e5; color: #ff3e1d;">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table samu-table table-hover align-middle mb-0" id="stacksTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Stack Name</th>
                                <th width="15%">Gov Code</th>
                                <th width="20%">Company</th>
                                <th width="15%">Oxygen Ref</th>
                                <th width="15%">Created At</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- DataTables will fill this -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="stackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold text-primary" id="modalTitle">
                    <i class="bx bx-layer-plus me-2"></i>Create New Stack
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="stackForm" action="{{ route('master.stacks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body p-4">
                    <div class="row g-3">
                        <!-- Stack Info -->
                        <div class="col-12">
                            <h6 class="fw-bold text-muted mb-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Basic Information</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Stack Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-rename text-muted"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0" name="stack_name" id="stack_name" placeholder="ex: Cerobong Boiler 1" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Government Code</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-barcode text-muted"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0" name="government_code" id="government_code" placeholder="ex: K-01-A">
                            </div>
                        </div>

                        <!-- Company & Oxygen -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-muted mb-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Assignment & Technical</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Company <span class="text-danger">*</span></label>
                            <select class="form-select samu-select" name="company_id" id="company_id" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Oxygen Reference (%)</label>
                            <div class="input-group">
                                <input type="text" class="form-control samu-input border-end-0" name="oxygen_reference" id="oxygen_reference" placeholder="ex: 7">
                                <span class="input-group-text bg-light border-start-0 text-muted">%</span>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold text-muted mb-3 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">Location Coordinates</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Latitude</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-map text-muted"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0" name="latitude" id="latitude" placeholder="ex: -6.2088">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Longitude</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-map-pin text-muted"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0" name="longitude" id="longitude" placeholder="ex: 106.8456">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn samu-btn-primary px-4" id="submitBtn">Save Stack</button>
                </div>
            </form>
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
        border-left: 5px solid var(--samu-blue); /* Blue for Stacks */
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
    }

    .samu-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(30, 107, 168, 0.3);
        color: white;
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
    }

    .samu-table tbody tr:hover {
        background-color: var(--samu-soft-blue);
    }

    /* Input & Select Styling */
    .samu-input, .samu-select, .input-group-text {
        border-color: #e8ecef;
    }

    .samu-input:focus, .samu-select:focus {
        border-color: var(--samu-cyan);
        box-shadow: none;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--samu-cyan);
    }

    /* DataTables Pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: var(--samu-blue) !important;
        border: none !important;
        color: white !important;
        border-radius: 50%;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 2px solid #e8ecef;
        border-radius: 20px;
        padding: 6px 15px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#stacksTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.stacks.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'stack_name', name: 'stack_name', render: function(data) {
                return `<span class="fw-bold text-dark">${data}</span>`;
            }},
            { data: 'government_code', name: 'government_code', render: function(data) {
                return data ? `<span class="badge bg-label-secondary">${data}</span>` : '-';
            }},
            { data: 'company_name', name: 'companyRelation.name', render: function(data) {
                return `<span class="fw-semibold text-primary"><i class="bx bx-building me-1"></i>${data}</span>`;
            }},
            { data: 'oxygen_reference', name: 'oxygen_reference', render: function(data) {
                return data ? `${data}%` : '-';
            }},
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            search: "_INPUT_",
            searchPlaceholder: "Search stacks...",
            paginate: {
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        dom: '<"row mx-2 py-3"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mx-2 py-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>'
    });
});

function resetForm() {
    document.getElementById('stackForm').action = "{{ route('master.stacks.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerHTML = '<i class="bx bx-layer-plus me-2"></i>Create New Stack';
    document.getElementById('submitBtn').innerText = "Save Stack";

    // Reset values
    document.getElementById('stack_name').value = "";
    document.getElementById('government_code').value = "";
    document.getElementById('longitude').value = "";
    document.getElementById('latitude').value = "";
    document.getElementById('company_id').value = "";
    document.getElementById('oxygen_reference').value = "";
}

function editStack(id, name, govCode, companyId, long, lat, o2Ref) {
    document.getElementById('stackForm').action = `/master/stacks/${id}`;
    document.getElementById('formMethod').value = "PUT";

    document.getElementById('modalTitle').innerHTML = '<i class="bx bx-edit me-2"></i>Edit Stack';
    document.getElementById('submitBtn').innerText = "Update Stack";

    document.getElementById('stack_name').value = name;
    document.getElementById('government_code').value = (govCode === 'null') ? '' : govCode;
    document.getElementById('company_id').value = companyId;
    document.getElementById('longitude').value = (long === 'null') ? '' : long;
    document.getElementById('latitude').value = (lat === 'null') ? '' : lat;
    document.getElementById('oxygen_reference').value = (o2Ref === 'null') ? '' : o2Ref;

    var modal = new bootstrap.Modal(document.getElementById('stackModal'));
    modal.show();
}
</script>
@endpush