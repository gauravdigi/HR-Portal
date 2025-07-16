@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Accountant Dashboard</h1>
        <p>Welcome, {{ auth()->user()->name }}!</p>
        <p>You have view-only access to employee data.</p>
        <a href="{{ route('accountant.employe.index') }}" class="btn btn-primary">View Employees</a>
    </div>
@endsection
