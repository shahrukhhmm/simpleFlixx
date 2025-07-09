@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Pharmacies</h4>
                    <!-- Form for Add/Edit -->
                    <form id="pharmacyForm" action="{{ route('admin.pharmacies.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" id="method" value="POST">
                        <input type="hidden" name="id" id="pharmacyId">
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
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep unchanged" {{ !isset($pharmacy) ? 'required' : '' }}>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
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
                                <label for="tel_no">Telephone Number</label>
                                <input type="text" class="form-control" id="tel_no" name="tel_no" placeholder="e.g., +1234567890">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="second_address">Second Address</label>
                                <input type="text" class="form-control" id="second_address" name="second_address" placeholder="e.g., 123 Backup St">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fax_no">Fax Number</label>
                                <input type="text" class="form-control" id="fax_no" name="fax_no" placeholder="e.g., +1234567890">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Add Pharmacy</button>
                        <button type="button" class="btn btn-secondary" id="resetBtn">Reset</button>
                    </form>
                </div>
            </div>
            <!-- DataTable -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pharmacy List</h4>
                    <table id="pharmacyTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>State</th>
                                <th>Status</th>
                                <th>Telephone Number</th>
                                <th>Second Address</th>
                                <th>Fax Number</th>
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
    var table = $('#pharmacyTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.pharmacies.get') }}',
        columns: [
            { data: 'id', name: 'users.id' },
            { data: 'name', name: 'users.name' },
            { data: 'email', name: 'users.email' },
            { data: 'phone', name: 'users.phone' },
            { data: 'state', name: 'users.state' },
            { data: 'status', name: 'users.status' },
            { data: 'tel_no', name: 'pharmacy_details.tel_no' },
            { data: 'second_address', name: 'pharmacy_details.second_address' },
            { data: 'fax_no', name: 'pharmacy_details.fax_no' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Form submission
    $('#pharmacyForm').on('submit', function(e) {
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
                $('#pharmacyId').val('');
                $('#submitBtn').text('Add Pharmacy');
                $('#password').attr('required', true);
                alert(response.success);
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || xhr.responseJSON.error || 'An error occurred'));
            }
        });
    });

    // Edit button click
    $(document).on('click', '.edit-pharmacy', function() {
        var id = $(this).data('id');
        $.ajax({
            url: '{{ route('admin.pharmacies.edit', ':id') }}'.replace(':id', id),
            type: 'GET',
            success: function(response) {
                $('#name').val(response.name);
                $('#email').val(response.email);
                $('#phone').val(response.phone);
                $('#state').val(response.state);
                $('#status').val(response.status);
                $('#tel_no').val(response.tel_no);
                $('#second_address').val(response.second_address);
                $('#fax_no').val(response.fax_no);
                $('#pharmacyId').val(response.id);
                $('#method').val('PUT');
                $('#password').val('').removeAttr('required');
                $('#pharmacyForm').attr('action', '{{ route('admin.pharmacies.update', ':id') }}'.replace(':id', id));
                $('#submitBtn').text('Update Pharmacy');
            },
            error: function(xhr) {
                alert('Error: ' + (xhr.responseJSON.message || 'An error occurred'));
            }
        });
    });

    // Delete button click
    $(document).on('click', '.delete-pharmacy', function() {
        if (confirm('Are you sure you want to delete this pharmacy?')) {
            var id = $(this).data('id');
            $.ajax({
                url: '{{ route('admin.pharmacies.destroy', ':id') }}'.replace(':id', id),
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
        $('#pharmacyForm').trigger('reset');
        $('#method').val('POST');
        $('#pharmacyId').val('');
        $('#password').attr('required', true);
        $('#pharmacyForm').attr('action', '{{ route('admin.pharmacies.store') }}');
        $('#submitBtn').text('Add Pharmacy');
    });
});
</script>
@endpush
@endsection
