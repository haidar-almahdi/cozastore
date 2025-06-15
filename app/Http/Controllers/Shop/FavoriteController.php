<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the user's favorite products.
     */
    public function index()
    {
        $favorites = auth()->user()->favorites()->with('product')->get();
        return view('shop.favorites.index', compact('favorites'));
    }

    /**
     * Toggle the favorite status of a product.
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();

        // Toggle favorite status
        if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
            $user->favoriteProducts()->detach($product->id);
            $status = 'removed';
        } else {
            $user->favoriteProducts()->attach($product->id);
            $status = 'added';
        }

        // Return JSON response (for AJAX) or redirect back
        if (request()->expectsJson()) {
            return response()->json([
                'status' => $status,
                'is_favorited' => $status === 'added',
                'favorites_count' => $user->favoriteProducts()->count(),
            ]);
        }

        return back()->with('status', "Product {$status} from favorites!");
    }

    /**
     * Check if a product is favorited by the current user.
     */
    public function check(Product $product)
    {
        $isFavorited = auth()->user()->favorites()
            ->where('product_id', $product->id)
            ->exists();

        return response()->json(['is_favorited' => $isFavorited]);
    }

    /**
     * Get the count of user's favorites.
     */
    public function count()
    {
        $count = auth()->user()->favorites()->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Remove a product from favorites.
     */
    public function remove($id)
    {
        $favorite = auth()->user()->favorites()->findOrFail($id);
        $favorite->delete();

        return redirect()->back()->with('success', 'Product removed from favorites.');
    }
}
