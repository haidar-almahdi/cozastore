<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Category</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        * {
            font-family: "Poppins", sans-serif;
        }

        .main-content { 
            padding: 40px 30px; 
            margin-left: 250px; 
            background: #f5f6fa !important; 
            min-height: 100vh;
        }

        body { 
            background: #f5f6fa; 
            margin: 0;
            padding: 0;
        }

        .sidebar {
            min-height: 100vh;
            background: #222d32;
            color: #fff;
            padding: 0;
        }

        .nav-bar-container { 
            display: flex; 
            flex-direction: row-reverse; 
            width: 80%; 
            justify-content: space-between; 
            align-items: center; 
        }

        .form-container {
            background: #fff;
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 0 30px rgba(0, 0, 0, .1);
            max-width: 700px;
            margin: 0 auto;
        }

        .form-container h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 30px;
            text-align: center;
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
            transition: all 0.3s ease;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px #7494ec;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-control-file {
            padding: 10px;
            background: #eee;
            border-radius: 8px;
            width: 100%;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin: 0;
        }

        .form-check-label {
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .btn {
            padding: 10px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-success {
            background: #7494ec;
            color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        .btn-success:hover {
            background: #5a7de8;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #eee;
            color: #333;
            border-style: solid;
            border-width: 1px;
        }

        .btn-secondary:hover {
            background: #555;
            transform: translateY(-2px);
        }

        .alert-danger {
            background: #ffe5e5;
            color: #d63031;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert-danger li {
            margin: 5px 0;
        }
        .btn-container {
            display: flex !important;
            align-items: center;
            gap: 15px;
        }
    </style>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm px-4">
        <div class="container-fluid justify-content-end">
            <div class="dropdown nav-bar-container">
                <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="adminDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ Auth::user()->profile_photo ?? asset('images/product-min-01.jpg') }}" alt="Admin" width="40" height="40" class="rounded-circle">
                </a>
                <div class="dropdown-menu-left" aria-labelledby="adminDropdown">
                    <a class="dropdown-item" href="{{ route('shop.home') }}">Website</a>
                </div>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                    <a class="dropdown-item" href="#">Edit Profile</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" style="position:fixed;top:0;left:0;width:250px;height:100%;background:#222d32;z-index:9999;box-shadow:2px 0 5px rgba(0,0,0,0.1);padding:30px;">
        <ul class="list-unstyled mt-5">
            <li><a href="{{ route('admin.home') }}" class="text-white font-weight-bold" style="font-size:1.2rem; padding-bottom: 0.5%">Home</a></li>
            <hr style="border-top: 2px solid rgb(255 255 255) !important;">
            <li><a href="{{ route('admin.products.index') }}" class="text-white font-weight-bold" style="font-size:1.2rem;">Products</a></li>
            <hr style="border-top: 2px solid rgb(255 255 255) !important;">
            <li><a href="{{ route('admin.categories.index') }}" class="text-white font-weight-bold" style="font-size:1.2rem;">Categories</a></li>
        </ul>
        <div class="mt-4" style="position:absolute;bottom:30px;left:30px;right:30px;">
            <h5 class="text-white" style="color: #717fe0 !important;">Contact Information</h5>
            <p class="mb-1 text-white-50" style="color: #e9e9e9 !important; font-size: 14px !important;">SPU, Dier Ali, Ghabagheb, DR 10018</p>
            <p class="mb-1 text-white-50" style="color: #e9e9e9 !important; font-size: 14px !important;">(+963) 99 276 2770</p>
            <p class="mb-1 text-white-50" style="color: #e9e9e9 !important; font-size: 14px !important;">(+963) 98 879 7331</p>
            <p class="text-white-50" style="color: #e9e9e9 !important; font-size: 14px !important;">admin@cozastore.com</p>
        </div>
    </nav>

    <div class="main-content">
        <div class="form-container">
            <h2>Add New Category</h2>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="Enter category name">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter category description"></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Category Image</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" checked>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>
                <div class="btn-container d-flex gap-3">
                    <button type="submit" class="btn btn-success">Add Category</button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html> 