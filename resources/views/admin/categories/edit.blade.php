<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Category</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <style>
        .main-content { padding: 40px 30px; margin-left: 250px; background: #f5f6fa !important; }
        body { background: #f5f6fa; }
        .sidebar {
            min-height: 100vh;
            background: #222d32;
            color: #fff;
            padding: 0;
        }
        .img-preview { max-width: 100px; max-height: 100px; margin-right: 10px; }
        .nav-bar-container { display: flex; flex-direction: row-reverse; width: 80%; justify-content: space-between; align-items: center; }
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
    <div class="main-content">
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
        <div class="container" style="max-width: 700px;">
            <h2 class="mb-4">Edit Category</h2>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ $category->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="image">Category Image</label><br>
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" alt="Current Image" class="img-preview mb-2">
                    @endif
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $category->is_active ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>
                <button type="submit" class="btn btn-success">Update Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </form>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html> 