@extends('layouts.admin')

@section('title', 'Notification Settings')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
        <li class="breadcrumb-item active">Notifications</li>
    </ol>
</nav>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="mb-0">Notification Preferences</h5>
                <small class="text-muted">Atur channel notifikasi mana yang ingin diaktifkan untuk Admin.</small>
            </div>
            <div class="card-body pt-4">

                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bx bx-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <form action="{{ route('settings.notifications.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Event Type</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Telegram</th>
                                    <th class="text-center">WhatsApp</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $setting)
                                <tr>
                                    <td>
                                        <span class="fw-bold d-block">{{ ucwords(str_replace('_', ' ', $setting->event_name)) }}</span>
                                        <small class="text-muted">{{ $setting->description }}</small>
                                    </td>

                                    <!-- Checkbox Email -->
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox"
                                                name="settings[{{ $setting->id }}][email]"
                                                {{ $setting->email_enabled ? 'checked' : '' }}>
                                        </div>
                                    </td>

                                    <!-- Checkbox Telegram -->
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox"
                                                name="settings[{{ $setting->id }}][telegram]"
                                                {{ $setting->telegram_enabled ? 'checked' : '' }}>
                                        </div>
                                    </td>

                                    <!-- Checkbox WhatsApp -->
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox"
                                                name="settings[{{ $setting->id }}][whatsapp]"
                                                {{ $setting->whatsapp_enabled ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection