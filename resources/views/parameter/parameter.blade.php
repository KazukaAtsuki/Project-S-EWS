@extends('layouts.admin')

@section('title', 'Parameters')

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
        <li class="breadcrumb-item active">Parameters</li>
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
                            <i class="bx bx-tachometer"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">Parameter Configuration</h3>
                            <p class="text-muted mb-0">Set thresholds and measurement units for EWS</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn samu-btn-primary px-4" data-bs-toggle="modal" data-bs-target="#parameterModal" onclick="resetForm()">
                            <i class="bx bx-plus me-2"></i> New Parameter
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
                <!-- Alerts (Biarin sama) -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-4 border-0 shadow-sm" role="alert" style="background-color: #e8fadf; color: #28a745;">
                    <div class="d-flex align-items-center"><i class="bx bx-check-circle fs-4 me-2"></i><strong>Success!</strong>&nbsp; {{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show m-4 border-0 shadow-sm" role="alert" style="background-color: #ffe5e5; color: #ff3e1d;">
                    <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table samu-table table-hover align-middle mb-0" id="parameterTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%">Parameter Name</th>
                                <th width="15%">Unit</th>
                                <!-- PERUBAHAN DI SINI: Header jadi Quality Standard -->
                                <th width="20%">Quality Standard</th>
                                <th width="30%">Description</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit (Isinya sama seperti sebelumnya) -->
<div class="modal fade" id="parameterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold text-primary" id="modalTitle"><i class="bx bx-slider-alt me-2"></i>Create New Parameter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="parameterForm" action="{{ route('master.parameter.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Parameter Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bx bx-tag text-muted"></i></span>
                                <input type="text" class="form-control samu-input border-start-0 ps-0" name="name" id="name" placeholder="e.g. CO (Carbon Monoxide)" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control samu-input" name="unit" id="unit" placeholder="e.g. mg/m3" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <!-- Label diganti jadi Quality Standard Limit -->
                        <label class="form-label fw-semibold text-danger">Quality Standard Limit <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-danger-subtle text-danger border-danger border-end-0"><i class="bx bx-error-circle"></i></span>
                            <input type="number" step="0.01" class="form-control samu-input border-danger border-start-0 ps-0" name="max_threshold" id="max_threshold" placeholder="e.g. 100" required>
                        </div>
                        <div class="form-text text-muted mt-2"><i class="bx bx-info-circle me-1"></i>Jika nilai sensor melebihi angka ini, EWS Alert akan dikirim.</div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea class="form-control samu-input" name="description" id="description" rows="3" placeholder="Optional details..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn samu-btn-primary px-4" id="submitBtn">Save Parameter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Style sama seperti sebelumnya -->
<style>
    :root { --samu-gold: #D4A12A; --samu-blue: #1E6BA8; --samu-cyan: #2EBAC6; --samu-soft-blue: #f0f7ff; --samu-danger: #ff3e1d; }
    .samu-page-header { border-radius: 1.25rem !important; border-left: 5px solid var(--samu-danger); background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%); }
    .samu-icon-header { width: 56px; height: 56px; border-radius: 1rem; background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.75rem; box-shadow: 0 4px 15px rgba(30, 107, 168, 0.2); }
    .samu-btn-primary { background: linear-gradient(135deg, var(--samu-blue) 0%, var(--samu-cyan) 100%); border: none; color: white; font-weight: 600; border-radius: 50px; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(30, 107, 168, 0.2); }
    .samu-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(30, 107, 168, 0.3); color: white; }
    .samu-table thead th { color: #566a7f; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; padding: 1.2rem 1rem; border-bottom: 1px solid #d9dee3; background-color: #fcfdfd; }
    .samu-table tbody td { padding: 1rem 1rem; color: #697a8d; }
    .samu-table tbody tr:hover { background-color: var(--samu-soft-blue); }
    .samu-input { border: 2px solid #e8ecef; border-radius: 0.75rem; padding: 0.65rem 1rem; }
    .samu-input:focus { border-color: var(--samu-cyan); box-shadow: none; }
    .input-group-text { border: 2px solid #e8ecef; border-radius: 0.75rem 0 0 0.75rem; }
    .border-danger { border-color: #ffb2a8 !important; }
    .bg-danger-subtle { background-color: #ffe5e5 !important; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#parameterTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.parameter.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'name', name: 'name', render: function(data) {
                return `<span class="fw-bold text-dark fs-6">${data}</span>`;
            }},
            { data: 'unit', name: 'unit', render: function(data) {
                return `<span class="badge bg-label-secondary">${data}</span>`;
            }},
            // PERUBAHAN DI SINI: Menggunakan kata "Limit"
            { data: 'max_threshold', name: 'max_threshold', render: function(data) {
                // Karena controller sekarang kirim angka murni, kita format disini
                return `<span class="badge bg-label-danger fw-bold border border-danger border-opacity-25 px-3">Limit: ${data}</span>`;
            }},
            { data: 'description', name: 'description', render: function(data) {
                return data ? `<span class="text-muted fst-italic">${data}</span>` : '-';
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' },
        ],
        // ... (sisa script sama)
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            search: "_INPUT_",
            searchPlaceholder: "Search parameters...",
            paginate: { next: '<i class="bx bx-chevron-right"></i>', previous: '<i class="bx bx-chevron-left"></i>' }
        },
        dom: '<"row mx-2 py-3"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mx-2 py-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>'
    });
});

// ... (fungsi resetForm dan editParameter sama) ...
function resetForm() {
    document.getElementById('parameterForm').action = "{{ route('master.parameter.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerHTML = '<i class="bx bx-slider-alt me-2"></i>Create New Parameter';
    document.getElementById('submitBtn').innerText = "Save Parameter";
    document.getElementById('name').value = "";
    document.getElementById('unit').value = "";
    document.getElementById('max_threshold').value = "";
    document.getElementById('description').value = "";
}

function editParameter(id, name, unit, threshold, description) {
    document.getElementById('parameterForm').action = `/master/parameter/${id}`;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('modalTitle').innerHTML = '<i class="bx bx-edit me-2"></i>Edit Parameter';
    document.getElementById('submitBtn').innerText = "Update Parameter";
    document.getElementById('name').value = name;
    document.getElementById('unit').value = unit;
    document.getElementById('max_threshold').value = threshold;
    document.getElementById('description').value = (description === 'null') ? '' : description;
    var modal = new bootstrap.Modal(document.getElementById('parameterModal'));
    modal.show();
}
</script>
@endpush