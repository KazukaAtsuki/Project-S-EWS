@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">User Management</h5>
                <a href="{{ route('master.users.create') }}" class="btn btn-primary btn-sm">
                    <i class="bx bx-plus me-1"></i> Create New
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bx bx-error-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="usersTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Fullname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created at</th>
                                <th>Last updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan diload oleh DataTables -->
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

@push('scripts')
<script>
function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/users/${userId}`;
        form.submit();
    }
}

// Initialize Yajra DataTable
$(document).ready(function() {
    $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("master.users.data") }}',
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '5%'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '12%'
            },
            {
                data: 'name',
                name: 'name',
                width: '15%'
            },
            {
                data: 'email',
                name: 'email',
                width: '15%'
            },
            {
                data: 'phone',
                name: 'phone',
                width: '10%'
            },
            {
                data: 'company',
                name: 'company',
                width: '15%'
            },
            {
                data: 'role_badge',
                name: 'role',
                width: '10%'
            },
            {
                data: 'status_badge',
                name: 'is_active',
                width: '8%'
            },
            {
                data: 'created_at_formatted',
                name: 'created_at',
                width: '10%'
            },
            {
                data: 'updated_at_formatted',
                name: 'updated_at',
                width: '10%'
            }
        ],
        order: [[8, 'desc']], // Order by created_at
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div> Loading...',
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            zeroRecords: "No matching records found",
            emptyTable: "No data available in table",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip',
        responsive: true
    });
});
</script>
@endpush