@extends('layouts.admin')

@section('title', 'Notification Receivers')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Master Data</li>
        <li class="breadcrumb-item active">Notification Receivers</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Receiver List</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#receiverModal" onclick="resetForm()">
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
                    <table class="table table-hover table-striped" id="receiverTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Code</th>
                                <th>Media</th>
                                <th>Company</th>
                                <th>Contact / ID</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Create/Edit -->
<div class="modal fade" id="receiverModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="receiverForm" action="{{ route('master.receiver-notification.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Create Receiver</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Company <span class="text-danger">*</span></label>
                        <select class="form-select" name="company_id" id="company_id" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notification Media <span class="text-danger">*</span></label>
                        <select class="form-select" name="notification_media_id" id="notification_media_id" required>
                            <option value="">Select Media</option>
                            @foreach($medias as $media)
                                <option value="{{ $media->id }}">{{ $media->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact / ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="contact_value" id="contact_value" placeholder="Email / Chat ID / Phone" required>
                        <div class="form-text">Contoh: admin@email.com atau -100234567 (Telegram ID)</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="is_active" id="is_active">
                            <option value="1">Active</option>
                            <option value="0">Disabled</option>
                        </select>
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
    $('#receiverTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.receiver-notification.data') }}",
        columns: [
            { data: 'action', orderable: false, searchable: false },
            { data: 'code', name: 'code' },
            { data: 'media_name', name: 'media.name' },
            { data: 'company_name', name: 'company.name' },
            { data: 'contact_value', name: 'contact_value' },
            { data: 'status', name: 'is_active' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
        ]
    });
});

function resetForm() {
    document.getElementById('receiverForm').action = "{{ route('master.receiver-notification.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerText = "Create Receiver";
    document.getElementById('submitBtn').innerText = "Save";

    document.getElementById('company_id').value = "";
    document.getElementById('notification_media_id').value = "";
    document.getElementById('contact_value').value = "";
    document.getElementById('is_active').value = "1";
}

function editReceiver(id, compId, mediaId, contact, status) {
    document.getElementById('receiverForm').action = `/master/receiver-notification/${id}`;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('modalTitle').innerText = "Edit Receiver";
    document.getElementById('submitBtn').innerText = "Update";

    document.getElementById('company_id').value = compId;
    document.getElementById('notification_media_id').value = mediaId;
    document.getElementById('contact_value').value = contact;
    document.getElementById('is_active').value = status;

    var modal = new bootstrap.Modal(document.getElementById('receiverModal'));
    modal.show();
}
</script>
@endpush