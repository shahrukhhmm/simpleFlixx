@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Orders</h4>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order List</h4>
                    <table id="orderTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Updated At</th>
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

<!-- Modal -->
<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="orderDetailsContent">
                <!-- Details will be loaded here via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    var table = $('#orderTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.orders.get') }}',
        columns: [
            { data: 'id', name: 'orders.id' },
            { data: 'name', name: 'users.name' },
            { data: 'email', name: 'users.email' },
            { data: 'created_at', name: 'orders.created_at' },
            { data: 'updated_at', name: 'orders.updated_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // Handle detail button click
    $(document).on('click', '.detail-btn', function() {
        const orderId = $(this).data('id');
        $.ajax({
            url: '{{ route('admin.orders.details', ':id') }}'.replace(':id', orderId),
            type: 'GET',
            success: function(response) {
                let details = '<h6>User Details</h6>';
                details += '<p><strong>Name:</strong> ' + (response.name || 'N/A') + '</p>';
                details += '<p><strong>Email:</strong> ' + (response.email || 'N/A') + '</p>';
                details += '<h6>Order Details</h6>';
                details += '<p><strong>Created At:</strong> ' + (response.created_at || 'N/A') + '</p>';
                details += '<p><strong>Updated At:</strong> ' + (response.updated_at || 'N/A') + '</p>';
                if (response.health_history) {
                    details += '<p><strong>Health History:</strong> ' + JSON.stringify(response.health_history) + '</p>';
                }
                if (response.weight_management_history) {
                    details += '<p><strong>Weight Management History:</strong> ' + JSON.stringify(response.weight_management_history) + '</p>';
                }
                if (response.medication_requests) {
                    details += '<p><strong>Medication Requests:</strong> ' + JSON.stringify(response.medication_requests) + '</p>';
                }
                if (response.add_ons) {
                    details += '<p><strong>Add-ons:</strong> ' + JSON.stringify(response.add_ons) + '</p>';
                }
                if (response.shipping_options) {
                    details += '<p><strong>Shipping Options:</strong> ' + JSON.stringify(response.shipping_options) + '</p>';
                }
                if (response.consent) {
                    details += '<p><strong>Consent:</strong> ' + JSON.stringify(response.consent) + '</p>';
                }
                if (response.payment_details) {
                    details += '<p><strong>Payment Details:</strong> ' + JSON.stringify(response.payment_details) + '</p>';
                }
                $('#orderDetailsContent').html(details);
                $('#orderDetailModal').modal('show');
            },
            error: function(xhr) {
                alert('Failed to load order details: ' + (xhr.responseJSON.message || 'An error occurred'));
            }
        });
    });

    // Remove edit and delete functionality
    $(document).off('click', '.edit-order');
    $(document).off('click', '.delete-order');
});
</script>
@endpush
@endsection
