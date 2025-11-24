@extends('layouts.admin')

@section('title', 'Ticket List')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Support</a></li>
        <li class="breadcrumb-item active">Tickets</li>
    </ol>
</nav>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Support Tickets</h5>
        <a href="{{ route('support.tickets.create') }}" class="btn btn-primary btn-sm">
            <i class="bx bx-plus me-1"></i> Create Ticket
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover table-striped" id="ticketsTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Issuer</th>
                        <th>Stack</th>
                        <th>Priority</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#ticketsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('support.tickets.data') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'issuer', name: 'user.name' },
            { data: 'stack_name', name: 'stack.stack_name' },
            { data: 'priority_badge', name: 'priority.name' },
            { data: 'subject', name: 'subject' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush