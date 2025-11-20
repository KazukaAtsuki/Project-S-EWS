@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Data</li>
        <li class="breadcrumb-item active">Categories</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Category List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="resetForm()">
                    <i class="bx bx-plus me-1"></i> Add New
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
                    <table class="table table-hover table-striped" id="categoriesTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Action</th>
                                <th width="25%">Category Name</th>
                                <th>Description</th>
                                <th width="20%">Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="categoryForm" action="{{ route('master.categories.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="e.g. Mechanical" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Description for this category..."></textarea>
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
    $('#categoriesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.categories.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'created_at', name: 'created_at' },
        ]
    });
});

function resetForm() {
    // Reset form untuk Create Mode
    document.getElementById('categoryForm').action = "{{ route('master.categories.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerText = "Create New Category";
    document.getElementById('submitBtn').innerText = "Save";

    document.getElementById('name').value = "";
    document.getElementById('description').value = "";
}

function editCategory(id, name, description) {
    // Set form untuk Edit Mode
    document.getElementById('categoryForm').action = `/master/categories/${id}`;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('modalTitle').innerText = "Edit Category";
    document.getElementById('submitBtn').innerText = "Update";

    document.getElementById('name').value = name;
    // Handle jika description null di database
    document.getElementById('description').value = (description === 'null' || description === null) ? '' : description;

    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}
</script>
@endpush