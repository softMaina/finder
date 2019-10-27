<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta id="app-url" name="app-url" content="{{ request()->root() }}" />
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="images/favicon.png')}}">
    <!-- Bootstrap core CSS -->
    <link href="{{asset('templates/osahan-property/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Material Design Icons -->
    <link href="{{asset('templates/osahan-property/vendor/icons/css/materialdesignicons.min.css')}}" media="all"
        rel="stylesheet" type="text/css" />
    <link href="{{asset('templates/osahan-property/css/osahan.css')}}" rel="stylesheet">
    @yield('styles')
</head>

<body>
    <div id="app">
        <!-- Top Navbar -->
        @include('layouts.includes.navbar')
        <!-- End Top Navbar -->
        <!-- Navbar -->
        @include('layouts.includes.header')
        <!-- End Navbar -->
        @yield('content')
        <!-- Footer -->
        <section class="section-padding footer bg-white border-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <h4 class="mb-5 mt-0"><a class="logo" href="index.html"><img
                                    src="{{asset('templates/osahan-property/img/logo.png')}}" alt="osahan logo"></a>
                        </h4>
                        <p>Sarit Centre, Nairobi, Kenya</p>
                        <p class="mb-0"><a class="text-dark" href="#">+254 705 571 314</a></p>
                        <p class="mb-0"><a class="text-success" href="#">shopfinder@gmail.com</a></p>
                        <p class="mb-0"><a class="text-primary" href="#">www.shopfinder.com</a></p>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <h6 class="mb-4">HOME</h6>
                        <ul>
                            <li><a href="{{route('index')}}">Home</a></li>

                            <ul>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <h6 class="mb-4">ABOUT US</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <ul>
                    </div>
                    <div class="col-lg-2 col-md-2">
                        <h6 class="mb-4">CONTACT US</h6>
                        <ul>
                            <li><a href="#">Contact Us</a></li>

                            <ul>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <h6 class="mb-4">NEWSLETTER</h6>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Email Address..."
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button"><i
                                        class="mdi mdi-arrow-right"></i></button>
                            </div>
                        </div>
                        <p class="text-info newsletter-info"><i class="mdi mdi-email-variant"></i> Get the most recent
                            updates
                            from our site and be updated your self...</p>
                        <h6 class="mb-3 mt-4">GET IN TOUCH</h6>
                        <div class="footer-social">
                            <a class="btn-facebook" href="#"><i class="mdi mdi-facebook"></i></a>
                            <a class="btn-twitter" href="#"><i class="mdi mdi-twitter"></i></a>
                            <a class="btn-instagram" href="#"><i class="mdi mdi-instagram"></i></a>
                            <a class="btn-whatsapp" href="#"><i class="mdi mdi-whatsapp"></i></a>
                            <a class="btn-messenger" href="#"><i class="mdi mdi-facebook-messenger"></i></a>
                            <a class="btn-google" href="#"><i class="mdi mdi-google"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Footer -->
        <!-- Copyright -->
        <section class="pt-4 pb-4 text-center">
            <p class="mt-0 mb-0">© Copyright 2019 <strong class="text-dark">Osahan Property</strong>. All Rights
                Reserved
            </p>

        </section>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{asset('templates/osahan-property/js/custom.js')}}"></script>
    <script src="{{asset('templates/osahan-property/js/contact_me.js')}}"></script>
    <!-- Do not edit these files! In order to set the email address and subject line for the contact form go to the bin/contact_me.php file. -->
    <script src="{{asset('templates/osahan-property/js/jqBootstrapValidation.js')}}"></script>
    @yield('scripts')
</body>

</html>
