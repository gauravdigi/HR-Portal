@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h2 class="h2 mb-3">Employee List</h2>
        <!-- <form method="GET" id="filterForm" action="{{ route(request()->route()->getName()) }}" class="mb-4">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="status" class="col-form-label">Filter by Status:</label>
                </div>
                <div class="col-auto">
                    <select name="status" id="status" class="form-select" onchange="this.form.submit()">
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
                               onchange="this.form.submit()"
                               {{ request('past') ? 'checked' : '' }}>
                        Show Past Employees
                    </label>
                </div>
                <div class="col-auto">
                        {{-- Deleted Users Filter --}}
                    <label style="margin-left: 10px;">
                        <input type="checkbox" name="deleted" value="1"
                               onchange="this.form.submit()"
                               {{ request()->has('deleted') ? 'checked' : '' }}>
                        Show Deleted Users
                    </label>
                </div>
            </div>
        </form> -->

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
                                <span id="status-badge-{{ $employee->id }}" class="badge @if($employee->user_is_deleted)btn disabled @else bg-{{ $statusLabels[$employee->is_approved]['class'] }}@endif" 
                                @if($employee->user_is_deleted) disabled @else @endif>
                                @if($employee->user_is_deleted)
                                    Deleted
                                @else
                                    {{ $statusLabels[$employee->is_approved]['label'] }}
                                @endif
                                </span>
                                @if(auth()->user()->email === $employee->user_email || $employee->user_is_deleted || $statusLabels[$employee->is_approved]['label'] == 'Draft')

                                @else
                                <button type="button"
                                    class="btn btn-sm btn-light border d-flex align-items-center justify-content-center"
                                    style="width: 30px; height: 30px;"
                                    onclick="openApprovalOptions({{ $employee->id }}, document.getElementById('statusInput-{{ $employee->id }}').value, '{{ $employee->user_name }}')">
                                    <i class="ti ti-pencil fs-6 text-primary" title="status"></i>
                                </button>
                                @endif
                                
                                <form action="{{ route('admin.employe.approve', $employee->id) }}" method="POST" id="approvalForm-{{ $employee->id }}">
                                    @csrf
                                    <input type="hidden" name="is_approved" id="statusInput-{{ $employee->id }}" value="{{ $employee->is_approved }}">
                                </form>
                               
                                
                            </div>
                        @endif 
                        </td>

                        <td>
                            <a href="{{ route('admin.employe.view', $employee->id) }}" class="btn btn-sm btn-info text-white"><i class="bi bi-eye" title="View"></i></a>  
                            @if($employee->user_is_deleted)
                                <button type="button" class="btn btn-sm btn-warning text-white" disabled><i class="bi bi-pencil" title="Edit"></i></button>
                            @else  
                                <a href="{{ route('admin.employe.edit', $employee->id) }}" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil" title="Edit"></i></a>
                            @endif

                            @if($employee->user_is_deleted)

                            <button type="button" class="btn btn-sm btn-danger" disabled title="Deleted"> <i class="bi bi-trash" ></i></button>
                            @else
                            
                            <form action="{{ route('admin.employe.destroy', $employee->id) }}" id="deleteForm-{{ $employee->id }}" method="POST" style="display:inline;">
                                @csrf 
                                @method('DELETE')
                                @if(auth()->user()->email === $employee->user_email) @endif
                                <button type="button" class="btn btn-sm btn-danger" @if(auth()->user()->email === $employee->user_email) disabled @endif @if(auth()->user()->email === $employee->user_email) @else onclick="confirmDelete( {{ $employee->id }} )" @endif> <i class="bi bi-trash" title="Delete"></i></button>
                            </form>
                            @endif
                            @if($employee->user_is_deleted)
                            <button type="button" class="btn btn-info btn-sm" disabled><i class="bi bi-key" title="Change Password"></i></button>
                            @else
                            <button type="button" class="btn btn-info btn-sm" onclick="openChangePasswordModal({{ $employee->id }}, '{{ $employee->user_name }}')"><i class="bi bi-key" title="Change Password"></i></button>
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



<!-- Popup Password -->

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h5" id="changePasswordUserName">Change Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form id="changePasswordForm" method="POST">
                  @csrf
                  <input type="hidden" name="employee_id" id="passwordUserId">

                      <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" id="passwordInput" class="form-control" required>
                        <span toggle="#passwordInput" class="field-icon toggle-password"><i class="bi bi-eye"></i></span>
                        <div id="passwordError" class="text-danger small"></div>
                      </div>

                      <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" id="confirmPasswordInput" class="form-control" required>
                        <span toggle="#confirmPasswordInput" class="field-icon toggle-password"><i class="bi bi-eye"></i></span>
                        <div id="confirmPasswordError" class="text-danger small"></div>
                      </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
        </div> 
      </div>
  </div>
</div>

<!-- Popup for Status change -->

<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h5" id="changeStatusUserName">Change Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form id="changeStatusForm" method="POST" action="{{ route('admin.employe.update-status') }}">
          @csrf
          <input type="hidden" name="employee_id" id="StatusUserId">

          <div class="mb-3">
            <label for="statusSelect" class="form-label">Select Status</label>
            <select class="form-select" id="statusSelect" name="status" required>
              <option value="1">Pending</option>
              <option value="2">Approved</option>
              <option value="3">Rejected</option>
            </select>
            <span class="text-danger" id="statusError"></span>
          </div>

          <button type="submit" class="btn btn-primary">Update Status</button>
        </form>
      </div>
    </div>
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
    .swal-update-button{
        background:#0bb2fb;
    }

    i.bi {
        font-size: 14px;
    }
    .field-icon {
        position: absolute;
        right: 12px;
        top: 45px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
</style>


<script>

    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function () {
            const input = document.querySelector(this.getAttribute('toggle'));
            const icon = this.querySelector('i');

            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
});
    
$(document).ready(function () {
    // Initial DataTable setup
    $('#usersTable').DataTable();

    function filterEmployees() {
        var formData = $('#filterForm').serialize();
        jQuery('.ApWait').show();
        $.ajax({
            url: "{{ route('admin.dashboard') }}",
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
function openChangePasswordModal(employeeId, userName) {
    $('#passwordUserId').val(employeeId);
    $('#changePasswordUserName').html(`Change Password for <span class="text-success">${userName}</span>`);
    $('#passwordInput').val('');
    $('#confirmPasswordInput').val('');
    clearValidationErrors();

    let modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
    modal.show();
}

function clearValidationErrors() {
    $('#passwordError').text('');
    $('#confirmPasswordError').text('');
}

$('#changePasswordForm').on('submit', function (e) {
    e.preventDefault();

    clearValidationErrors();

    let employeeId = $('#passwordUserId').val();
    let password = $('#passwordInput').val().trim();
    let confirmPassword = $('#confirmPasswordInput').val().trim();
    let isValid = true;

    // Client-side validation

  if(password == ''){
        $('#passwordError').text('Password is required.');
        isValid = false;    
    }
    if(confirmPassword == ''){
        $('#confirmPasswordError').text('Confirm Password is required.');
        isValid = false;    
    }

    if(password){
        if (password.length < 8) {
            $('#passwordError').text('Password must be at least 8 characters.');
            isValid = false;
        }
    }
    if (password.length == 8) {
        if (password !== confirmPassword) {
            $('#confirmPasswordError').text('Passwords do not match.');
            isValid = false;
        }
    }else{
        if(confirmPassword == ''){
            $('#confirmPasswordError').text('Confirm Password is required.');
            isValid = false;    
        }     
    }

    if (!isValid) return;

    $.ajax({
        url: "{{ route('admin.employe.change-password') }}",
        method: "POST",
        data: {
            employee_id: employeeId,
            password: password,
            password_confirmation: confirmPassword,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            let modalEl = document.getElementById('changePasswordModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Password Updated',
                text: 'Password changed successfully!',
                timer: 2000,
                showConfirmButton: false
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                if (errors.password) {
                    $('#passwordError').text(errors.password[0]);
                }
                if (errors.password_confirmation) {
                    $('#confirmPasswordError').text(errors.password_confirmation[0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        }
    });
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


function openApprovalOptions(id, currentStatus, userName) {
    document.getElementById('changeStatusUserName').innerHTML  = `Update Approval Status for <span class="text-success">${userName}</span>`;
    document.getElementById('StatusUserId').value = id;
    document.getElementById('statusSelect').value = currentStatus;

    // Show Bootstrap modal
    const modal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
    modal.show();
}

$('#changeStatusForm').on('submit', function (e) {
    e.preventDefault();

    $('#statusError').text('');
    let form = $(this);
    let employeeId = $('#StatusUserId').val();
    let status = $('#statusSelect').val();
    let url = form.attr('action');

    if (status === '') {
        $('#statusError').text('Please select a status.');
        return;
    }

    $.ajax({
        url: url,
        method: 'POST',
        data: {
            employee_id: employeeId,
            status: status,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // Hide modal
            //console.log(status)
            const modalEl = document.getElementById('changeStatusModal');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            modalInstance.hide();

            // Update badge text and class
            $(`#status-badge-${employeeId}`)
                .text(response.statusText)
                .removeClass()
                .addClass(`badge bg-${response.statusClass}`);

            // Toast / feedback
            Swal.fire({
                icon: 'success',
                title: 'Updated',
                text: 'Status updated successfully!',
                timer: 1500,
                showConfirmButton: false
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                if (errors.status) {
                    $('#statusError').text(errors.status[0]);
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.'
                });
            }
        }
    });
});


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

    @if(session('approve'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('approve') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection

