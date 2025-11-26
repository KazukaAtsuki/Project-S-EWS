@extends('layouts.admin')

@section('title', 'Edit Level')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Level</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('master.levels.update', $level->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Code</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   name="code"
                                   class="form-control @error('code') is-invalid @enderror"
                                   placeholder="ex: admin"
                                   value="{{ old('code', $level->code) }}"
                                   required>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Code harus unique dan lowercase (contoh: admin, noc, operator)</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Level Name</label>
                        <div class="col-sm-10">
                            <input type="text"
                                   name="level"
                                   class="form-control @error('level') is-invalid @enderror"
                                   placeholder="ex: Administrator"
                                   value="{{ old('level', $level->level) }}"
                                   required>
                            @error('level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <a href="{{ route('master.levels') }}" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection