<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Product</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
        .dropdown-menu { padding: 10px; }
        .form-check { margin: 5px 0; }
        .dropdown-menu.show { display: block; }
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
            <h2 class="mb-4">Edit Product</h2>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="price">Price</label>
                        <input type="number" name="price" id="price" class="form-control" step="0.01" min="0" value="{{ $product->price }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="stock">Stock</label>
                        <input type="number" name="stock" id="stock" class="form-control" min="0" value="{{ $product->stock }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="sizes">Sizes</label>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" id="sizesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $product->sizes ? implode(', ', $product->sizes) : 'Select Sizes' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sizesDropdown">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="S" {{ in_array('S', $product->sizes ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">S</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="M" {{ in_array('M', $product->sizes ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">M</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="L" {{ in_array('L', $product->sizes ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">L</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="XL" {{ in_array('XL', $product->sizes ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">XL</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sizes[]" value="XXL" {{ in_array('XXL', $product->sizes ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">XXL</label>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label for="colors">Colors</label>
                    <div class="dropdown">
                        <button type="button" class="btn btn-primary dropdown-toggle" id="colorsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $product->colors ? implode(', ', $product->colors) : 'Select Colors' }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="colorsDropdown">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="RED" {{ in_array('RED', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">RED</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="BLUE" {{ in_array('BLUE', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">BLUE</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="GREEN" {{ in_array('GREEN', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">GREEN</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="YELLOW" {{ in_array('YELLOW', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">YELLOW</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="WHITE" {{ in_array('WHITE', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">WHITE</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="BLACK" {{ in_array('BLACK', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">BLACK</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="colors[]" value="GRAY" {{ in_array('GRAY', $product->colors ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">GRAY</label>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="image">Main Image</label><br>
                        @if($product->image)
                            <img src="{{ $product->image_url }}" alt="Current Image" class="img-preview mb-2">
                        @endif
                        <input type="file" name="image" id="image" class="form-control-file">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="additional_images">Additional Images</label><br>
                        @if($product->additional_images)
                            @foreach($product->additional_images_urls as $imageUrl)
                                <img src="{{ $imageUrl }}" alt="Additional Image" class="img-preview mb-2">
                            @endforeach
                        @endif
                        <input type="file" name="additional_images[]" id="additional_images" class="form-control-file" multiple>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6 form-check">
                        <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1" {{ $product->is_featured ? 'checked' : '' }}>
                        <label for="is_featured" class="form-check-label">Featured</label>
                    </div>
                    <div class="form-group col-md-6 form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ $product->is_active ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Active</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ml-2">Cancel</a>
            </form>
        </div>
    </div>
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Function to update dropdown button text
            function updateDropdownText(buttonId, selectedValues) {
                if (selectedValues.length > 0) {
                    $(buttonId).text(selectedValues.join(', '));
                } else {
                    $(buttonId).text('Select Options');
                }
            }

            // Handle sizes selection
            $('input[name="sizes[]"]').change(function() {
                var selectedSizes = [];
                $('input[name="sizes[]"]:checked').each(function() {
                    selectedSizes.push($(this).val());
                });
                updateDropdownText('#sizesDropdown', selectedSizes);
            });

            // Handle colors selection
            $('input[name="colors[]"]').change(function() {
                var selectedColors = [];
                $('input[name="colors[]"]:checked').each(function() {
                    selectedColors.push($(this).val());
                });
                updateDropdownText('#colorsDropdown', selectedColors);
            });

            // Prevent dropdown from closing when clicking checkboxes
            $('.dropdown-menu').on('click', function(e) {
                e.stopPropagation();
            });

            // Form submission
            $('form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                
                // Get selected sizes and colors
                var sizes = [];
                var colors = [];

                // Collect selected sizes
                $('input[name="sizes[]"]:checked').each(function() {
                    sizes.push($(this).val());
                });

                // Collect selected colors
                $('input[name="colors[]"]:checked').each(function() {
                    colors.push($(this).val());
                });

                // Remove existing values
                formData.delete('sizes[]');
                formData.delete('colors[]');

                // Add each selected value
                sizes.forEach(function(size) {
                    formData.append('sizes[]', size);
                });

                colors.forEach(function(color) {
                    formData.append('colors[]', color);
                });

                // Submit form
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        window.location.href = '{{ route("admin.products.index") }}';
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<div class="alert alert-danger"><ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value[0] + '</li>';
                            });
                            errorHtml += '</ul></div>';
                            $('.alert').remove();
                            $('form').prepend(errorHtml);
                        }
                    }
                });
            });
        });
    </script>
</body>
</html> 