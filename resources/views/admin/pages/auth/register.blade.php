<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign Up</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('adminAssets/images/logo/logo.png')}}">
    <link href="{{asset('adminAssets/css/style.css')}}" rel="stylesheet">
</head>

<body class="h-100" style="background-image: linear-gradient(
    rgba(255, 255, 255, 0.2),rgba(255, 255, 255, 0.2)),url('{{asset('images/background-auth.jpeg')}}'); background-position: center;background-repeat:no-repeat;background-size:cover">

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

    <div class="login-form-bg h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100">
                <div class="col-xl-6">
                    <div class="form-input-content">
                        <div class="card login-form mb-0">
                            <div class="card-body pt-5">
                                <a class="text-center" href="/"> <h3 style="color:black !important; text-transform:uppercase;">Simple Fix <br> (Customer Registration form)</h3></a>

                                @if ($errors->any())
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position:fixed; top:15px; right:15px; z-index:10">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register.post') }}" style="justify-content: center; display: flex; flex-direction: column; gap: 10px;">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control bg-transparent" placeholder="Full Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control bg-transparent" placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control bg-transparent" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control bg-transparent" placeholder="Phone Number">
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="date_of_birth" class="form-control bg-transparent" placeholder="Date of Birth">
                                    </div>
                                    <div class="form-group">
                                        <select name="sex" class="form-control bg-transparent">
                                            <option value="">Select Sex</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="state" class="form-control bg-transparent" placeholder="State">
                                    </div>
                                    <input type="hidden" name="role" value="customer">
                                    <input type="hidden" name="status" value="pending">
                                    <button type="submit" class="btn btn-primary">Sign Up</button>
                                </form>
                                <p>Already have an account? <a class="btn border-0" href="{{ route('login') }}">Login</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
