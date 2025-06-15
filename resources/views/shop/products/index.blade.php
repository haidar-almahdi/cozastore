<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            /* background: linear-gradient(90deg, #e2e2e2, #c9d6ff); */
        }

        .container {
            /* background: #fff; */
            border-radius: 30px;
            /* box-shadow: 0 0 30px rgba(0, 0, 0, .2); */
            padding: 20px;
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

        .product-card { position: relative; overflow: hidden; }
        .quick-view-btn {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
        }
        .product-card:hover .quick-view-btn { display: block; }
        .product-card::after {
            content: '';
            display: block;
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0,0,0,0.2);
            opacity: 0;
            transition: opacity 0.2s;
            z-index: 1;
        }
        .product-card:hover::after { opacity: 1; }
        .modal-backdrop { z-index: 1040 !important; }
        .modal-content { z-index: 1100 !important; }
        .block2-btn-favorite {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 2;
        }

        .favorite-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
            transition: all 0.3s ease;
        }

        .favorite-btn i {
            color: rgba(0,0,0,.5);
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .favorite-btn.active i {
            color: #dc3545;
        }

        .favorite-btn:hover i {
            transform: scale(1.1);
        }

        .block2-btn-favorite .favorite-btn {
            background: none;
            border: none;
            padding: 5px;
            color: rgba(0,0,0,.5);
            transition: color 0.3s ease;
        }

        .block2-btn-favorite .favorite-btn.active {
            color: #dc3545;
        }

        .block2-btn-favorite .favorite-btn i {
            font-size: 1.2rem;
        }

        .block2-pic {
            position: relative;
        }

        .block2-btn-addcart {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .favorite-btn.active i.fa-heart {
            color: red;
        }
    </style>
</head>
<body class="animsition">
    @include('layouts.sidebar');

    <!-- Filter Bar -->
    <section class="container py-4">
        <div class="d-flex flex-wrap align-items-center justify-content-center mb-4">
            <a href="{{ route('shop.products.index') }}"
               class="btn btn-outline-primary m-2 {{ !request('category') ? 'active' : '' }}">
                All Products
            </a>
            @foreach($categories as $category)
                <a href="{{ route('shop.products.index', ['category' => $category->slug]) }}"
                   class="btn btn-outline-primary m-2 {{ request('category') == $category->slug ? 'active' : '' }}">
                    {{ $category->name }}
                    <span class="badge badge-light ml-1">{{ $category->products_count ?? 0 }}</span>
                </a>
            @endforeach
        </div>

        @if(request('category'))
            <div class="alert alert-info mb-4">
                Showing products in category: <strong>{{ $categories->firstWhere('slug', request('category'))->name }}</strong>
                <a href="{{ route('shop.products.index') }}" class="float-right">Clear filter</a>
            </div>
        @endif

        <div class="row">
            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $product->category->slug }}">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <a href="{{ route('shop.products.show', $product) }}" class="block2-img dis-block hov-img-zoom">
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                            </a>
                            <div class="block2-btn-favorite w-size1 trans-0-4">
                                @auth
                                    <form action="{{ route('shop.favorites.toggle', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="favorite-btn {{ auth()->user()->hasFavorited($product) ? 'active' : '' }}" data-product-slug="{{ $product->slug }}">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l">
                                <a href="{{ route('shop.products.show', $product->slug) }}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $product->name }}
                                </a>
                                <span class="stext-105 cl3">
                                    ${{ number_format($product->price, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- Quick View Modal -->
    <div class="modal fade" id="quickViewModal" tabindex="-1" role="dialog" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickViewModalLabel">Product Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="quickViewContent">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="product-image-container">
                                <img id="modalProductImage" src="" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h3 id="modalProductName"></h3>
                            <p id="modalProductPrice" class="text-primary h4"></p>
                            <p id="modalProductDescription" class="text-muted"></p>

                            <form id="addToCartForm" class="mt-4">
                                @csrf
                                <input type="hidden" id="modalProductId" name="product_id">

                                <div class="form-group">
                                    <label for="modalSize">Size</label>
                                    <select class="form-control" id="modalSize" name="size" required>
                                        <option value="">Select Size</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="modalColor">Color</label>
                                    <select class="form-control" id="modalColor" name="color" required>
                                        <option value="">Select Color</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="modalQuantity">Quantity</label>
                                    <input type="number" class="form-control" id="modalQuantity" name="quantity" value="1" min="1" required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fa fa-shopping-cart"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            // Quick View Modal
            $('.quick-view-btn').click(function(e) {
                e.preventDefault();
                var productId = $(this).data('product-id');

                // Show loading spinner
                $('#quickViewContent').html('<div class="text-center py-5"><span class="spinner-border"></span></div>');
                $('#quickViewModal').modal('show');

                // Fetch product details
                $.ajax({
                    url: '/shop/products/' + productId,
                    type: 'GET',
                    success: function(response) {
                        // Update modal content
                        $('#modalProductId').val(response.id);
                        $('#modalProductName').text(response.name);
                        $('#modalProductPrice').text('$' + response.price);
                        $('#modalProductDescription').text(response.description);
                        $('#modalProductImage').attr('src', response.image_url);

                        // Update size options
                        var sizeSelect = $('#modalSize');
                        sizeSelect.empty().append('<option value="">Select Size</option>');
                        response.sizes.forEach(function(size) {
                            sizeSelect.append('<option value="' + size + '">' + size + '</option>');
                        });

                        // Update color options
                        var colorSelect = $('#modalColor');
                        colorSelect.empty().append('<option value="">Select Color</option>');
                        response.colors.forEach(function(color) {
                            colorSelect.append('<option value="' + color + '">' + color + '</option>');
                        });
                    },
                    error: function() {
                        $('#quickViewContent').html('<div class="alert alert-danger">Error loading product details</div>');
                    }
                });
            });

            // Add to Cart Form Submission
            $('#addToCartForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("shop.cart.add") }}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        // Show success message
                        alert('Product added to cart successfully!');
                        // Close modal
                        $('#quickViewModal').modal('hide');
                        // Update cart count if you have one
                        if (response.cart_count) {
                            $('.cart-count').text(response.cart_count);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('#addToCartForm').prepend(errorHtml);
                        } else {
                            alert('Error adding product to cart');
                        }
                    }
                });
            });

            // Favorite button functionality
            $('.favorite-btn').click(function(e) {
                e.preventDefault();
                const button = $(this);
                const productSlug = button.data('product-slug');

                $.ajax({
                    url: `/shop/favorites/${productSlug}/toggle`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    success: function(data) {
                        if (data.status === 'added' || data.status === 'removed') {
                            button.toggleClass('active');
                            // Update favorite count in navbar
                            $('.favorite-count').text(data.count);
                            // Refresh the page
                            location.reload();
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Initial favorite count update
            $.get('/shop/favorites/count')
                .done(function(data) {
                    $('.favorite-count').text(data.count);
                });
        });
    </script>
</body>
</html>
