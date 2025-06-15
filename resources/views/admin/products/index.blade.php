<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Products</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <style>
        .main-content { padding: 40px 30px; margin-left: 250px; }
        .table th, .table td { vertical-align: middle; }
    </style>
        <style>
        body { background: #f5f6fa; }
        .sidebar {
            min-height: 100vh;
            background: #222d32;
            color: #fff;
            padding: 0;
        }
        .sidebar .nav-link {
            color: #fff;
            font-weight: 500;
            padding: 18px 24px;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background: #1a2226;
            color: #ffc107;
        }
        .sidebar .nav-link.disabled {
            color: #aaa;
            pointer-events: none;
            background: none;
        }
        .main-content { padding: 40px 30px; margin-left: 250px; background: #f5f6fa !important; }
        .stat-card { background: #fff; border-radius: 10px; box-shadow: 0 2px 16px rgba(0,0,0,0.04); padding: 32px; margin-bottom: 32px; }
        .stat-title { font-size: 1.1rem; color: #888; }
        .stat-value { font-size: 2.2rem; font-weight: bold; }
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Products</h2>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
        </div>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category ? $product->category->name : '-' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge badge-success">Active</span>
                                @else
                                    <span class="badge badge-secondary">Inactive</span>
                                @endif
                            </td>
                            <td>
                                @if($product->image)
                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" width="60">
                                @else
                                    <span class="text-muted">No image</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <div class="d-flex align-items-center">
                    <a href="{{ $products->previousPageUrl() }}" class="btn btn-sm btn-outline-primary mr-2">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                    <a href="{{ $products->nextPageUrl() }}" class="btn btn-sm btn-outline-primary ml-2">
                        <i class="fa fa-chevron-right"></i>
                    </a>
            </div>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
