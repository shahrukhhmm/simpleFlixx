<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> Login </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('adminAssets/images/logo/logo.png')}}">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{asset('adminAssets/css/style.css')}}" rel="stylesheet">

    <style>
        .image-container {
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center; /* Center vertically */
            overflow: hidden; /* Hide overflow to crop sides */
            width: 100%; /* Full width of the parent */
            height: 100%; /* Full height of the parent */
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Crop to fit, maintaining aspect ratio */
            object-position: center; /* Center the image */
        }
    </style>

</head>

<body class="h-100" style="background-image: linear-gradient(
    rgba(255, 255, 255, 0.2),rgba(255, 255, 255, 0.2)),url('{{asset("images/background-auth.jpeg")}}'); background-position: center;background-repeat:no-repeat;background-size:cover">

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <div class="row" style="height: 100vh; margin: 0;padding: 0;">
        <div class="col-md-6" >

            <div class="row justify-content-center h-100">
                <div class="col-md-6 col-11" >
                    <div class="form-input-content" >
                        <div class=" mb-0">
                            <div class="pt-5">
                                <a class="text-center d-flex justify-content-center" href="/">
                                    <img src="{{ asset('logo.svg') }}" alt="" height="100" width="100" style="border-radius: 50%; margin-bottom: 20px; ">
                                </a>

                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position:fixed; top:15px; right:15px; z-index:10">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position:fixed; top:15px; right:15px; z-index:10">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="position:fixed; top:15px; right:15px; z-index:10">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login.post') }}" style="justify-content: center; display: flex; flex-direction: column; gap: 10px;">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control bg-transparent
                                        " placeholder="email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control bg-transparent" placeholder="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary ">Login</button>
                                </form>
                                <p> Don't have an account? <a class="btn  border-0" href="{{ route('register') }}">Register</a></p>

                                <p style="color: #666; text-align: center; margin-top: 20px;">Help · Terms of Service · Privacy & Policy</p>
                            </div>

                             <p style="color: #666; text-align: center;">© Simple Flix</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-6 image-container">
            {{-- <img src="{{asset('adminAssets/images/womancallcenter.jpg')}}" alt="Woman Call Center"> --}}
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{asset('adminAssets/plugins/common/common.min.js')}}"></script>
    <script src="{{asset('adminAssets/js/custom.min.js')}}"></script>
    <script src="{{asset('adminAssets/js/settings.js')}}"></script>
    <script src="{{asset('adminAssets/js/gleek.js')}}"></script>
    <script src="{{asset('adminAssets/js/styleSwitcher.js')}}"></script>
</body>
</html>
