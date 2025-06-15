<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $product->name }} - CozaStore</title>
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
        .product-gallery { margin-bottom: 30px; }
        .product-gallery img { width: 100%; height: auto; }
        .product-thumbnails { display: flex; gap: 10px; margin-top: 10px; }
        .product-thumbnails img { width: 80px; height: 80px; object-fit: cover; cursor: pointer; border: 2px solid transparent; }
        .product-thumbnails img.active { border-color: #717fe0; }
        .product-details { padding: 20px; }
        .product-price { font-size: 24px; color: #717fe0; margin: 20px 0; }
        .product-description { margin: 20px 0; }
        .product-meta { margin: 20px 0; }
        .product-meta span { display: block; margin-bottom: 10px; }
        .quantity-input { width: 100px; }
        .dropdown-menu { padding: 10px; }
        .form-check { margin: 5px 0; }
        .dropdown-menu.show { display: block; }
        .selected-options { margin-top: 5px; font-size: 0.9em; color: #666; }
        .favorite-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            color: #fff;
            transition: color 0.3s ease;
        }
        .favorite-btn.active {
            color: #dc3545;
        }
        .favorite-btn i {
            font-size: 1.2rem;
        }
        .product-actions {
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 15px 0;
        }
        .btn-favorite {
            background: none;
            border: none;
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 5px;
        }
        .btn-favorite:hover {
            transform: scale(1.1);
        }
        .btn-favorite.active {
            color: #dc3545;
        }
        .btn-favorite i {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="animsition">
    <!-- Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="{{ route('shop.home') }}">
                    <img src="{{ asset('images/icons/logo-01.png') }}" alt="Logo" height="40">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="{{ route('shop.home') }}">Home</a></li>
                        <li class="nav-item active"><a class="nav-link" href="{{ route('shop.products.index') }}">Shop</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('shop.cart') }}">Cart</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('shop.about') }}">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('shop.contact') }}">Contact</a></li>
                    </ul>
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item position-relative">
                            <a class="nav-link" href="{{ route('shop.cart') }}">
                                <i class="zmdi zmdi-shopping-cart"></i>
                                <span class="badge badge-danger position-absolute cart-count" style="top:0;right:0;">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Product Details -->
    <section class="container py-5">
        <div class="row">
            <!-- Product Gallery -->
            <div class="col-md-6">
                <div class="product-gallery">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" id="mainImage" class="img-fluid">
                    @if($product->additional_images)
                        <div class="product-thumbnails">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="active" onclick="changeImage(this.src)">
                            @foreach($product->additional_images_urls as $image)
                                <img src="{{ $image }}" alt="{{ $product->name }}" onclick="changeImage(this.src)">
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-md-6">
                <div class="product-details">
                    <h2 class="product-title">{{ $product->name }}</h2>
                    <div class="product-actions">
                        <button class="favorite-btn {{ $product->isFavoritedBy(auth()->user()) ? 'active' : '' }}" data-product-id="{{ $product->id }}">
                            <i class="fa fa-heart"></i>
                        </button>
                        <div class="product-price">${{ number_format($product->price, 2) }}</div>
                    </div>

                    <div class="product-description">
                        <p>{{ $product->description }}</p>
                    </div>

                    <form action="{{ route('shop.cart.add') }}" method="POST" id="addToCartForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="form-group">
                            <label for="sizes">Size</label>
                            <div class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" id="sizesDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Size
                                </button>
                                <div class="dropdown-menu" aria-labelledby="sizesDropdown">
                                    @foreach($product->sizes as $size)
                                        <div class="form-check px-3 py-1">
                                            <input class="form-check-input size-checkbox" type="checkbox" name="sizes[]" value="{{ $size }}" id="size_{{ $size }}">
                                            <label class="form-check-label" for="size_{{ $size }}">{{ $size }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="selected-options" id="selectedSizes"></div>
                        </div>

                        <div class="form-group">
                            <label for="colors">Color</label>
                            <div class="dropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" id="colorsDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Select Color
                                </button>
                                <div class="dropdown-menu" aria-labelledby="colorsDropdown">
                                    @foreach($product->colors as $color)
                                        <div class="form-check px-3 py-1">
                                            <input class="form-check-input color-checkbox" type="checkbox" name="colors[]" value="{{ $color }}" id="color_{{ $color }}">
                                            <label class="form-check-label" for="color_{{ $color }}">{{ $color }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="selected-options" id="selectedColors"></div>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" name="quantity" id="quantity" class="form-control quantity-input" value="1" min="1" max="{{ $product->stock }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>

                    <div class="product-meta">
                        <span><strong>Category:</strong> {{ $product->category->name }}</span>
                        <span><strong>Availability:</strong>
                            @if($product->stock > 0)
                                <span class="text-success">In Stock ({{ $product->stock }} available)</span>
                            @else
                                <span class="text-danger">Out of Stock</span>
                            @endif
                        </span>
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
    <script>
        function changeImage(src) {
            document.getElementById('mainImage').src = src;
            // Update active thumbnail
            document.querySelectorAll('.product-thumbnails img').forEach(img => {
                img.classList.remove('active');
                if (img.src === src) {
                    img.classList.add('active');
                }
            });
        }

        // Handle size selection
        $('.size-checkbox').change(function() {
            updateSelectedSizes();
        });

        function updateSelectedSizes() {
            var selectedSizes = [];
            $('.size-checkbox:checked').each(function() {
                selectedSizes.push($(this).val());
            });

            if (selectedSizes.length > 0) {
                $('#selectedSizes').text('Selected: ' + selectedSizes.join(', '));
                $('#sizesDropdown').text(selectedSizes.length + ' sizes selected');
            } else {
                $('#selectedSizes').text('');
                $('#sizesDropdown').text('Select Size');
            }
        }

        // Handle color selection
        $('.color-checkbox').change(function() {
            updateSelectedColors();
        });

        function updateSelectedColors() {
            var selectedColors = [];
            $('.color-checkbox:checked').each(function() {
                selectedColors.push($(this).val());
            });

            if (selectedColors.length > 0) {
                $('#selectedColors').text('Selected: ' + selectedColors.join(', '));
                $('#colorsDropdown').text(selectedColors.length + ' colors selected');
            } else {
                $('#selectedColors').text('');
                $('#colorsDropdown').text('Select Color');
            }
        }

        // Prevent dropdown from closing when clicking checkboxes
        $('.dropdown-menu').on('click', function(e) {
            e.stopPropagation();
        });

        // Add to Cart Form Submission
        $('#addToCartForm').submit(function(e) {
            e.preventDefault();

            // Validate size and color selection
            var selectedSizes = $('.size-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            var selectedColors = $('.color-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (selectedSizes.length === 0 || selectedColors.length === 0) {
                alert('Please select at least one size and one color');
                return;
            }

            // Create a cart item for each size and color combination
            var promises = [];
            var quantity = parseInt($('#quantity').val());
            var form = $(this);
            var url = form.attr('action');

            selectedSizes.forEach(function(size) {
                selectedColors.forEach(function(color) {
                    var formData = {
                        product_id: $('input[name="product_id"]').val(),
                        quantity: quantity,
                        size: size,
                        color: color,
                        _token: $('input[name="_token"]').val()
                    };

                    promises.push(
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: formData,
                            success: function(response) {
                                if (response.cart_count) {
                                    $('.cart-count').text(response.cart_count);
                                }
                            }
                        })
                    );
                });
            });

            // Wait for all cart additions to complete
            Promise.all(promises)
                .then(function(responses) {
                    alert('Products added to cart successfully!');
                })
                .catch(function(error) {
                    if (error.status === 422) {
                        var errors = error.responseJSON.errors;
                        var errorHtml = '<div class="alert alert-danger"><ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value[0] + '</li>';
                        });
                        errorHtml += '</ul></div>';
                        $('#addToCartForm').prepend(errorHtml);
                    } else {
                        alert('Error adding products to cart');
                    }
                });
        });

        // Favorite button functionality
        $('.favorite-btn').click(function() {
            var btn = $(this);
            var productId = btn.data('product-id');

            $.ajax({
                url: '/shop/favorites/' + productId + '/toggle',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.isFavorited) {
                        btn.addClass('active').html('<i class="fa fa-heart"></i> Remove from Favorites');
                    } else {
                        btn.removeClass('active').html('<i class="fa fa-heart"></i> Add to Favorites');
                    }
                    updateFavoriteCount();
                }
            });
        });

        function updateFavoriteCount() {
            $.get('/shop/favorites/count', function(response) {
                $('.favorite-count').text(response.count);
            });
        }

        // Check if product is favorited on page load
        $(document).ready(function() {
            var productId = $('.favorite-btn').data('product-id');
            $.get('/shop/favorites/' + productId + '/check', function(response) {
                if (response.is_favorited) {
                    $('.favorite-btn').addClass('active').html('<i class="fa fa-heart"></i> Remove from Favorites');
                }
            });
            updateFavoriteCount();
        });

        // Additional favorite count logic (fetch API)
        function toggleFavorite(button) {
            const productId = button.dataset.productId;
            const icon = button.querySelector('i');

            fetch(`/favorites/toggle/${productId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    button.classList.add('active');
                    updateFavoriteCount(data.count);
                } else {
                    button.classList.remove('active');
                    updateFavoriteCount(data.count);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function updateFavoriteCount(count) {
            const counters = document.querySelectorAll('.favorite-count');
            counters.forEach(counter => {
                counter.textContent = count;
            });
        }

        // Update favorite count on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/favorites/count')
                .then(response => response.json())
                .then(data => {
                    updateFavoriteCount(data.count);
                });
        });
    </script>
</body>
</html>
