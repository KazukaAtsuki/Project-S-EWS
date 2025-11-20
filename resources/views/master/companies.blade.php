@extends('layouts.admin')

@section('title', 'Companies')

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Settings</a></li>
        <li class="breadcrumb-item active">Company Management</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">List Company</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                    <i class="bx bx-plus me-1"></i> Add New
                </button>
            </div>
            <div class="card-body">
                <!-- Alert Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
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

                <!-- Search & Entries -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <label class="me-2">Show</label>
                            <select class="form-select form-select-sm" style="width: auto;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="ms-2">entries</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end">
                            <input type="text" class="form-control form-control-sm" placeholder="Search..." style="width: 250px;">
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Action</th>
                                <th>Company Code</th>
                                <th>Industry</th>
                                <th>Name</th>
                                <th>Contact Person</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($companies as $company)
                            <tr>
                                <td>
                                    <button type="button" class="btn btn-sm btn-icon btn-label-primary me-1" title="View">
                                        <i class="bx bx-show"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-icon btn-label-info me-1" title="Edit"
                                        onclick="editCompany({{ $company->id }}, '{{ $company->company_code }}', '{{ $company->name }}', {{ $company->industry_id }}, '{{ $company->contact_person }}', '{{ $company->contact_phone }}')">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <form action="{{ route('master.companies.destroy', $company->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this company?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-icon btn-label-danger" title="Delete">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <td><strong>{{ $company->company_code }}</strong></td>
                                <td>
                                    @if($company->industryRelation)
                                    <span class="badge bg-label-info">{{ $company->industryRelation->name }}</span>
                                @else
                                    <span class="badge bg-label-secondary">-</span>
                                @endif

                                </td>
                                <td>{{ $company->name }}</td>
                                <td>
                                    <span class="badge bg-label-info">{{ $company->contact_phone ?? '-' }}</span>
                                    ({{ $company->contact_person }})
                                </td>
                                <td>{{ $company->created_at->format('D, d F Y H:i:s') }}</td>
                                <td>{{ $company->updated_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                <td colspan="7" class="text-center">No companies found.</td>
                                </tr>
                                @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        Showing {{ $companies->firstItem() ?? 0 }} to {{ $companies->lastItem() ?? 0 }} of {{ $companies->total() }} entries
                    </div>
                    <div>
                        {{ $companies->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('master.companies.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add New Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Company Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Industry <span class="text-danger">*</span></label>
                        <select class="form-select" name="industry_id" required>
                            <option value="">Select Industry</option>
                            @forelse($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @empty
                                <option value="">No industries available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="contact_person" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" name="contact_phone" placeholder="+62xxx">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editCompanyForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Company Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="company_code" id="edit_company_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Company Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Industry <span class="text-danger">*</span></label>
                        <select class="form-select" name="industry_id" id="edit_industry_id" required>
                            <option value="">Select Industry</option>
                            @forelse($industries as $industry)
                                <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                            @empty
                                <option value="">No industries available</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Person <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="contact_person" id="edit_contact_person" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Phone</label>
                        <input type="text" class="form-control" name="contact_phone" id="edit_contact_phone">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Company</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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