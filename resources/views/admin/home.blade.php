<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
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
        .main-content { padding: 6% 50px; padding-left: 10%; }
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
<div class="container-fluid">
    <div class="row">
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
        <!-- Main Content -->
        <main class="col-md-10 ml-sm-auto main-content" style="margin-left:300px;">
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card text-center mb-4">
                        <div class="stat-title">Registered Users</div>
                        <div class="stat-value">{{ $userCount }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center mb-4">
                        <div class="stat-title">Total Profits</div>
                        <div class="stat-value">${{ number_format($profits, 2) }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center mb-4">
                        <div class="stat-title">Male Users</div>
                        <div class="stat-value">{{ $malePercent }}%</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card text-center mb-4">
                        <div class="stat-title">Female Users</div>
                        <div class="stat-value">{{ $femalePercent }}%</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="stat-card">
                        <h5 class="mb-4">Most Requested Products</h5>
                        <canvas id="productsChart" height="200"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card">
                        <h5 class="mb-4">Top Users by Orders</h5>
                        <canvas id="usersChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script>
    // Most Requested Products Chart
    var productsCtx = document.getElementById('productsChart').getContext('2d');
    var productsChart = new Chart(productsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($mostRequestedProducts->pluck('name')) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($mostRequestedProducts->pluck('orders_count')) !!},
                backgroundColor: '#007bff',
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
    // Top Users by Orders Chart
    var usersCtx = document.getElementById('usersChart').getContext('2d');
    var usersChart = new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($topUsers->pluck('name')) !!},
            datasets: [{
                label: 'Orders',
                data: {!! json_encode($topUsers->pluck('orders_count')) !!},
                backgroundColor: '#28a745',
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
</body>
</html> 