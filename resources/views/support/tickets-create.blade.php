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
                            <!-- Readonly: Diambil dari Auth User -->
                            <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <!-- Readonly: Diambil dari Auth User -->
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

                    <div class="mb-4">
                        <label class="form-label">Attachment</label>
                        <input class="form-control" type="file" name="attachment">
                        <div class="form-text">Allowed files: jpg, png, pdf, doc. Max: 2MB.</div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('support.tickets') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Ticket</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection