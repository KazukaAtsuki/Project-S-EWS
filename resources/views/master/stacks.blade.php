@extends('layouts.admin')

@section('title', 'Stacks Management')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Data</li>
        <li class="breadcrumb-item active">Stacks</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Stacks List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#stackModal" onclick="resetForm()">
                    <i class="bx bx-plus me-1"></i> Add New Stack
                </button>
            </div>
            <div class="card-body">
                <!-- Alerts -->
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

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped" id="stacksTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Stack Name</th>
                                <th>Gov Code</th>
                                <th>Company</th>
                                <th>Oxygen Ref</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="stackModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Pakai modal-lg biar lebar -->
        <div class="modal-content">
            <form id="stackForm" action="{{ route('master.stacks.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create New Stack</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Row 1 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stack Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="stack_name" id="stack_name" placeholder="ex: Cerobong Boiler 1" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Government Code</label>
                            <input type="text" class="form-control" name="government_code" id="government_code" placeholder="ex: K-01-A">
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="ex: 106.8456">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="ex: -6.2088">
                        </div>
                    </div>

                    <!-- Row 3 -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company <span class="text-danger">*</span></label>
                            <select class="form-select" name="company_id" id="company_id" required>
                                <option value="">Select Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Oxygen Reference</label>
                            <input type="text" class="form-control" name="oxygen_reference" id="oxygen_reference" placeholder="ex: 7">
                        </div>
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
    $('#stacksTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.stacks.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'stack_name', name: 'stack_name' },
            { data: 'government_code', name: 'government_code' },
            { data: 'company_name', name: 'companyRelation.name' }, // Relasi
            { data: 'oxygen_reference', name: 'oxygen_reference' },
            { data: 'created_at', name: 'created_at' },
        ]
    });
});

function resetForm() {
    document.getElementById('stackForm').action = "{{ route('master.stacks.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerText = "Create New Stack";
    document.getElementById('submitBtn').innerText = "Save";

    // Reset values
    document.getElementById('stack_name').value = "";
    document.getElementById('government_code').value = "";
    document.getElementById('longitude').value = "";
    document.getElementById('latitude').value = "";
    document.getElementById('company_id').value = "";
    document.getElementById('oxygen_reference').value = "";
}

function editStack(id, name, govCode, companyId, long, lat, o2Ref) {
    // Ubah action form ke URL Update
    document.getElementById('stackForm').action = `/master/stacks/${id}`;
    document.getElementById('formMethod').value = "PUT"; // Method spoofing

    document.getElementById('modalTitle').innerText = "Edit Stack";
    document.getElementById('submitBtn').innerText = "Update";

    // Isi form dengan data yang ada
    document.getElementById('stack_name').value = name;
    document.getElementById('government_code').value = (govCode === 'null') ? '' : govCode;
    document.getElementById('company_id').value = companyId;
    document.getElementById('longitude').value = (long === 'null') ? '' : long;
    document.getElementById('latitude').value = (lat === 'null') ? '' : lat;
    document.getElementById('oxygen_reference').value = (o2Ref === 'null') ? '' : o2Ref;

    // Tampilkan Modal
    var modal = new bootstrap.Modal(document.getElementById('stackModal'));
    modal.show();
}
</script>
@endpush