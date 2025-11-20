@extends('layouts.admin')

@section('title', 'Levels')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Level List</h5>
                <a href="{{ route('master.levels.create') }}" class="btn btn-primary btn-sm">
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
                    <table class="table table-hover table-bordered" id="levelsTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Action</th>
                                <th>Code</th>
                                <th>Level</th>
                                <th>Created at</th>
                                <th>Updated at</th>
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
function deleteLevel(levelId) {
    if (confirm('Are you sure you want to delete this level?')) {
        const form = document.getElementById('deleteForm');
        form.action = `/master/levels/${levelId}`;
        form.submit();
    }
}

// Initialize Yajra DataTable
$(document).ready(function() {
    $('#levelsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("master.levels.data") }}',
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
                width: '15%'
            },
            {
                data: 'code_badge',
                name: 'code',
                width: '15%'
            },
            {
                data: 'level',
                name: 'level',
                width: '30%'
            },
            {
                data: 'created_at_formatted',
                name: 'created_at',
                width: '20%'
            },
            {
                data: 'updated_at_formatted',
                name: 'updated_at',
                width: '15%'
            }
        ],
        order: [[4, 'desc']], // Order by created_at
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>',
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