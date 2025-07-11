<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-name" content="quixlab" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Simple Fix</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.svg') }}">
    <link href="{{ asset('adminAssets/plugins/pg-calendar/css/pignose.calendar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminAssets/plugins/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminAssets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">
    <link href="{{ asset('adminAssets/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @stack('styles')
</head>
<body>
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>

    <div id="main-wrapper">
        @include('admin.partials.nav-header')
        @include('admin.partials.header')
        @include('admin.partials.sidebar')

        <div class="content-body">
            @yield('content')
        </div>

        @include('admin.partials.footer')
    </div>

    <script src="{{ asset('adminAssets/plugins/common/common.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/custom.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/settings.js') }}"></script>
    <script src="{{ asset('adminAssets/js/gleek.js') }}"></script>
    <script src="{{ asset('adminAssets/js/styleSwitcher.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/circle-progress/circle-progress.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/d3v3/index.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/topojson/topojson.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/datamaps/datamaps.world.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/morris/morris.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/pg-calendar/js/pignose.calendar.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/chartist/js/chartist.min.js') }}"></script>
    <script src="{{ asset('adminAssets/plugins/chartist-plugin-tooltips/js/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('adminAssets/js/dashboard/dashboard-1.js') }}"></script>


      <script>
        $(document).ready(function() {
            $('.detail-btn').on('click', function() {
                var orderId = $(this).data('id');
                $.ajax({
                    url: '{{ route("admin.orders.details", ":id") }}'.replace(':id', orderId),
                    method: 'GET',
                    success: function(response) {
                        alert('Order Details: ' + JSON.stringify(response));
                    },
                    error: function(xhr, status, error) {
                        alert('Error fetching order details: ' + error);
                    }
                });
            });

            $('#orderForm').on('submit', function(event) {
                const step = parseInt($('input[name="step"]').val() ?? 1);
                if (step === 11) {
                    const cardNumber = $('input[name="card_number"]');
                    const expiryDate = $('input[name="expiry_date"]');
                    const cvv = $('input[name="cvv"]');
                    const cardholderName = $('input[name="cardholder_name"]');

                    if (!cardNumber.length || !cardNumber.val().match(/\d{16}/)) {
                        alert('Card number must be 16 digits.');
                        event.preventDefault();
                        return false;
                    }
                    if (!expiryDate.length || !expiryDate.val() || !expiryDate.val().match(/(0[1-9]|1[0-2])\/[0-9]{2}/)) {
                        alert('Expiry date must be in MM/YY format (e.g., 12/25).');
                        event.preventDefault();
                        return false;
                    }
                    if (!cvv.length || !cvv.val().match(/\d{3}/)) {
                        alert('CVV must be 3 digits.');
                        event.preventDefault();
                        return false;
                    }
                    if (!cardholderName.length || !cardholderName.val().trim()) {
                        alert('Cardholder name is required.');
                        event.preventDefault();
                        return false;
                    }
                }
                console.log('Submitting form for step:', step);
                console.log('Form data:', $(this).serialize());
            });

            function updateDateTime() {
                const now = new Date();
                const options = { hour: '2-digit', minute: '2-digit', hour12: true, timeZone: 'Asia/Karachi' };
                const timeString = now.toLocaleTimeString('en-US', options);
                const day = now.toLocaleDateString('en-US', { weekday: 'long' });
                $('#current-date-time').text(`Current Date & Time: ${day}, ${timeString} PKT`);
            }
            updateDateTime();
            setInterval(updateDateTime, 1000);
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const options = { hour: '2-digit', minute: '2-digit', hour12: true, timeZone: 'Asia/Karachi' };
            const timeString = now.toLocaleTimeString('en-US', options);
            const day = now.toLocaleDateString('en-US', { weekday: 'long' });
            // document.getElementById('current-date-time')?.textContent = `Today's date and time is ${timeString} PKT on ${day}, June 28, 2025`;
        });

        // Initialize Datamap with error handling
        document.addEventListener('DOMContentLoaded', function() {
            const mapContainer = document.getElementById('map');
            if (mapContainer) {
                new Datamap({
                    element: mapContainer,
                    projection: 'mercator',
                    fills: { defaultFill: '#f0f0f0' },
                    data: {}
                });
            } else {
                console.warn('Map container (#map) not found, skipping Datamap initialization.');
            }
        });
    </script>

    <style>
        @media (max-width: 1200px) {
            .content-body {
                padding-left: 70px;
            }
        }
    </style>
    @stack('scripts')
</body>
</html>
