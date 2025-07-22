@extends('admin.layout.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span id="order-status-badge"
                    class="badge px-3 py-2 {{ $order->status == 'Approved' ? 'bg-green-200 text-green-800' : ($order->status == 'Rejected' ? 'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800') }}">
                    Order Status: {{ $order->status ?? 'Pending' }}
                </span>
                @if (Auth::user()->role == 'admin' || Auth::user()->role == 'doctor')
                    <button id="approve-btn" class="btn btn-success ml-2"
                        {{ $order->status == 'Approved' ? 'disabled' : '' }}><i
                            class="fas fa-check mr-1"></i>Approve</button>
                    <button id="reject-btn" class="btn btn-danger ml-2"
                        {{ $order->status == 'Rejected' ? 'disabled' : '' }}><i
                            class="fas fa-times mr-1"></i>Reject</button>
                    <button id="pending-btn" class="btn btn-warning ml-2" {{ $order->status == 'Pending' ? 'disabled' : '' }}><i class="fas fa-hourglass-half mr-1"></i>Set Pending</button>
                @endif
            </div>
        </div>
        @if(Auth::user()->role == 'admin' || Auth::user()->role == 'doctor')
        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                    class="fas fa-sticky-note mr-2 text-gray-500"></i>Note</h4>
            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                <textarea name="note" id="note" class="form-control" rows="3">{{ $order->note ?? '' }}</textarea>
            </div>
        </div>
        @endif
        <div class="card shadow-lg rounded-lg">
            <div class="card-header bg-pink-100 border-bottom-0 rounded-t-lg">
                <h3 class="card-title text-2xl font-bold text-pink-600 flex items-center">
                    <i class="fas fa-file-medical-alt mr-2"></i> Order #{{ $order->id }} Details
                </h3>
                <span class="badge bg-blue-100 text-blue-800 ml-3">Created:
                    {{ $order->created_at->format('Y-m-d H:i') }}</span>
            </div>
            <div class="card-body bg-white rounded-b-lg">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-user-circle mr-2 text-blue-500"></i>User Information</h4>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p><strong>Name:</strong> {{ $order->user->name ?? 'N/A' }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-shipping-fast mr-2 text-green-500"></i>Shipping & Billing</h4>
                        @php $so = $order->shipping_options ?? []; @endphp
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p><strong>Shipping Address:</strong> {{ $so['shipping_address1'] ?? '' }}
                                {{ $so['shipping_address2'] ?? '' }}, {{ $so['shipping_city'] ?? '' }},
                                {{ $so['shipping_state'] ?? '' }} {{ $so['shipping_zip'] ?? '' }}</p>
                            <p><strong>Billing Same as Shipping:</strong> <span
                                    class="badge {{ !empty($so['billing_same_as_shipping']) ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">{{ !empty($so['billing_same_as_shipping']) ? 'Yes' : 'No' }}</span>
                            </p>
                            @if (empty($so['billing_same_as_shipping']))
                                <p><strong>Billing Address:</strong> {{ $so['billing_address1'] ?? '' }}
                                    {{ $so['billing_address2'] ?? '' }}, {{ $so['billing_city'] ?? '' }},
                                    {{ $so['billing_state'] ?? '' }} {{ $so['billing_zip'] ?? '' }}</p>
                            @endif
                            <p><strong>Shipping Option:</strong> {{ $so['shipping_option'] ?? '' }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-heartbeat mr-2 text-pink-500"></i>Health History</h4>
                        @php $hh = $order->health_history ?? []; @endphp
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <ul class="list-disc pl-5">
                                <li><strong>Weight Loss Goals:</strong> {{ $hh['weight_loss_goals'] ?? '' }}</li>
                                <li><strong>Weight Loss Initiatives:</strong>
                                    {{ isset($hh['weight_loss_initiatives']) ? implode(', ', (array) $hh['weight_loss_initiatives']) : '' }}
                                </li>
                                <li><strong>Doctor Visit:</strong> {{ $hh['doctor_visit'] ?? '' }}</li>
                                <li><strong>Weight (lbs):</strong> {{ $hh['weight_lbs'] ?? '' }}</li>
                                <li><strong>Height:</strong> {{ $hh['height_feet'] ?? '' }} ft
                                    {{ $hh['height_inches'] ?? '' }} in</li>
                                <li><strong>Conditions:</strong> {{ $hh['conditions'] ?? '' }}</li>
                                <li><strong>Exercise Frequency:</strong> {{ $hh['exercise_frequency'] ?? '' }}</li>
                                <li><strong>Exercise Type:</strong> {{ $hh['exercise_type'] ?? '' }}</li>
                                <li><strong>Medications:</strong>
                                    {{ isset($hh['medications']) ? implode(', ', (array) $hh['medications']) : '' }}</li>
                                <li><strong>Gallbladder Issues:</strong> {{ $hh['gallbladder_issues'] ?? '' }}</li>
                                <li><strong>Pancreatitis:</strong> {{ $hh['pancreatitis'] ?? '' }}</li>
                                <li><strong>Kidney Disease:</strong> {{ $hh['kidney_disease'] ?? '' }}</li>
                                <li><strong>Sleep Apnea:</strong> {{ $hh['sleep_apnea'] ?? '' }}</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-dumbbell mr-2 text-purple-500"></i>Weight Management History</h4>
                        @php $wmh = $order->weight_management_history ?? []; @endphp
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <ul class="list-disc pl-5">
                                <li><strong>Side Effects:</strong>
                                    {{ isset($wmh['side_effects']) ? implode(', ', (array) $wmh['side_effects']) : '' }}
                                </li>
                                <li><strong>Previous Purchase:</strong> {{ $wmh['previous_purchase'] ?? '' }}</li>
                                <li><strong>Prescription Increase:</strong> {{ $wmh['prescription_increase'] ?? '' }}</li>
                                <li><strong>B12 Importance:</strong> {{ $wmh['b12_importance'] ?? '' }}</li>
                                <li><strong>Add B12:</strong> {{ $wmh['add_b12'] ?? '' }}</li>
                                <li><strong>Glycine Importance:</strong> {{ $wmh['glycine_importance'] ?? '' }}</li>
                                <li><strong>GLP1 Issues:</strong> {{ $wmh['glp1_issues'] ?? '' }}</li>
                                <li><strong>Add Nausea Med:</strong> {{ $wmh['add_nausea_med'] ?? '' }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-capsules mr-2 text-indigo-500"></i>Medication Requests</h4>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p>{{ is_array($order->medication_requests) ? implode(', ', $order->medication_requests) : $order->medication_requests }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-plus-circle mr-2 text-yellow-500"></i>Add-ons</h4>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p>{{ is_array($order->add_ons) ? implode(', ', $order->add_ons) : $order->add_ons }}</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-file-signature mr-2 text-pink-400"></i>Consent</h4>
                        @php $consent = $order->consent ?? []; @endphp
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <p><strong>Signature:</strong> {{ $consent['signature'] ?? '' }}</p>
                        </div>
                    </div>
                    @if(Auth::user()->role == 'user' || Auth::user()->role == 'admin')
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-2 flex items-center"><i
                                class="fas fa-credit-card mr-2 text-blue-400"></i>Payment Details</h4>
                        @php $pd = $order->payment_details ?? []; @endphp
                        <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                            <ul class="list-disc pl-5">
                                <li><strong>Promo Code:</strong> {{ $pd['promo_code'] ?? '' }}</li>
                                <li><strong>Card Number:</strong> {{ $pd['card_number'] ?? '' }}</li>
                                <li><strong>Expiry Date:</strong> {{ $pd['expiry_date'] ?? '' }}</li>
                                <li><strong>CVV:</strong> {{ $pd['cvv'] ?? '' }}</li>
                                <li><strong>Cardholder Name:</strong> {{ $pd['cardholder_name'] ?? '' }}</li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            function updateStatus(newStatus) {
                const note = document.getElementById('note').value;
                if (!confirm('Are you sure you want to ' + newStatus.toLowerCase() + ' this order?')) return;
                fetch("{{ url('/orders/update-status/' . $order->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                        },
                        body: JSON.stringify({
                            status: newStatus,
                            note: note
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('order-status-badge').textContent = 'Order Status: ' + newStatus;
                            document.getElementById('order-status-badge').className = 'badge px-3 py-2 ' + (newStatus ===
                                'Approved' ? 'bg-green-200 text-green-800' : (newStatus === 'Rejected' ?
                                    'bg-red-200 text-red-800' : 'bg-yellow-200 text-yellow-800'));
                            document.getElementById('approve-btn').disabled = (newStatus === 'Approved');
                            document.getElementById('reject-btn').disabled = (newStatus === 'Rejected');
                            document.getElementById('pending-btn').disabled = (newStatus === 'Pending');
                            alert('Order status updated successfully.');
                        } else {
                            alert('Failed to update status.');
                        }
                    })
                    .catch(() => alert('Failed to update status.'));
            }
            document.getElementById('approve-btn').onclick = function() {
                updateStatus('Approved');
            };
            document.getElementById('reject-btn').onclick = function() {
                updateStatus('Rejected');
            };
            document.getElementById('pending-btn').onclick = function() {
                updateStatus('Pending');
            };
        </script>
    @endpush
@endsection
