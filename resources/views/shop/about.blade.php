<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Us</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/linearicons-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <style>
        .about-hero { background: url('{{ asset('images/banner-06.jpg') }}') center/cover no-repeat; min-height: 350px; color: #cccccc; display: flex; align-items: center; justify-content: center; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); }
        .about-hero h1 { font-size: 3rem; font-weight: bold; }
        .about-section { padding: 60px 0; }
        .about-img { border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
    </style>
</head>
<body class="animsition">
    @include('layouts.sidebar')

    <!-- Hero Section -->
    <div class="about-hero">
        <h1>About CozaStore</h1>
    </div>
    <!-- About Details Section -->
    <section class="about-section container">
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('images/about-01.jpg') }}" alt="Our Store" class="img-fluid about-img">
            </div>
            <div class="col-md-6">
                <h2>Who We Are</h2>
                <p class="lead">CozaStore is a modern e-commerce platform dedicated to providing the latest fashion trends for men and women. Our mission is to deliver high-quality products, exceptional customer service, and a seamless shopping experience.</p>
                <ul>
                    <li>Wide range of products and categories</li>
                    <li>Secure and easy checkout process</li>
                    <li>Fast shipping and reliable support</li>
                </ul>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 order-md-2 mb-4 mb-md-0">
                <img src="{{ asset('images/about-02.jpg') }}" alt="Our Team" class="img-fluid about-img">
            </div>
            <div class="col-md-6 order-md-1">
                <h2>Our Vision</h2>
                <p>We believe in making fashion accessible to everyone. Our team works tirelessly to curate collections that inspire confidence and style. At CozaStore, we value innovation, quality, and customer satisfaction above all else.</p>
            </div>
        </div>
    </section>
    <!-- Footer -->
    @include('layouts.footer')
    <!-- Scripts -->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
