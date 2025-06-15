<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
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
        body { background: linear-gradient(90deg, #e2e2e2, #c9d6ff); height: auto !important;}
        .cart-table th, .cart-table td { vertical-align: middle; }
        .cart-total-box { background: #f8f9fa; border-radius: 8px; padding: 24px; }
        .cart-total-box h5 { margin-bottom: 20px; }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #868e96 !important;
        }

        .table td, .table th {
            border-top: 2px solid #868e96 !important;
        }
    </style>
</head>
<body class="animsition">
    @include('layouts.sidebar')
    <!-- Cart Section -->
    <section class="container py-5">
        <h2 class="mb-4">Shopping Cart</h2>
        <div class="row">
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="table-responsive">
                    <table class="table cart-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product)
                                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" width="60" class="mr-3 rounded">
                                                <div>
                                                    <div class="font-weight-bold">{{ $item->product->name }}</div>
                                                    @if($item->size)
                                                        <div class="small text-muted" style="color: #666666 !important;">Size: {{ $item->size }}</div>
                                                    @endif
                                                    @if($item->color)
                                                        <div class="small text-muted" style="color: #666666 !important;">Color: {{ $item->color }}</div>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-danger">
                                                    Product no longer available
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>
                                        @if($item->product)
                                            <form method="POST" action="{{ route('shop.cart.update') }}" class="d-inline update-qty-form">
                                                @csrf
                                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" class="form-control form-control-sm qty-input" style="width:80px;display:inline-block;">
                                                <input type="hidden" name="cart_item_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-sm btn-outline-primary ml-2">Update</button>
                                            </form>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('shop.cart.remove', $item->id) }}" class="d-inline delete-item-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Your cart is empty.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-total-box">
                    <h5>Cart Total</h5>
                    @php
                        $finalTotal = $items->sum(function($item) { return $item->price * $item->quantity; });
                        $shipping = $finalTotal * 0.02;
                        $totalWithShipping = $finalTotal + $shipping;
                    @endphp
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>${{ number_format($finalTotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping (2%):</span>
                        <span>${{ number_format($shipping, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="font-weight-bold">Total:</span>
                        <span class="font-weight-bold">${{ number_format($totalWithShipping, 2) }}</span>
                    </div>
                    <a href="{{ route('shop.checkout') }}" class="btn btn-primary btn-block">Proceed to checkout</a>
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
    <script>
        $(document).ready(function() {
            $('.update-qty-form').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var cartItemId = form.find('input[name="cart_item_id"]').val();
                var quantity = form.find('input[name="quantity"]').val();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_item_id: cartItemId,
                        quantity: quantity
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.reload();
                        } else {
                            alert(response.error || 'Failed to update quantity');
                        }
                    },
                    error: function(xhr) {
                        alert('Failed to update quantity');
                    }
                });
            });

            $('.delete-item-form').on('submit', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    var form = $(this);
                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function(response) {
                            form.closest('tr').fadeOut(300, function() {
                                $(this).remove();
                                if ($('.cart-table tbody tr').length === 0) {
                                    $('.cart-table tbody').html('<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>');
                                }
                                location.reload();
                            });
                        },
                        error: function() {
                            alert('Failed to remove item from cart');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
