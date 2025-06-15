<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
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
        }

        .contact-banner {
            background: url('{{ asset('images/contact-banner.jpg') }}') center/cover no-repeat;
            min-height: 450px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-banner h1 {
            color: #fff;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .contact-section {
            padding: 60px 0;
        }

        .contact-form, .contact-info {
            background: #fff;
            border-radius: 30px !important;
            padding: 32px;
            box-shadow: 0 0 30px rgba(0, 0, 0, .2);
            height: 450px;
            overflow: auto;
        }

        .contact-info h4, .contact-form h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 13px 20px;
            background: #eee;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 16px;
            color: #333;
            font-weight: 500;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #7494ec;
            border-width: 3px;
            border-style: solid;
        }

        textarea.form-control {
            resize: none;
            height: 120px;
        }

        .btn {
            height: 48px;
            background: #7494ec;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #fff;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-content: center;
            justify-content: center;
            align-items: center;
            padding: 0 30px;
        }

        .btn:hover {
            background: #5a7de0;
            transform: translateY(-2px);
        }

        .contact-info strong {
            color: #333;
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .contact-info div {
            color: #666;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="animsition">
    @include('layouts.sidebar')

    <!-- Banner Section -->
    <div class="contact-banner mb-5" style="background-image: url('{{ asset('images/blog-04.jpg') }}'); display: block;">
        <div class="container h-full" style="height: 450px !important;">
            <div class="flex-col-l-m h-full p-b-30 respon5">
                <h2 class="ltext-201" style="display: flex; justify-content: center; align-items: center; width: 100%; color: #fff; font-family: Poppins !important;">Contact Us</h2>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <section class="contact-section container">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="contact-form">
                    <h4>Send Us a Message</h4>
                    <form method="POST" action="#">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn">Submit</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-info">
                    <h4>Contact Information</h4>
                    <div class="mb-3">
                        <strong>Address:</strong>
                        <div>SPU, Dier Ali, Ghabagheb, DR 10018</div>
                    </div>
                    <div class="mb-3">
                        <strong>Let's Talk:</strong>
                        <div>(+963) 99 276 2770 / (+963) 98 879 7331</div>
                    </div>
                    <div>
                        <strong>Sale Support:</strong>
                        <div>info@cozastore.com</div>
                    </div>
                </div>
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
