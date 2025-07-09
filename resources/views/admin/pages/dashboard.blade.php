@extends('admin.layout.app')

<style>
    .custom-details-panel {
        background: rgba(255, 255, 255);
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0);
    }
    .info-image {
        border-radius: 10px;
    }
    .btn-outline-light {
        border-color: #ffffff;
        color: #ffffff;
    }
    .btn-outline-light:hover {
        background-color: #ffffff;
        color: #000000;
    }
</style>

@section('content')

   @if(Auth::user()->role == 'admin')
    <div class="container-fluid mt-3" style="background: url({{ asset('adminAssets/images/user/7.jpg') }}) no-repeat center center; background-size: cover;">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <div class="ml-3">
                            <h6 class="mb-1 text-muted">Total Customers</h6>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ @$totalCustomers }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                        <div class="ml-3">
                            <h6 class="mb-1 text-muted">Total Doctors</h6>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ @$totalDoctors }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card shadow border-0">
                    <div class="card-body d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="fas fa-tags fa-2x"></i>
                        </div>
                        <div class="ml-3">
                            <h6 class="mb-1 text-muted">Total Pharmacies</h6>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ @$totalPharmacies }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pb-0 d-flex justify-content-between">
                                <div>
                                    <h4 class="mb-1">Product Sales</h4>
                                    <p>Total Earnings of the Month</p>
                                    <h3 class="m-0">$ 12,555</h3>
                                </div>
                                <div>
                                    <ul>
                                        <li class="d-inline-block mr-3"><a class="text-dark" href="#">Day</a></li>
                                        <li class="d-inline-block mr-3"><a class="text-dark" href="#">Week</a></li>
                                        <li class="d-inline-block"><a class="text-dark" href="#">Month</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-wrapper">
                                <canvas id="chart_widget_2"></canvas>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div class="w-100 mr-2">
                                        <h6>Pixel 2</h6>
                                        <div class="progress" style="height: 6px">
                                            <div class="progress-bar bg-danger" style="width: 40%"></div>
                                        </div>
                                    </div>
                                    <div class="ml-2 w-100">
                                        <h6>iPhone X</h6>
                                        <div class="progress" style="height: 6px">
                                            <div class="progress-bar bg-primary" style="width: 80%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order Summary</h4>
                            <div id="morris-bar-chart"></div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-widget">
                        <div class="card-body">
                            <h5 class="text-muted">Order Overview </h5>
                            <h2 class="mt-4">5680</h2>
                            <span>Total Revenue</span>
                            <div class="mt-4">
                                <h4>30</h4>
                                <h6>Online Order <span class="pull-right">30%</span></h6>
                                <div class="progress mb-3" style="height: 7px">
                                    <div class="progress-bar bg-primary" style="width: 30%;" role="progressbar"><span class="sr-only">30% Order</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4>50</h4>
                                <h6 class="m-t-10 text-muted">Offline Order <span class="pull-right">50%</span></h6>
                                <div class="progress mb-3" style="height: 7px">
                                    <div class="progress-bar bg-success" style="width: 50%;" role="progressbar"><span class="sr-only">50% Order</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <h4>20</h4>
                                <h6 class="m-t-10 text-muted">Cash On Develery <span class="pull-right">20%</span></h6>
                                <div class="progress mb-3" style="height: 7px">
                                    <div class="progress-bar bg-warning" style="width: 20%;" role="progressbar"><span class="sr-only">20% Order</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card">
                        <div class="card-body px-0">
                            <h4 class="card-title px-4 mb-3">Todo</h4>
                            <div class="todo-list">
                                <div class="tdl-holder">
                                    <div class="tdl-content">
                                        <ul id="todo_list">
                                            <li><label><input type="checkbox"><i></i><span>Get up</span><a href='#' class="ti-trash"></a></label></li>
                                            <li><label><input type="checkbox" checked><i></i><span>Stand up</span><a href='#' class="ti-trash"></a></label></li>
                                            <li><label><input type="checkbox"><i></i><span>Don't give up the fight.</span><a href='#' class="ti-trash"></a></label></li>
                                            <li><label><input type="checkbox" checked><i></i><span>Do something else</span><a href='#' class="ti-trash"></a></label></li>
                                        </ul>
                                    </div>
                                    <div class="px-4">
                                        <input type="text" class="tdl-new form-control" placeholder="Write new item and hit 'Enter'...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        <div class="row">
            <div class="col-xl-3 col-lg-6 col-sm-6 col-xxl-6">

                <div class="card">
                    <div class="chart-wrapper mb-4">
                        <div class="px-4 pt-4 d-flex justify-content-between">
                            <div>
                                <h4>Sales Activities</h4>
                                <p>Last 6 Month</p>
                            </div>
                            <div>
                                <span><i class="fa fa-caret-up text-success"></i></span>
                                <h4 class="d-inline-block text-success">720</h4>
                                <p class=" text-danger">+120.5(5.0%)</p>
                            </div>
                        </div>
                        <div>
                                <canvas id="chart_widget_3"></canvas>
                        </div>
                    </div>
                    <div class="card-body border-top pt-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul>
                                    <li>5% Negative Feedback</li>
                                    <li>95% Positive Feedback</li>
                                </ul>
                                <div>
                                    <h5>Customer Feedback</h5>
                                    <h3>385749</h3>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="chart_widget_3_1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-12 col-sm-12 col-xxl-12">
                <div class="card">
                    <div class="card-body">
                            <h4 class="card-title mb-0">Store Location</h4>
                        <div id="world-map" style="height: 470px;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @elseif(Auth::user()->role == 'customer')
    <div class="main-container mt-4 h-screen" style="background: url({{ asset('adminAssets/images/user/7.jpg') }}) no-repeat center center; background-size: cover;">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 mb-2">
                <div class="panel bg-light border-0 p-2 custom-details-panel">
                    <div class="panel-body d-flex flex-column flex-md-row align-items-center">
                        <img src="{{ asset('adminAssets/GLP-1_Squared-removebg-preview.png') }}" alt="Medication" class="img-fluid info-image" style="max-width: 200px; height: auto;">
                        <div class="ml-md-3 mt-3 mt-md-0 text-center text-md-left">
                            <h6 class="text-secondary">Suggested for you</h6>
                            <h1 class="font-weight-bold text-dark mb-2">GLP SQUARED INJECTION</h1>
                            <p class="text-light mb-3">Medical Weight management compounded medication</p>
                            <a href="{{ url('orders') }}" class="btn btn-outline-light btn-sm">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif




@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        const ctx = document.getElementById('statsChart').getContext('2d');
        const statsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Users', 'Products', 'Categories'],
                datasets: [{
                    label: 'Count',
                    data: [{{ $totalUsers }}, {{ $totalProducts }}, {{ $totalCategories }}],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',  // Blue for Users
                        'rgba(75, 192, 192, 0.6)',  // Green for Products
                        'rgba(255, 206, 86, 0.6)'   // Yellow for Categories
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            color: '#333'
                        }
                    },
                    title: {
                        display: true,
                        text: 'System Statistics',
                        color: '#333'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#333'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#333'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                }
            }
        });
    });
</script> --}}
@endpush
@endsection
