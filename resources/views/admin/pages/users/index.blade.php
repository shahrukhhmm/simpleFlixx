@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Customers</h4>
                    <!-- Form for Add/Edit -->
                    <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <input type="hidden" name="id" id="userId">
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
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep unchanged" {{ !isset($user) ? 'required' : '' }}>
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
                        <button type="submit" class="btn btn-primary" id="submitBtn">Add Customer</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </form>
                </div>
            </div>
            <!-- DataTable -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Customer List</h4>
                    <div style="overflow-x: auto; width: 100%;">
                    <table id="userTable" class="table table-bordered table-striped">
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
    var table = $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.users.get') }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            { data: 'date_of_birth', name: 'date_of_birth' },
            { data: 'sex', name: 'sex' },
            { data: 'state', name: 'state' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Form submission
    $('#userForm').on('submit', function(e) {
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
                $('#userId').val('');
                $('#submitBtn').text('Add Customer');
                $('#password').attr('required', true);
                alert(response.success);
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || xhr.responseJSON.error || 'An error occurred'));
            }
        });
    });

    // Edit button click
    $(document).on('click', '.edit-user', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('admin.users.edit', ':id') }}'.replace(':id', id),
            type: 'GET',
            success: function(response) {
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#phone').val(response.phone);
                $('#date_of_birth').val(response.date_of_birth);
                $('#sex').val(response.sex);
                $('#state').val(response.state);
                $('#status').val(response.status);
                $('#userId').val(response.id);
                $('#method').val('PUT');
                $('#password').val('').removeAttr('required');
                $('#userForm').attr('action', '{{ route('admin.users.update', ':id') }}'.replace(':id', id));
                $('#submitBtn').text('Update Customer');
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred'));
            }
        });
    });

    // Delete button click
    $(document).on('click', '.delete-user', function() {
        if (confirm('Are you sure you want to delete this customer?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route('admin.users.destroy', ':id') }}'.replace(':id', id),
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
        $('#userForm').trigger('reset');
        $('#method').val('POST');
        $('#userId').val('');
        $('#password').attr('required', true);
        $('#userForm').attr('action', '{{ route('admin.users.store') }}');
        $('#submitBtn').text('Add Customer');
    });
});
</script>
@endpush
@endsection
