@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Doctors</h4>
                    <!-- Form for Add/Edit -->
                    <form id="doctorForm" action="{{ route('admin.doctors.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <input type="hidden" name="id" id="doctorId">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep unchanged" {{ !isset($doctor) ? 'required' : '' }}>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_of_birth">Date of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sex">Sex</label>
                                <select class="form-control" id="sex" name="sex">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="blocked">Blocked</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="education">Education</label>
                                <input type="text" class="form-control" id="education" name="education" placeholder="e.g., MBBS, MD">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="specialty">Specialty</label>
                                <input type="text" class="form-control" id="specialty" name="specialty" placeholder="e.g., Cardiology">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="experience">Years of Experience</label>
                                <input type="number" class="form-control" id="experience" name="experience" min="0">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hospital">Hospital</label>
                                <input type="text" class="form-control" id="hospital" name="hospital" placeholder="e.g., City Hospital">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Add Doctor</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </form>
                </div>
            </div>
            <!-- DataTable -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Doctor List</h4>
                    <div style="overflow-x: auto; width: 100%;">
                        <table id="doctorTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date of Birth</th>
                                    <th>Sex</th>
                                    <th>State</th>
                                    <th>Status</th>
                                    <th>Education</th>
                                    <th>Specialty</th>
                                    <th>Experience</th>
                                    <th>Hospital</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function() {
    // Initialize DataTable
    var table = $('#doctorTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.doctors.get') }}',
        columns: [
            { data: 'id', name: 'users.id' },
            { data: 'name', name: 'users.name' },
            { data: 'email', name: 'users.email' },
            { data: 'phone', name: 'users.phone' },
            { data: 'date_of_birth', name: 'users.date_of_birth' },
            { data: 'sex', name: 'users.sex' },
            { data: 'state', name: 'users.state' },
            { data: 'status', name: 'users.status' },
            { data: 'education', name: 'doctor_details.education' },
            { data: 'specialty', name: 'doctor_details.specialty' },
            { data: 'experience', name: 'doctor_details.experience' },
            { data: 'hospital', name: 'doctor_details.hospital' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Form submission
    $('#doctorForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        var method = $('#method').val() === 'PUT' ? 'POST' : $('#method').val();
        var data = form.serialize();

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                table.ajax.reload();
                form.trigger('reset');
                $('#method').val('POST');
                $('#doctorId').val('');
                $('#submitBtn').text('Add Doctor');
                $('#password').attr('required', true);
                alert(response.success);
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || xhr.responseJSON.error || 'An error occurred'));
            }
        });
    });

    // Edit button click
    $(document).on('click', '.edit-doctor', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('admin.doctors.edit', ':id') }}'.replace(':id', id),
            type: 'GET',
            success: function(response) {
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#phone').val(response.phone);
                $('#date_of_birth').val(response.date_of_birth);
                $('#sex').val(response.sex);
                $('#state').val(response.state);
                $('#status').val(response.status);
                $('#education').val(response.education);
                $('#specialty').val(response.specialty);
                $('#experience').val(response.experience);
                $('#hospital').val(response.hospital);
                $('#doctorId').val(response.id);
                $('#method').val('PUT');
                $('#password').val('').removeAttr('required');
                $('#doctorForm').attr('action', '{{ route('admin.doctors.update', ':id') }}'.replace(':id', id));
                $('#submitBtn').text('Update Doctor');
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred'));
            }
        });
    });

    // Delete button click
    $(document).on('click', '.delete-doctor', function() {
        if (confirm('Are you sure you want to delete this doctor?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route('admin.doctors.destroy', ':id') }}'.replace(':id', id),
                type: 'DELETE',
                success: function(response) {
                    table.ajax.reload();
                    alert(response.success);
                },
                error: function(xhr) {
                    alert('Error: ' + (xhr.responseJSON.message || xhr.responseJSON.error || 'An error occurred'));
                }
            });
        }
    });

    // Reset form
    $('#resetBtn').on('click', function() {
        $('#doctorForm').trigger('reset');
        $('#method').val('POST');
        $('#doctorId').val('');
        $('#password').attr('required', true);
        $('#doctorForm').attr('action', '{{ route('admin.doctors.store') }}');
        $('#submitBtn').text('Add Doctor');
    });
});
</script>
@endpush
@endsection
