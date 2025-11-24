@extends('layouts.admin')

@section('title', 'Parameters')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Data</li>
        <li class="breadcrumb-item active">Parameters</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Parameter List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#parameterModal" onclick="resetForm()">
                    <i class="bx bx-plus me-1"></i> Add New
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="parameterTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Threshold (Limit)</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="parameterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="parameterForm" action="{{ route('master.parameter.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create New Parameter</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="e.g. CO" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="unit" id="unit" placeholder="e.g. mg/m3" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Max Threshold (Batas Bahaya) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="max_threshold" id="max_threshold" placeholder="e.g. 100" required>
                        <small class="text-muted">Jika nilai sensor melebihi angka ini, alert Telegram akan dikirim.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#parameterTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.parameter.data') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'unit', name: 'unit' },
            { data: 'max_threshold', name: 'max_threshold' },
            { data: 'description', name: 'description' },
        ]
    });
});

function resetForm() {
    document.getElementById('parameterForm').action = "{{ route('master.parameter.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerText = "Create New Parameter";
    document.getElementById('submitBtn').innerText = "Save";

    document.getElementById('name').value = "";
    document.getElementById('unit').value = "";
    document.getElementById('max_threshold').value = "";
    document.getElementById('description').value = "";
}

function editParameter(id, name, unit, threshold, description) {
    document.getElementById('parameterForm').action = `/master/parameter/${id}`;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('modalTitle').innerText = "Edit Parameter";
    document.getElementById('submitBtn').innerText = "Update";

    document.getElementById('name').value = name;
    document.getElementById('unit').value = unit;
    document.getElementById('max_threshold').value = threshold;
    document.getElementById('description').value = (description === 'null') ? '' : description;

    var modal = new bootstrap.Modal(document.getElementById('parameterModal'));
    modal.show();
}
</script>
@endpush