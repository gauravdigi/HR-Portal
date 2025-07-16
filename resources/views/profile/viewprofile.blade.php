@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 h2">Profile</h2>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <div class="d-flex align-items-center mb-4">
                    <div class="me-3">
                        @php
                            $profileImage = $user->employee->profile_image ?? null;
                        @endphp

                        @if($profileImage && Storage::disk('public')->exists($profileImage))
                            <img src="{{ asset('storage/' . $profileImage) }}"
                                 alt="Profile Image"
                                 class="rounded-circle shadow"
                                 width="80" style="height: 80px;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=100"
                                 alt="Default Avatar"
                                 class="rounded-circle shadow"
                                 width="80" height="80" >
                        @endif
                    </div>
                    <div>
                        <h4 class="mb-0">{{ $user->name }}</h4>
                        <small class="text-muted">HR Role</small>
                    </div>
                </div>

                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-envelope-fill me-2"></i> Email</div>
                        <span>{{ $user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-person-badge-fill me-2"></i> Role</div>
                        <span class="badge bg-primary text-capitalize">{{ $user->role ?? 'HR' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div><i class="bi bi-calendar-check me-2"></i> Joined</div>
                        <span>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                    </li>
                </ul>

                <div class="text-end">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                        <i class="bi bi-pencil-square me-1"></i> Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection