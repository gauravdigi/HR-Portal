@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h2 mb-0">Hiring Portal</h2>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#addHiringModal">
            + Add
        </button>
    </div>   

       
    <table class="table table-bordered mb-0" id="usersTable">    
        <thead>
            <tr>   
                <th>Name</th>
                <th>Is Paid</th>
                <th>Valid From</th>
                <th>Valid UpTo</th>
                <th>Notes</th>
				<th>Actions</th>         
            </tr>
        </thead>    
        <tbody>
            @forelse($Hiringportal as $item)
                    <tr>
                        <td>{{ $item->Title }}</td>
                        <td>{{ $item->IsPaid ? 'Yes' : 'No' }}</td>
                       <td>
    						{{ $item->SubscriptionStartDT ? \Carbon\Carbon::parse($item->SubscriptionStartDT)->format('d/m/Y') : '' }}
    					</td>
    					<td>
    						{{ $item->SubscriptionEndDT ? \Carbon\Carbon::parse($item->SubscriptionEndDT)->format('d/m/Y') : '' }}
    					</td>
          
                        <td>{{ $item->Notes }}</td>
    					<td>  
    						<!-- Edit Button triggers modal -->
    						<button type="button" class="btn btn-sm btn-warning text-white editCandidate" data-id="{{ $item->id }}" data-url="{{ route('hiringportal.update', $item->id) }}" data-title="{{ $item->Title }}" data-ispaid="{{ $item->IsPaid}}" data-validto="{{ $item->SubscriptionEndDT ? \Carbon\Carbon::parse($item->SubscriptionEndDT)->format('Y-m-d') : '' }}" data-validfrom="{{ $item->SubscriptionStartDT ? \Carbon\Carbon::parse($item->SubscriptionStartDT)->format('Y-m-d') : '' }}" data-note="{{ $item->Notes }}" >
    							 <i class="bi bi-pencil"></i>
    						</button>    
                            <form action="{{ route('hiringportal.destroy', $item->id) }}" id="deleteForm-{{ $item->id }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})">
                                    <i class="bi bi-trash" title="Delete"></i>
                                </button>
                            </form>
    						<!-- Delete Button triggers modal -->
    						<!-- <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
    							 <i class="bi bi-trash"></i>    
    						</button> -->
    					</td>
    	  				 
                    </tr>
    				

            @empty
            	<tr>
                        <td></td>
                        <td></td>
                        <td class="text-center">No records found.</td>
                        <td></td>
                        <td></td>
            			<td></td>
                </tr>  
            @endforelse
        </tbody>  
    </table>
  <!-- Modal -->
    <div class="modal fade" id="addHiringModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title h2" id="addUserModalLabel">Add New Hiring Portal</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Form Starts -->
                    <form id="addHiringForm" method="POST" action="{{ route('hiringportal.store') }}" novalidate>
                        @csrf

                        <!-- Display validation errors (server side) -->
                        <div id="formErrors" class="alert alert-danger d-none"></div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label for="Title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('Title') is-invalid @enderror" id="Title" name="Title" value="{{ old('Title') }}">
                            @error('Title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- IsPaid Checkbox -->
                        <div class="form-check mb-3">
                            <input type="hidden" name="IsPaid" value="0"> <!-- Default if unchecked -->
                            <input class="form-check-input" type="checkbox" value="1" id="IsPaidCheckbox" name="IsPaid">
                            <label class="form-check-label" for="IsPaidCheckbox">
                                Is Paid?
                            </label>
                        </div>

                        <!-- Date Fields (Initially Hidden) -->
                        <div id="dateFields" style="display: none;">
                            <div class="mb-3">
                                <label for="SubscriptionStartDate" class="form-label">Valid From</label>
                                <input type="date" class="form-control @error('SubscriptionStartDT') is-invalid @enderror"
                                       id="SubscriptionStartDate" name="SubscriptionStartDT" min="2025-06-26" placeholder="YYYY-MM-DD">
                                @error('SubscriptionStartDT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="SubscriptionEndDate" class="form-label">Valid UpTo</label>
                                <input type="date" class="form-control @error('SubscriptionEndDT') is-invalid @enderror"
                                       id="SubscriptionEndDate" name="SubscriptionEndDT" min="2025-06-26" placeholder="YYYY-MM-DD">
                                @error('SubscriptionEndDT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="Notes" class="form-label">Notes</label>
                            <input type="text" class="form-control @error('Notes') is-invalid @enderror" id="Notes" name="Notes" value="{{ old('Notes') }}">
                            @error('Notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>

                    </form>
                    <!-- Form Ends -->
                </div>
            </div>
        </div>
    </div>
  <div class="modal fade" id="editHiringModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="" method="POST" class="editHiringForm" id="editHiringForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Title</label>
                            <input type="text" class="form-control" id="editTitle" name="Title">
                            @error('Title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input type="hidden" name="IsPaid" value="0">
                            <input type="checkbox" class="form-check-input" id="editIsPaidCheckbox" name="IsPaid" value="1">
                            <label class="form-check-label" for="editIsPaidCheckbox">Is Paid?</label>
                        </div>
                        
                        <!-- ⬇️ Conditional date fields -->
                        <div class="edit-date-fields" id="editDateFields" style="display: none;">
                            <div class="mb-3">  
                                <label>Valid From</label>
                                <input type="date" class="form-control" id="editValidFrom" name="SubscriptionStartDT" placeholder="YYYY-MM-DD">
                                @error('SubscriptionStartDT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Valid UpTo</label>
                                <input type="date" class="form-control" id="editValidTo" name="SubscriptionEndDT" placeholder="YYYY-MM-DD">
                                @error('SubscriptionEndDT')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="mb-3">
                            <label>Notes</label>
                            <input type="text" class="form-control" id="editNotes" name="Notes">
                            
                            @error('Notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- add -->
<script>

$(document).ready(function () {
    const editModal = $('#editHiringModal');
    const form = $('#editHiringForm');
    let editStartPicker = flatpickr("#editValidFrom", { dateFormat: "Y-m-d" });
    let editEndPicker = flatpickr("#editValidTo", { dateFormat: "Y-m-d" });

    // On Edit Button Click
    $('.editCandidate').on('click', function () {
        editModal.modal('show');
        const button = $(this);
        const id = button.data('id');
        const url = button.data('url');
        const title = button.data('title') || '';
        const isPaid = button.data('ispaid') == 1;
        const validFrom = button.data('validfrom') || '';
        const validTo = button.data('validto') || '';
        const notes = button.data('note') || '';
        var ispaidchecked;
    

        editStartPicker.setDate(validFrom, true);
        editEndPicker.setDate(validTo, true);

        $('#editTitle').val(title);
        if(isPaid == 0){
            ispaidchecked = false;
        }else{
            ispaidchecked = true;
        }
        $('#editIsPaidCheckbox').prop('checked', ispaidchecked);
        $('#editNotes').val(notes);
        

        // Toggle date fields
        if (isPaid) {
            $('#editDateFields').show();
        } else {
            $('#editDateFields').hide();
        }

        // Dynamic action
        form.attr('action', url);

        
    });

    // Toggle Date Fields on Checkbox Change
    $('#editIsPaidCheckbox').on('change', function () {
        if ($(this).is(':checked')) {
            $('#editDateFields').slideDown();
        } else {
            $('#editDateFields').slideUp();
        }
    });

    // AJAX Form Submission
    form.on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        form.find('.text-danger').remove();

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: response.message ?? 'Hiring Portal updated successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
                editModal.modal('hide');
                form[0].reset();
                location.reload();
            },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let firstErrorInput = null;

                        $.each(errors, function (field, messages) {
                            let input = form.find('[data-error-for="' + field + '"]');
                            if (!input.length) {
                                input = form.find('[name="' + field + '"]').not('[type="hidden"]').first();
                            }

                            // ✅ Additional flatpickr handling
                            if (!input.length) {
                                // Check if this field is a flatpickr date field with altInput
                                const hiddenInput = form.find(`input[name="${field}"]`)[0];
                                if (hiddenInput && hiddenInput._flatpickr && hiddenInput._flatpickr.altInput) {
                                    input = $(hiddenInput._flatpickr.altInput);
                                }
                            }

                            let errorElement = $('<small class="text-danger error-message">' + messages[0] + '</small>');
                            input.after(errorElement);

                            if (!firstErrorInput) {
                                firstErrorInput = input;
                            }
                        });

                        // Scroll to first error inside modal
                        if (firstErrorInput) {
                            let modalBody = $('#addHiringModal .modal-body');

                            modalBody.animate({
                                scrollTop: firstErrorInput.offset().top - modalBody.offset().top + modalBody.scrollTop() - 40
                            }, 300);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                
                }
        });
    });
});


    $(document).ready(function () {
        $('#addHiringForm').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let formData = new FormData(this);

            // Clear previous errors
            form.find('.error-message').remove();

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Holiday added successfully.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $('#addHiringModal').modal('hide');
                    form[0].reset();
                    // Optionally refresh your table dynamically instead of reloading
                    location.reload();
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let firstErrorInput = null;

                        $.each(errors, function (field, messages) {
                            let input = form.find('[data-error-for="' + field + '"]');
                            if (!input.length) {
                                input = form.find('[name="' + field + '"]').not('[type="hidden"]').first();
                            }

                            // ✅ Additional flatpickr handling
                            if (!input.length) {
                                // Check if this field is a flatpickr date field with altInput
                                const hiddenInput = form.find(`input[name="${field}"]`)[0];
                                if (hiddenInput && hiddenInput._flatpickr && hiddenInput._flatpickr.altInput) {
                                    input = $(hiddenInput._flatpickr.altInput);
                                }
                            }

                            let errorElement = $('<small class="text-danger error-message">' + messages[0] + '</small>');
                            input.after(errorElement);

                            if (!firstErrorInput) {
                                firstErrorInput = input;
                            }
                        });

                        // Scroll to first error inside modal
                        if (firstErrorInput) {
                            let modalBody = $('#addHiringModal .modal-body');

                            modalBody.animate({
                                scrollTop: firstErrorInput.offset().top - modalBody.offset().top + modalBody.scrollTop() - 40
                            }, 300);
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                
                }
            });
        });
    }); 
</script>
<!-- edit -->
<script>
    // document.addEventListener('DOMContentLoaded', function () {
    //     document.querySelectorAll('.editForm').forEach(function(form) {
    //         document.addEventListener('submit', function(e) {
    //             if (e.target.matches('.editForm')) {
    //                 e.preventDefault();
    //                 const form = e.target;
    //                 handleEditFormSubmit(form);
    //             }

    //             const formData = new FormData(form);
    //             const action = form.getAttribute('action');
    //             const modalId = '#editModal' + form.dataset.id;
    //             const modal = bootstrap.Modal.getInstance(document.querySelector(modalId));
    //             modal.show();
    //             // Clear previous errors
    //             form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    //             form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

    //             fetch(action, {
    //                 method: 'POST',
    //                 headers: {
    //                     'X-Requested-With': 'XMLHttpRequest',
    //                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    //                     'Accept': 'application/json',
    //                 },
    //                 body: formData
    //             })
    //             .then(async response => {
    //                 if (!response.ok) {
    //                     const data = await response.json();
    //                     if (data.errors) {
    //                         for (const [field, messages] of Object.entries(data.errors)) {
    //                             // Find input by name
    //                             let input = form.querySelector(`[name="${field}"]:not([type="hidden"])`);

    //                             if (!input) {
    //                                 // Handle flatpickr altInput
    //                                 const hiddenInput = form.querySelector(`input[name="${field}"]`);
    //                                 if (hiddenInput && hiddenInput._flatpickr && hiddenInput._flatpickr.altInput) {
    //                                     input = hiddenInput._flatpickr.altInput;
    //                                 }
    //                             }

    //                             if (input) {
    //                                 input.classList.add('is-invalid');
    //                                 const errorDiv = document.createElement('div');
    //                                 errorDiv.classList.add('invalid-feedback');
    //                                 errorDiv.innerText = messages[0];
    //                                 input.after(errorDiv);
    //                             }
    //                         }
    //                     } else {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Error',
    //                             text: 'Unexpected error occurred.',
    //                         });
    //                     }
    //                 } else {
    //                     const data = await response.json();

    //                     modal.hide();

    //                     Swal.fire({
    //                         icon: 'success',
    //                         title: 'Updated',
    //                         text: data.message || 'Record updated successfully.',
    //                         timer: 1500,
    //                         showConfirmButton: false
    //                     });

    //                     // Reload your table contents without a full page reload
    //                     fetch("{{ route('hiringportal.index') }}")
    //                         .then(res => res.text())
    //                         .then(html => {
    //                             const parser = new DOMParser();
    //                             const doc = parser.parseFromString(html, 'text/html');
    //                             const updatedTable = doc.getElementById('hiringportalTable');

    //                             if (updatedTable) {
    //                                 document.getElementById('hiringportalTable').innerHTML = updatedTable.innerHTML;
    //                             }
    //                         });
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error(error);
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Error',
    //                     text: 'Error submitting form.',
    //                 });
    //             });
    //         });
    //     });
    // });
</script>
<!-- IS paid js and others -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isPaidCheckbox = document.getElementById('IsPaidCheckbox');
        const dateFields = document.getElementById('dateFields');
        const dateInputs = dateFields.querySelectorAll('input[type="date"]');

        function toggleDateFields() {
            if (isPaidCheckbox.checked) {
                dateFields.style.display = 'block';

                dateInputs.forEach(input => {
                    input.setAttribute('required', 'required');

                    // Add required to the visible altInput
                    const altInput = input._flatpickr && input._flatpickr.altInput;
                    if (altInput) {
                        altInput.setAttribute('required', 'required');
                    }
                });
            } else {
                dateFields.style.display = 'none';

                dateInputs.forEach(input => {
                    input.removeAttribute('required');

                    // Remove required from the visible altInput
                    const altInput = input._flatpickr && input._flatpickr.altInput;
                    if (altInput) {
                        altInput.removeAttribute('required');
                    }
                });
            }
        }

        isPaidCheckbox.addEventListener('change', toggleDateFields);

        // Initialize visibility and required attributes
        toggleDateFields();
    });
</script>
 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // For all checkboxes with class "isPaidCheckbox"
        document.querySelectorAll('.isPaidCheckbox').forEach(function (checkbox) {
            const targetId = checkbox.getAttribute('data-target');
            const target = document.querySelector(targetId);

            function toggleDateFields() {
                if (checkbox.checked) {
                    target.style.display = 'block';
                } else {
                    target.style.display = 'none';
                }
            }

            checkbox.addEventListener('change', toggleDateFields);

            // Initial load
            toggleDateFields();
        });
    });
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

    flatpickr("input[type='date']", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "Y-m-d",    // e.g., June 16, 2025
        allowInput: true,
            onReady: function(selectedDates, dateStr, instance) {
        // Add class to the created altInput field
        instance.altInput.classList.add('date-field');
    }
    });
</script>
 @if(session('success') && session('title'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            icon: 'success',
            title: @json(session('title')) + '!',
            text: @json(session('success')),
            timer: 2000,
            showConfirmButton: false
        });
    });
</script>
@endif
 
@endsection   
