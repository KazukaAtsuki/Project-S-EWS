@extends('layouts.admin')

@section('title', 'Companies')

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
        <li class="breadcrumb-item active">Companies</li>
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
                            <i class="bx bx-buildings"></i>
                        </div>
                        <div>
                            <h3 class="mb-1 fw-bold text-dark">Company Management</h3>
                            <p class="text-muted mb-0">Manage registered companies and industries</p>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn samu-btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                            <i class="bx bx-plus me-2"></i> Add Company
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">

            <!-- Search & Filter -->
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-muted" style="font-size: 0.9rem; letter-spacing: 0.5px;">DATA LIST</h5>
                <div class="input-group" style="max-width: 250px;">
                    <span class="input-group-text border-0 bg-light ps-3"><i class="bx bx-search text-muted"></i></span>
                    <input type="text" class="form-control border-0 bg-light shadow-none" placeholder="Search companies...">
                </div>
            </div>

            <div class="card-body p-0">
                <!-- Alert Messages -->
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
                    <table class="table samu-table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="15%">Company Code</th>
                                <th width="25%">Name</th>
                                <th width="15%">Industry</th>
                                <th width="20%">Contact Info</th>
                                <th width="15%">Last Updated</th>
                                <th width="10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr>
                                <!-- Code -->
                                <td>
                                    <span class="badge bg-light text-primary fw-bold border border-primary border-opacity-10 px-3 py-2 rounded-pill">
                                        {{ $company->company_code }}
                                    </span>
                                </td>

                                <!-- Name -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-3">
                                            <span class="avatar-initial rounded-circle bg-label-info fw-bold">
                                                {{ strtoupper(substr($company->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        <span class="fw-bold text-dark">{{ $company->name }}</span>
                                    </div>
                                </td>

                                <!-- Industry -->
                                <td>
                                    @if($company->industryRelation)
                                        <span class="badge bg-label-cyan">{{ $company->industryRelation->name }}</span>
                                    @else
                                        <span class="text-muted fst-italic">-</span>
                                    @endif
                                </td>

                                <!-- Contact -->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">{{ $company->contact_person }}</span>
                                        <small class="text-muted">
                                            <i class="bx bx-phone me-1" style="font-size: 0.75rem;"></i>
                                            {{ $company->contact_phone ?? '-' }}
                                        </small>
                                    </div>
                                </td>

                                <!-- Date -->
                                <td>
                                    <span class="text-muted" style="font-size: 0.85rem;">
                                        {{ $company->updated_at->diffForHumans() }}
                                    </span>
                                </td>

                                <!-- Action Buttons (Updated: Side by Side) -->
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Edit Button (Orange/Yellow) -->
                                        <button type="button" class="btn btn-icon btn-sm btn-warning"
                                            onclick="editCompany({{ $company->id }}, '{{ $company->company_code }}', '{{ $company->name }}', {{ $company->industry_id }}, '{{ $company->contact_person }}', '{{ $company->contact_phone }}')"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                            <i class="bx bx-edit text-white"></i>
                                        </button>

                                        <!-- Delete Button (Red) -->
                                        <form action="{{ route('master.companies.destroy', $company->id) }}" method="POST" class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this company?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-sm btn-danger"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                <i class="bx bx-trash text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="mb-3 p-3 bg-light rounded-circle">
                                            <i class='bx bx-search-alt fs-1 text-muted'></i>
                                        </div>
                                        <h5 class="text-muted mb-0">No companies found</h5>
                                        <p class="text-muted small">Try adding a new company to get started.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center p-4 border-top">
                    <small class="text-muted">
                        Showing {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }} entries
                    </small>
                    <div>
                        {{ $companies->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold text-primary">
                    <i class="bx bx-building-house me-2"></i>Add New Company
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('master.companies.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control samu-input" name="company_code" placeholder="e.g. PT-ABC" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control samu-input" name="name" placeholder="e.g. PT Maju Mundur" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Industry <span class="text-danger">*</span></label>
                        <select class="form-select samu-select" name="industry_id" required>
                            <option value="">Select Industry</option>
                            @forelse($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @empty
                                <option value="">No industries available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control samu-input" name="contact_person" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control samu-input" name="contact_phone" placeholder="+62xxx">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn samu-btn-primary px-4">Save Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold text-warning">
                    <i class="bx bx-edit me-2"></i>Edit Company
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCompanyForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control samu-input" name="company_code" id="edit_company_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control samu-input" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Industry <span class="text-danger">*</span></label>
                        <select class="form-select samu-select" name="industry_id" id="edit_industry_id" required>
                            <option value="">Select Industry</option>
                            @forelse($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @empty
                                <option value="">No industries available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Contact Person <span class="text-danger">*</span></label>
                            <input type="text" class="form-control samu-input" name="contact_person" id="edit_contact_person" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" class="form-control samu-input" name="contact_phone" id="edit_contact_phone">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn samu-btn-primary px-4">Update Company</button>
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
        --samu-cyan-light: #e0f7fa;
    }

    /* Page Header */
    .samu-page-header {
        border-radius: 1.25rem !important;
        border-left: 5px solid var(--samu-cyan); /* Cyan for companies */
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

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }

    /* Form Controls */
    .samu-input, .samu-select {
        border: 2px solid #e8ecef;
        border-radius: 0.75rem;
        padding: 0.65rem 1rem;
    }

    .samu-input:focus, .samu-select:focus {
        border-color: var(--samu-cyan);
        box-shadow: 0 0 0 0.2rem rgba(46, 186, 198, 0.15);
    }

    /* Custom Badge for Industry */
    .bg-label-cyan {
        background-color: var(--samu-cyan-light) !important;
        color: var(--samu-cyan) !important;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 6px;
    }
</style>
@endpush

@push('scripts')
<script>
    // Enable Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    function editCompany(id, code, name, industry_id, contact_person, contact_phone) {
        document.getElementById('editCompanyForm').action = `/master/companies/${id}`;
        document.getElementById('edit_company_code').value = code;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_industry_id').value = industry_id;
        document.getElementById('edit_contact_person').value = contact_person;
        document.getElementById('edit_contact_phone').value = contact_phone;

        var modal = new bootstrap.Modal(document.getElementById('editCompanyModal'));
        modal.show();
    }
</script>
@endpush