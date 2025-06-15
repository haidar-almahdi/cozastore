<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
            text-decoration: none;
            list-style: none;
        }

        body {
            background: linear-gradient(90deg, #e2e2e2, #c9d6ff);
        }

        .container {
            /* background: #fff; */
            border-radius: 30px;
            /* box-shadow: 0 0 30px rgba(0, 0, 0, .2); */
            padding: 20px;
        }

        .categories-container {
            background: #fff;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, .2);
            padding: 10px;
        }

        .btn-primary {
            background: #7494ec;
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: #5a7de8;
        }

        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-title {
            margin-bottom: 0px !important;
        }
        .card-text {
            margin-bottom: 0.75rem !important;
        }
    </style>
</head>
<body class="animsition">
    @include('layouts.sidebar')
    <!-- Slider Section -->
    <section class="section-slide">
        <div class="wrap-slick1 position-relative" style="overflow:hidden; height: 700px !important;">
            <div id="customSlider">
                <div class="custom-slide" style="background-image: url('{{ asset('images/slide-01.jpg') }}'); display: block; height: 700px !important;">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <span class="ltext-101 cl2 respon2">Women Collection 2025</span>
                            <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">New Season</h2>
                            <a href="{{ route('shop.products.index') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="custom-slide" style="background-image: url('{{ asset('images/slide-02.jpg') }}'); display: none; height: 700px !important;">
                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <span class="ltext-101 cl2 respon2">Men Collection 2025</span>
                            <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">New Arrivals</h2>
                            <a href="{{ route('shop.products.index') }}" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            let currentSlide = 0;
            const slides = document.querySelectorAll('#customSlider .custom-slide');
            setInterval(() => {
                slides[currentSlide].style.display = 'none';
                currentSlide = (currentSlide + 1) % slides.length;
                slides[currentSlide].style.display = 'block';
            }, 5000);
        </script>
    </section>
    <!-- Categories Section -->
    <section class="categories-container py-5">
        <h2 class="mb-4 text-center">Categories</h2>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" class="card-img-top" alt="{{ $category->name }}">
                        @else
                            <img src="{{ asset('images/default-category.jpg') }}" class="card-img-top" alt="{{ $category->name }}">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">{{ $category->description }}</p>
                            <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}" class="btn btn-primary mt-auto">View Products</a>
                        </div>
                    </div>
                </div>
            @endforeach
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
