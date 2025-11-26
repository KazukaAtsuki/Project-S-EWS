@extends('layouts.admin')

@section('title', $pageTitle ?? 'Page')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ $pageTitle ?? 'Page Title' }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    {{ $pageDescription ?? 'Halaman ini masih dalam tahap pengembangan.' }}
                </p>

                @if(isset($content))
                    {!! $content !!}
                @else
                    <div class="alert alert-info">
                        <i class="bx bx-info-circle me-2"></i>
                        Konten akan ditambahkan di sini.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection