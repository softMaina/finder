<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="RealEstate Admin Dashboard template, UI kit, Bootstrap 4x">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta id="app-url" name="app-url" content="{{ request()->root() }}"/>

    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{asset('templates/oreo/light/favicon.ico')}}" type="image/x-icon"> <!-- Favicon-->
    <link rel="stylesheet" href="{{asset('templates/oreo/assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('templates/oreo/light/assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('templates/oreo/light/assets/css/authentication.css')}}">
    <link rel="stylesheet" href="{{asset('templates/oreo/light/assets/css/color_skins.css')}}">
    @yield('styles')
</head>

<body class="theme-blue authentication sidebar-collapse">
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top navbar-transparent">
    <div class="container">
        <div class="navbar-translate n_logo">
            <a class="navbar-brand" href="javascript:void(0);" title="" target="_blank">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </button>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Follow us on Twitter" href="javascript:void(0);" target="_blank">
                        <i class="zmdi zmdi-twitter"></i>
                        <p class="d-lg-none d-xl-none">Twitter</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Like us on Facebook" href="javascript:void(0);" target="_blank">
                        <i class="zmdi zmdi-facebook"></i>
                        <p class="d-lg-none d-xl-none">Facebook</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" title="Follow us on Instagram" href="javascript:void(0);" target="_blank">
                        <i class="zmdi zmdi-instagram"></i>
                        <p class="d-lg-none d-xl-none">Instagram</p>
                    </a>
                </li>
                @yield('authbutton')
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
@yield('content')

<!-- Jquery Core Js -->
<script src="{{asset('templates/oreo/light/assets/bundles/libscripts.bundle.js')}}"></script>
<script src="{{asset('templates/oreo/light/assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->

<script>
    $(".navbar-toggler").on('click', function () {
        $("html").toggleClass("nav-open");
    });
    //=============================================================================
    $('.form-control').on("focus", function () {
        $(this).parent('.input-group').addClass("input-group-focus");
    }).on("blur", function () {
        $(this).parent(".input-group").removeClass("input-group-focus");
    });
</script>
</body>
</html>
