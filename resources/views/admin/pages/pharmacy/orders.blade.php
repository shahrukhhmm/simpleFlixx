@extends('admin.layout.app')

@section('content')
<div class="container py-4">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6 border">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">Double G Medical PLLC</h2>
            <!-- Download PDF Button -->
            <button id="downloadPdfBtn" class="btn btn-primary">
                <i class="fa fa-download"></i> Download PDF
            </button>
        </div>
        <div id="order-details-pdf">
            <table class="table table-bordered w-full mb-4">
                <tbody>
                    <tr>
                        <td class="font-semibold w-1/3">Date of Service:</td>
                        <td>{{ $order->created_at ? $order->created_at->format('m/d/Y') : '' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Bill To:</td>
                        <td>SimpleFix</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Patient Name:</td>
                        <td>{{ $order->user->name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Date of Birth:</td>
                        <td>
                            {{ Carbon\Carbon::parse($order->user->date_of_birth)->format('m/d/Y') ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Shipping Address:</td>
                        <td>
                            @php $so = $order->shipping_options ?? []; @endphp
                            {{ $so['shipping_address1'] ?? '' }}<br>
                            {{ $so['shipping_address2'] ?? '' ? $so['shipping_address2'].'<br>' : '' }}
                            {{ $so['shipping_city'] ?? '' }}, {{ $so['shipping_state'] ?? '' }} {{ $so['shipping_zip'] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Phone Number:</td>
                        <td>{{ $order->user->phone ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Email:</td>
                        <td>{{ $order->user->email ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Prescribed Rx:</td>
                        <td>
                            @php
                                $rx = $order->medication_requests ?? '';
                                if (is_array($rx)) {
                                    $rx = implode(', ', $rx);
                                }
                            @endphp
                            {{ $rx }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Add-ons:</td>
                        <td>
                            @php
                                $addons = $order->add_ons ?? [];
                                if (is_array($addons)) {
                                    echo implode(', ', array_filter($addons));
                                } else {
                                    echo $addons;
                                }
                            @endphp
                        </td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Doctor Notes:</td>
                        <td>{{ $order->note ?? '' }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight:bold; color:#222; white-space:normal; word-break:break-all; padding-top:10px;">
                            Prescriber: {{ optional($order->doctor)->name ?? 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jsPDF and html2canvas CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.getElementById('downloadPdfBtn').addEventListener('click', function () {
        const { jsPDF } = window.jspdf;
        const pdf = new jsPDF('p', 'pt', 'a4');
        const element = document.getElementById('order-details-pdf');
        html2canvas(element, { scale: 2 }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgProps = pdf.getImageProperties(imgData);
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('order-details.pdf');
        });
    });
</script>
@endpush
