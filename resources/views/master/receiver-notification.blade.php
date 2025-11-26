@extends('layouts.admin')

@section('title', 'Notification Receivers')

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
        <li class="breadcrumb-item active">Receivers</li>
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
                            <i class="bx bx-envelope"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">Notification Receivers</h3>
                            <p class="text-muted mb-0">Manage contacts who receive alerts (Email/Telegram/WA)</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn samu-btn-primary px-4" data-bs-toggle="modal" data-bs-target="#receiverModal" onclick="resetForm()">
                            <i class="bx bx-plus me-2"></i> Add Receiver
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
                    <table class="table samu-table table-hover align-middle mb-0" id="receiverTable" style="width:100%">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%">Receiver Code</th>
                                <th width="20%">Company</th>
                                <th width="25%">Contact Channel</th> <!-- Gabungan Media + Value -->
                                <th width="10%">Status</th>
                                <th width="15%">Last Updated</th>
                                <th width="10%" class="text-center">Action</th>
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

<!-- Modal Create/Edit -->
<div class="modal fade" id="receiverModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold text-primary" id="modalTitle">
                    <i class="bx bx-user-plus me-2"></i>Create Receiver
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="receiverForm" action="{{ route('master.receiver-notification.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company <span class="text-danger">*</span></label>
                        <select class="form-select samu-select" name="company_id" id="company_id" required>
                            <option value="">Select Company</option>
                            @foreach($companies as $comp)
                                <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Notification Media <span class="text-danger">*</span></label>
                            <select class="form-select samu-select" name="notification_media_id" id="notification_media_id" required>
                                <option value="">Select Media</option>
                                @foreach($medias as $media)
                                    <option value="{{ $media->id }}">{{ $media->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Status</label>
                            <select class="form-select samu-select" name="is_active" id="is_active">
                                <option value="1">Active</option>
                                <option value="0">Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Contact Value / ID <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bx bx-id-card text-muted"></i></span>
                            <input type="text" class="form-control samu-input border-start-0 ps-0" name="contact_value" id="contact_value" placeholder="e.g. admin@email.com or -100234567" required>
                        </div>
                        <div class="form-text text-muted">
                            <i class="bx bx-info-circle me-1"></i> Masukkan Email atau Chat ID Telegram sesuai media yang dipilih.
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn samu-btn-primary px-4" id="submitBtn">Save Receiver</button>
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
        --samu-teal: #20c997;
    }

    /* Page Header */
    .samu-page-header {
        border-radius: 1.25rem !important;
        border-left: 5px solid var(--samu-teal); /* Teal for Receivers */
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

    /* Inputs */
    .samu-input, .samu-select {
        border: 2px solid #e8ecef;
        border-radius: 0.75rem;
        padding: 0.65rem 1rem;
    }

    .samu-input:focus, .samu-select:focus {
        border-color: var(--samu-cyan);
        box-shadow: none;
    }

    .input-group-text {
        border: 2px solid #e8ecef;
        border-radius: 0.75rem 0 0 0.75rem;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--samu-cyan);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#receiverTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master.receiver-notification.data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },

            // Code Badge
            { data: 'code', name: 'code', render: function(data) {
                return `<span class="badge bg-label-secondary border border-secondary border-opacity-10">${data}</span>`;
            }},

            // Company Name
            { data: 'company_name', name: 'company.name', render: function(data) {
                return `<span class="fw-semibold text-dark"><i class="bx bx-building me-1 text-muted"></i>${data}</span>`;
            }},

            // Combined Media & Contact (Lebih Rapi)
            { data: 'media_name', name: 'media.name', render: function(data, type, row) {
                let icon = 'bx-envelope'; // Default Email
                let color = 'text-warning'; // Default

                if(data.toLowerCase().includes('telegram')) { icon = 'bxl-telegram'; color = 'text-info'; }
                else if(data.toLowerCase().includes('whatsapp')) { icon = 'bxl-whatsapp'; color = 'text-success'; }

                return `
                    <div>
                        <span class="d-block fw-bold ${color}"><i class='bx ${icon} me-1'></i>${data}</span>
                        <small class="text-muted">${row.contact_value}</small>
                    </div>
                `;
            }},

            // Status Active/Disabled
            { data: 'status', name: 'is_active' },

            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
            search: "_INPUT_",
            searchPlaceholder: "Search receiver...",
            paginate: {
                next: '<i class="bx bx-chevron-right"></i>',
                previous: '<i class="bx bx-chevron-left"></i>'
            }
        },
        dom: '<"row mx-2 py-3"<"col-md-6"l><"col-md-6 d-flex justify-content-end"f>>t<"row mx-2 py-3"<"col-md-6"i><"col-md-6 d-flex justify-content-end"p>>'
    });
});

function resetForm() {
    document.getElementById('receiverForm').action = "{{ route('master.receiver-notification.store') }}";
    document.getElementById('formMethod').value = "POST";
    document.getElementById('modalTitle').innerHTML = '<i class="bx bx-user-plus me-2"></i>Create Receiver';
    document.getElementById('submitBtn').innerText = "Save Receiver";

    document.getElementById('company_id').value = "";
    document.getElementById('notification_media_id').value = "";
    document.getElementById('contact_value').value = "";
    document.getElementById('is_active').value = "1";
}

function editReceiver(id, compId, mediaId, contact, status) {
    document.getElementById('receiverForm').action = `/master/receiver-notification/${id}`;
    document.getElementById('formMethod').value = "PUT";
    document.getElementById('modalTitle').innerHTML = '<i class="bx bx-edit me-2"></i>Edit Receiver';
    document.getElementById('submitBtn').innerText = "Update Receiver";

    document.getElementById('company_id').value = compId;
    document.getElementById('notification_media_id').value = mediaId;
    document.getElementById('contact_value').value = contact;
    document.getElementById('is_active').value = status;

    var modal = new bootstrap.Modal(document.getElementById('receiverModal'));
    modal.show();
}
</script>
@endpush