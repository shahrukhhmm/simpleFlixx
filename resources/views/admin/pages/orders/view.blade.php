@extends('admin.layout.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">Manage Orders</h4>
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'customer')
                        <a href="{{ route('order.add') }}" class="btn btn-primary">Add Order</a>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Order List</h4>
                    <div class="table-responsive">
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
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name }}</td>
                                    <td>{{ $order->user->email }}</td>
                                    <td>{{ $order->created_at }}</td>
                                    <td>{{ $order->updated_at }}</td>
                                    <td>
                                        @if(Auth::user()->role == 'pharmacy')
                                            <a href="{{ route('order.show.pharmacy', $order->id) }}" class="btn btn-sm btn-info">View Details</a>
                                        @else
                                            <a href="{{ route('order.show', $order->id) }}" class="btn btn-sm btn-info">View Details</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
    var table = $('#orderTable').DataTable();

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
});
</script>
@endpush
@endsection
