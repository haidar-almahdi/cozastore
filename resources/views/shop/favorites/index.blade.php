@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">My Favorites</h2>

            @if($favorites->isEmpty())
                <div class="alert alert-info">
                    You haven't added any products to your favorites yet.
                </div>
            @else
                <div class="row">
                    @foreach($favorites as $favorite)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="{{ $favorite->product->image_url }}" class="card-img-top" alt="{{ $favorite->product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $favorite->product->name }}</h5>
                                    <p class="card-text">${{ number_format($favorite->product->price, 2) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('shop.products.show', $favorite->product) }}" class="btn btn-primary">View Details</a>
                                        <form action="{{ route('shop.favorites.remove', $favorite->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="zmdi zmdi-favorite"></i> Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
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

    .btn {
        padding: 8px 20px;
        border-radius: 5px;
        font-weight: 500;
    }

    .btn-primary {
        background: #7494ec;
        border: none;
    }

    .btn-primary:hover {
        background: #5a7de8;
    }

    .btn-danger {
        background: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background: #c82333;
    }
</style>
@endsection
