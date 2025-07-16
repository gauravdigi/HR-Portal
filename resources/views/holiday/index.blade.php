@extends('layouts.app') {{-- Make sure this matches your layout file --}}

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h2 mb-0">Holiday Management</h2>
        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#addHolidayModal">
            Add Holiday
        </button>
    </div>
<!--     @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif -->

    {{-- Holiday List Table --}}
    <table class="table table-bordered" id="usersTableHoliday">
        <thead>
            <tr>
                <th>Holiday Title</th>
                <th>Holiday Date</th>
                <th>Day</th>
                <th width="150">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($holidays as $index => $h)
                <tr>
                    <td>{{ $h->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->holiday_date)->format('d/m/Y') }}</td>
                    <td>{{ $h->day }}</td>
                    <td>
                        <button 
                            class="btn btn-sm btn-warning me-1 text-white editHolidayBtn" 
                            data-id="{{ $h->id }}"
                            data-title="{{ $h->title }}"
                            data-date="{{ $h->holiday_date }}"
                            data-day="{{ $h->day }}"
                            data-action="{{ route('holiday.update', $h->id) }}"
                            data-bs-toggle="modal" 
                            data-bs-target="#editHolidayModal"
                        >
                            <i class="bi bi-pencil" title="Edit"></i>
                        </button>

                       <form action="{{ route('holiday.destroy', $h->id) }}" id="deleteForm-{{ $h->id }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $h->id }})">
                                <i class="bi bi-trash" title="Delete"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td></td>
                    <td>No holidays added yet.</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h5" id="addHolidayModalLabel">Add Holiday</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <form method="POST" action="{{ route('holiday.store') }}" id="addHoliday" novalidate>
              @csrf

                  <div class="mb-3">
                    <label for="title" class="form-label">Holiday Title</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="eg: Gurupurab" required>
                  </div>
                  <div class="mb-3">
                    <label for="holiday_date" class="form-label">Holiday Date</label>
                    <input type="date" name="holiday_date" class="form-control" id="holiday_date" placeholder="YYYY-MM-DD" required>
                  </div>

                  <button type="submit" class="btn btn-primary">Add</button>

            </form>
        </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editHolidayModal" tabindex="-1" aria-labelledby="editHolidayModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title h5" id="editHolidayModalLabel">Edit Holiday</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form method="POST" action="" id="editHolidayForm" novalidate>
          @csrf
              <input type="hidden" name="id" id="edit_id">

              <div class="mb-3">
                <label for="edit_title" class="form-label">Holiday Title</label>
                <input type="text" name="title" class="form-control" id="edit_title" required>
              </div>

              <div class="mb-3">
                <label for="edit_date" class="form-label">Holiday Date</label>
                <input type="date" name="holiday_date" class="form-control" id="edit_date" required>
              </div>

              <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script>
$(document).ready(function () {
    const form = $('#editHolidayForm');
     let editdate = flatpickr("#edit_date", { dateFormat: "Y-m-d" });
    $('.editHolidayBtn').on('click', function () {
        const id = $(this).data('id');
        const title = $(this).data('title');
        const date = $(this).data('date');
        const day = $(this).data('day');
        const url = $(this).data('action'); // ✅ dynamically fetch correct URL

        $('#edit_id').val(id);
        $('#edit_title').val(title);
        // $('#edit_date').val(date);
        $('#edit_day').val(day);
        editdate.setDate(date, true);

        form.attr('action', url); // ✅ set the form action correctly

        $('#editHolidayModal').modal('show');
    });

    form.on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form[0]);

        // Clear previous errors
        form.find('.text-danger').remove();

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            // dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: response.message ?? 'Holiday updated successfully.',
                    timer: 1500,
                    showConfirmButton: false
                });
                $('#editHolidayModal').modal('hide');
                form[0].reset();
                location.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (field, messages) {
                        let input = form.find('[data-error-for="' + field + '"]');
                        if (!input.length) {
                            input = form.find('[name="' + field + '"]').not('[type="hidden"]').first();
                        }
                        let errorEl = $('<small class="text-danger">' + messages[0] + '</small>');
                        input.after(errorEl);
                    });
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
    $('#addHoliday').on('submit', function (e) {
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
                $('#addHolidayModal').modal('hide');
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
                        let errorElement = $('<small class="text-danger error-message">' + messages[0] + '</small>');
                        input.after(errorElement);

                        if (!firstErrorInput) {
                            firstErrorInput = input;
                        }
                    });

                    // Scroll to first error inside modal
                    if (firstErrorInput) {
                        let modalBody = $('#addHolidayModal .modal-body');

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
    flatpickr("input[type='date']", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "Y-m-d",
        allowInput: true,
        onReady: function(selectedDates, dateStr, instance) {
            // instance.altInput is the visible input created by flatpickr
            // Add a data attribute to link it to the original input's name
            let fieldName = instance.input.getAttribute('name');
            if (fieldName) {
                instance.altInput.setAttribute('data-error-for', fieldName);
            }
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