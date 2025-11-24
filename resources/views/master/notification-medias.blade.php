@extends('layouts.admin')

@section('title', 'Notification Medias')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Data</li>
        <li class="breadcrumb-item active">Notification Medias</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Notification Media List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#mediaModal" onclick="resetForm()">
                    <i class="bx bx-plus me-1"></i> Create New
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
                    <table class="table table-hover table-striped" id="mediaTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Action</th>
                                <th width="15%">Code</th>
                                <th width="20%">Name</th>
                                <th>Description</th>
                                <th width="15%">Created At</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="mediaForm" action="{{ route('master.notification-medias.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create New Media</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="code" id="code" placeholder="e.g. telegram" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="e.g. Telegram Bot" required>
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
    $('#mediaTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.notification-medias.data') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false },
            { data: 'code', name: 'code' },
            { data: 'name', name: 'name' },
            { data: 'description', name: 'description' },
            { data: 'created_at', name: 'created_at' },
        ]
    });
});

function resetForm() {
    document.getElementById('mediaForm').action = "{{ route('master.notification-medias.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerText = "Create New Media";
    document.getElementById('submitBtn').innerText = "Save";

    document.getElementById('code').value = "";
    document.getElementById('name').value = "";
    document.getElementById('description').value = "";
}

function editMedia(id, code, name, description) {
    document.getElementById('mediaForm').action = `/master/notification-medias/${id}`;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('modalTitle').innerText = "Edit Media";
    document.getElementById('submitBtn').innerText = "Update";

    document.getElementById('code').value = code;
    document.getElementById('name').value = name;
    document.getElementById('description').value = (description === 'null') ? '' : description;

    var modal = new bootstrap.Modal(document.getElementById('mediaModal'));
    modal.show();
}
</script>
@endpush