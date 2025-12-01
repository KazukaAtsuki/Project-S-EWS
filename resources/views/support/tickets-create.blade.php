@extends('layouts.admin')

@section('title', 'Create Ticket')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Support</a></li>
        <li class="breadcrumb-item active">Create Ticket</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header">Create New Ticket</h5>
            <div class="card-body">
                <form action="{{ route('support.tickets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Ticket Information -->
                    <h6 class="fw-bold mb-3">Ticket Information</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Issuer</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stack <span class="text-danger">*</span></label>
                            <select class="form-select" name="stack_id" required>
                                <option value="">Select Stack</option>
                                @foreach($stacks as $stack)
                                    <option value="{{ $stack->id }}">{{ $stack->stack_name }} ({{ $stack->companyRelation->name ?? '-' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Priority <span class="text-danger">*</span></label>
                            <select class="form-select" name="priority_id" required>
                                <option value="">Select Priority</option>
                                @foreach($priorities as $priority)
                                    <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Message -->
                    <h6 class="fw-bold mb-3">Message</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Subject <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subject" placeholder="Brief subject of the issue" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Problem Category <span class="text-danger">*</span></label>
                            <select class="form-select" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="description" rows="5" placeholder="Write detailed description here..." required></textarea>
                    </div>

                    <!-- MULTIPLE ATTACHMENTS SECTION -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Attachments</label>
                        <div id="attachment-container">
                            <!-- Input Awal -->
                            <div class="input-group mb-2">
                                <input type="file" class="form-control" name="attachments[]">
                                <button type="button" class="btn btn-outline-danger remove-file" disabled>
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-text">Allowed: jpg, png, pdf, doc. Max: 2MB/file.</div>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="add-file-btn">
                                <i class="bx bx-plus me-1"></i> Add More File
                            </button>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                        <a href="{{ route('support.tickets') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('attachment-container');
        const addBtn = document.getElementById('add-file-btn');

        // Add New File Input
        addBtn.addEventListener('click', function() {
            const div = document.createElement('div');
            div.className = 'input-group mb-2';
            div.innerHTML = `
                <input type="file" class="form-control" name="attachments[]">
                <button type="button" class="btn btn-outline-danger remove-file">
                    <i class="bx bx-trash"></i>
                </button>
            `;
            container.appendChild(div);
        });

        // Remove File Input
        container.addEventListener('click', function(e) {
            if (e.target.closest('.remove-file')) {
                const btn = e.target.closest('.remove-file');
                // Jangan hapus input pertama (biar form tidak kosong total)
                if (container.children.length > 1) {
                    btn.parentElement.remove();
                } else {
                    // Jika cuma satu, reset value-nya saja
                    btn.previousElementSibling.value = '';
                }
            }
        });
    });
</script>
@endpush