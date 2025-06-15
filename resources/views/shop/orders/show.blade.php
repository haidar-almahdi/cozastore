@extends('layouts.app')

@section('content')
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
        height: 1200px;
    }

    .order-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 40px 0;
    }

    .card {
        position: relative;
        width: 100%;
        background: #fff;
        border-radius: 30px;
        box-shadow: 0 0 30px rgba(0, 0, 0, .2);
        overflow: hidden;
        border: none;
    }

    .card-header {
        background: #fff;
        padding: 30px;
        border-bottom: 1px solid #eee;
    }

    .card-header h4 {
        font-size: 28px;
        color: #333;
        font-weight: 600;
        margin: 0;
    }

    .card-body {
        padding: 30px;
    }

    .alert-success {
        background: #e8f5e9;
        border: none;
        border-radius: 8px;
        color: #2e7d32;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .alert-success i {
        margin-right: 8px;
    }

    h5 {
        color: #333;
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 18px;
    }

    p {
        color: #555;
        margin-bottom: 10px;
        font-size: 14px;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 12px;
    }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .table {
        margin-top: 0;
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        border: none;
        padding: 15px;
        font-size: 14px;
        position: sticky;
        top: 0;
        z-index: 1;
    }

    .table tbody td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        color: #555;
        font-size: 14px;
        vertical-align: middle;
    }

    .table tfoot td {
        padding: 15px;
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        position: sticky;
        bottom: 0;
        z-index: 1;
    }

    /* Custom scrollbar styles */
    .table-responsive::-webkit-scrollbar {
        width: 8px;
    }

    .table-responsive::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
        background: #7494ec;
        border-radius: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
        background: #5a7de8;
    }

    .text-muted {
        color: #666 !important;
        font-size: 12px;
    }

    .btn {
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: #7494ec;
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    .btn-primary:hover {
        background: #5a7de8;
        transform: translateY(-2px);
    }

    .btn-danger {
        background: #dc3545;
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, .1);
    }

    .btn-danger:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
    .total-container {
        width: 50%;
        display: flex
    ;
        justify-content: space-between;
        align-items: center;
        padding: 2%;
        background: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 1%;
    }

    @media screen and (max-width: 768px) {
        .order-container {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            padding: 20px;
        }

        .card-body {
            padding: 20px;
        }

        .table {
            font-size: 13px;
        }
    }
</style>

<div class="order-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Order Confirmation</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i> Thank you for your order! Your order has been placed successfully.
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5>Order Information</h5>
                                <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                                <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'secondary') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Shipping Information</h5>
                                <p><strong>Name:</strong> {{ $order->shipping_name }}</p>
                                <p><strong>Phone:</strong> {{ $order->shipping_phone }}</p>
                                <p><strong>Address:</strong> {{ $order->shipping_address }}</p>
                            </div>
                        </div>

                        <h5>Order Items</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            {{ $item->product->name }}
                                            @if($item->size)
                                                <br><small class="text-muted">Size: {{ $item->size }}</small>
                                            @endif
                                            @if($item->color)
                                                <br><small class="text-muted">Color: {{ $item->color }}</small>
                                            @endif
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($order->notes)
                        <div class="mt-4">
                            <h5>Order Notes</h5>
                            <p>{{ $order->notes }}</p>
                        </div>
                        @endif
                        <div class="total-container">
                            <div><strong>Total:</strong></div>
                            <div><strong>${{ number_format($order->total_amount, 2) }}</strong></div>
                        </div>
                        <div class="mt-4">
                            @if($order->status === 'pending')
                            <form action="{{ route('shop.orders.cancel', $order) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this order?')">
                                    Cancel Order
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('shop.home') }}" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
