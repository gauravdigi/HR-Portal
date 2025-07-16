@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Employee List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
      
    <a href="{{ route('admin.employe.create') }}" class="btn btn-primary mb-3">Add New Employee</a>
	
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>	
	<link 
    rel="stylesheet" 
    href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"
  />
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <!-- DataTables JS -->
  <script 
    src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js">
  </script>
    <script>
    $(document).ready(function () {
      $('#usersTable').DataTable({
        paging: true,       // Enable pagination
        searching: true,    // Enable search box
        ordering: true,     // Enable column sorting
        info: true          // Show info text ("Showing 1 to 5 of 10 entries")
      });
    });
  </script>
  

    <table class="table table-bordered" id="usersTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Designation</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($employees as $employee)
            <tr>
                <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ $employee->designation }}</td>
                <td>{{ $employee->phone }}</td>
                <td>    
                    
                     @if (!$employee->is_approved)
						<form action="{{ route('admin.employe.approve', $employee->id) }}" method="POST" style="display:inline;">
							@csrf
							<button class="btn btn-sm btn-success" onclick="return confirm('Approve this user?')">Approve</button>
						</form>  
					@else 
						<span class="badge bg-success">Approved</span>
					@endif					
                    <a href="{{ route('admin.employe.edit', $employee->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.employe.destroy', $employee->id) }}" method="POST" style="display:inline;">
                        @csrf 
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
					
					        
                </td>
            </tr>
        @empty
            <tr><td colspan="5">No employees found.</td></tr>
        @endforelse
        </tbody>
    </table>
	
	
</div>
@endsection
  