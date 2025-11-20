@extends('layouts.admin')

@section('title', 'Add New User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Add New User</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('master.users.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="ex: Jhon doe"
                                   value="{{ old('name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email"
                                   name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="cth: jhon@ews.co.id"
                                   value="{{ old('email') }}"
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <label class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-sm-4">
                            <input type="text"
                                   name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="cth: 6282xxxx"
                                   value="{{ old('phone') }}"
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Password"
                                       required>
                                <button class="btn btn-outline-secondary"
                                        type="button"
                                        id="generateBtn">
                                    Generate Password
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Company</label>
                        <div class="col-sm-10">
                            <select name="company"
                                    class="form-select @error('company') is-invalid @enderror"
                                    required>
                                <option value="">Choose Company</option>
                                @foreach($companies as $company)
                                    <option value="{{ $company }}" {{ old('company') == $company ? 'selected' : '' }}>
                                        {{ $company }}
                                    </option>
                                @endforeach
                            </select>
                            @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select name="role"
                                    class="form-select @error('role') is-invalid @enderror"
                                    required>
                                <option value="">Choose Role</option>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                                <option value="NOC" {{ old('role') == 'NOC' ? 'selected' : '' }}>NOC</option>
                                <option value="CEMS Operator" {{ old('role') == 'CEMS Operator' ? 'selected' : '' }}>CEMS Operator</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <a href="{{ route('master.users') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-success">Create New</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('generateBtn').addEventListener('click', function() {
    fetch('{{ route("master.users.generate-password") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('password').value = data.password;
        })
        .catch(error => console.error('Error:', error));
});
</script>
@endpush