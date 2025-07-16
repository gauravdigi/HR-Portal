@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0 h2">Profile</h2>
        <a href="{{ route ('profile.viewprofile') }}" class="btn btn-link text-decoration-none">
            <i class="bi bi-arrow-left-circle me-1"></i> Back
        </a>
    </div>

    <!-- <div class="card mb-3">
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div> -->

    <div class="card mb-3">
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- <div class="card mb-3">
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div> -->
</div>
@endsection