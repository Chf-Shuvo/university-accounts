<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8">
    <title>{{ env('APP_NAME') }}</title>

    <!-- Site favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('backend/src/images/baiust_logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('backend/src/images/baiust_logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/src/images/baiust_logo.png') }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/core.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/vendors/styles/style.css') }}">
</head>

<body class="login-page">
    <div class="login-header box-shadow">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <div class="brand-logo">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('backend/src/images/baiust_logo.png') }}" height="80" width="50" alt="">
                </a>
            </div>
        </div>
    </div>
    <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">
                            <strong>Attention!</strong> Credentials do not match.
                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-lg-7">
                    <img src="{{ asset('backend/vendors/images/login-page-banner.png') }}" alt="">
                </div>
                <div class="col-md-6 col-lg-5">
                    <div class="login-box bg-white box-shadow border-radius-10">
                        <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group custom">
                                <input type="text" class="form-control form-control-lg"
                                    placeholder="email@baiust.edu.bd" name="email">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                </div>
                            </div>
                            <div class="input-group custom">
                                <input type="password" class="form-control form-control-lg" placeholder="**********"
                                    name="password">
                                <div class="input-group-append custom">
                                    <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                </div>
                            </div>
                            <div class="row pb-30">
                                <div class="col-12">
                                    <div class="forgot-password"><a href="{{ route('password.request') }}"
                                            class="text-danger">Forgot Password</a></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="input-group mb-0">
                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- js -->
    <script src="{{ asset('backend/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('backend/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('backend/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('backend/vendors/scripts/layout-settings.js') }}"></script>
    @include('sweetalert::alert')

</body>

</html>
