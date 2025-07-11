@extends('admin.layout.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2 class="text-2xl font-bold text-purple-700 mb-2 flex items-center"><i class="fas fa-clinic-medical mr-2"></i>Pharmacy Dashboard</h2>
        <p class="text-gray-600">Welcome to your dashboard. Here you can see an overview of your customers and approved orders.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="card shadow rounded-lg p-4 flex items-center bg-white">
            <div class="rounded-full bg-blue-100 text-blue-600 p-4 mr-4">
                <i class="fas fa-users fa-2x"></i>
            </div>
            <div>
                <div class="text-lg font-semibold">Total Customers</div>
                <div class="text-3xl font-bold">{{ $totalCustomers }}</div>
            </div>
        </div>
        <div class="card shadow rounded-lg p-4 flex items-center bg-white">
            <div class="rounded-full bg-green-100 text-green-600 p-4 mr-4">
                <i class="fas fa-check-circle fa-2x"></i>
            </div>
            <div>
                <div class="text-lg font-semibold">Approved Orders</div>
                <div class="text-3xl font-bold">{{ $approvedOrders }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
