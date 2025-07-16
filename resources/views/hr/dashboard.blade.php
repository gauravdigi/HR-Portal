@extends('layouts.app')

@section('content')
    <div class="container-fluid">
    <h2 class="h2 mb-3">Employee List</h2>
       <form id="filterForm" class="mb-4">
            @csrf
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="status" class="col-form-label">Filter by Status:</label>
                </div>
                <div class="col-auto">
                    <select name="status" id="status" class="form-select">
                        <option value="">All</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draft</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Pending</option>
                        <option value="2" {{ request('status') === '2' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>
                <div class="col-auto">
                    <label>
                        <input type="checkbox"
                               name="past"
                               value="1"
                               id="past"
                               {{ request('past') ? 'checked' : '' }}>
                        Show Past Employees
                    </label>
                </div>
            </div>
        </form>
        <div id="employeeList">
            <table class="table table-bordered" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($employees as $employee)
                    <tr>
                        <td>{{ $employee->user_name }}</td>
                        <td>{{ $employee->user_email }}</td>
                        <td>{{ $employee->designation }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>
                         @php
                            $statusLabels = [
                                0 => ['label' => 'Draft',  'class' => 'dark'],
                                1 => ['label' => 'Pending', 'class' => 'warning'],
                                2 => ['label' => 'Approved',  'class' => 'success'],
                                3 => ['label' => 'Rejected', 'class' => 'danger'],
                            ];
                        @endphp
                        @if($employee->release_date && \Carbon\Carbon::parse($employee->release_date)->lt(\Carbon\Carbon::today()))
                            <div class="d-flex align-items-center gap-2">
                                <span id="status-badge-danger" class="badge bg-danger">Past Employee</span>
                            </div>
                        @else
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge @if($employee->user_is_deleted)btn disabled @else bg-{{ $statusLabels[$employee->is_approved]['class'] }}@endif" 
                                @if($employee->user_is_deleted) disabled @else @endif>
                                @if($employee->user_is_deleted)
                                    Deleted
                                @else
                                    {{ $statusLabels[$employee->is_approved]['label'] }}
                                @endif
                            </span>
                        </div>
                        @endif
                        </td>
                        <td>
                            <a href="{{ route('hr.employe.view', $employee->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></a> 

                            
                          
                                @if($employee->user_is_deleted)

                                @else 
                                    @if($employee->user_role == 'admin') 
                                    <button type="button" class="btn btn-sm btn-warning text-white" disabled> <i class="bi bi-pencil"></i> </button>
                                    @else
                                        <a href="{{ route('hr.employe.edit', $employee->id) }}" class="btn btn-sm btn-warning text-white"> <i class="bi bi-pencil"></i></a>
                                    @endif
                                @endif
                           

                                @if($employee->user_is_deleted)

                                <button type="button" class="btn btn-sm btn-danger" disabled> <i class="bi bi-trash "></i></button>
                                @else
                                    @if($employee->user_role == 'admin')
                                    <button type="button" class="btn btn-sm btn-danger" disabled> <i class="bi bi-trash"></i></button>
                                    @else

                                    <form action="{{ route('hr.employe.destroy', $employee->id) }}" id="deleteForm-{{ $employee->id }}" method="POST" style="display:inline;">
                                        @csrf 
                                        @method('DELETE')
                                        @if(auth()->user()->email === $employee->user_email) @endif
                                        <button type="button" class="btn btn-sm btn-danger" @if(auth()->user()->email === $employee->user_email) disabled @endif @if(auth()->user()->email === $employee->user_email) @else onclick="confirmDelete( {{ $employee->id }} )" @endif> <i class="bi bi-trash"></i></button>
                                    </form>

                                    @endif
                                @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">No employees found.</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
</div>
<style>
    .container-fluid
{
    position: relative;
}
h2.h2.mb-3.text-center
{
    margin-bottom: 50px !important;
}
form.mb-4
{
    position: absolute;
    left: 0;
    right: 310px;
}
.row.g-2.align-items-center
{
    justify-content: end;
}
.swal2-select.swal-select {
   /* appearance: none;  shows system arrow */
    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg width='14' height='10' viewBox='0 0 14 10' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23333' d='M7 10L0 0h14z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 12px;
    padding-right: 2.5rem;
}
.btn:disabled{
    cursor: not-allowed !important;
}
.btn:disabled {
    cursor: not-allowed !important;
    background-color: grey;
    border-color: grey;
}
.dataTables_wrapper .row:first-child div{
    z-index: 1;
    width: auto;
}
.dataTables_wrapper .row:first-child{
   justify-content: space-between;
}

i.bi {
    font-size: 14px;
}
</style>

<script>
$(document).ready(function () {
    // Initial DataTable setup
    $('#usersTable').DataTable();

    function filterEmployees() {
        var formData = $('#filterForm').serialize();
        jQuery('.ApWait').show();
        $.ajax({
            url: "{{ route('hr.dashboard') }}",
            type: "GET", // use GET since route is GET
            data: formData,
            success: function (response) {
                jQuery('.ApWait').hide();
                const newHtml = $('<div>').html(response).find('#employeeList').html();
                $('#employeeList').html(newHtml);

                // Destroy previous instance and reinitialize
                if ($.fn.DataTable.isDataTable('#usersTable')) {
                    $('#usersTable').DataTable().destroy();
                }
                $('#usersTable').DataTable({
                    paging: true,       // Enable pagination
                    searching: true,    // Enable search box
                    ordering: true,     // Enable column sorting
                    info: true,         // Show info text ("Showing 1 to 5 of 10 entries")
                    columnDefs: [
                        { orderable: true, targets: 0 },              // Enable ordering on first column
                        { orderable: false, targets: '_all' }         // Disable ordering on all other columns
                    ]          
                  });
            },
            error: function (xhr, status, error) {
                jQuery('.ApWait').hide();
                console.error("AJAX error:", error);
                //alert("AJAX error: " + xhr.status + " - " + xhr.responseText);
            }
        });
    }

    $('#status, #past').on('change', filterEmployees);
});

</script>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.getElementById('deleteForm-' + id);
                if (form) {
                    form.submit();
                } else {
                    console.error('Form not found for ID: ' + id);
                }
            }
        });
    }

</script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Deleted!',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection

