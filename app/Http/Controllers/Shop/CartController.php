<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    protected function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id(), 'status' => 'active'],
                ['session_id' => session()->getId()]
            );
        } else {
            $cart = Cart::firstOrCreate(
                ['session_id' => session()->getId(), 'status' => 'active']
            );
        }

        return $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $cart = $this->getCart();
            $items = $cart->items()
                ->with('product')
                ->get();

            // Filter out items with null products
            $items = $items->filter(function($item) {
                return $item->product !== null;
            });

            return view('shop.cart.index', compact('cart', 'items'));
        } catch (\Exception $e) {
            return redirect()->route('shop.home')
                ->with('error', 'Error loading cart: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('shop.products.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json(['error' => 'This product is currently not available.'], 422);
        }

        if ($product->stock < $request->quantity) {
            return response()->json(['error' => 'The requested quantity is not available. Maximum available: ' . $product->stock], 422);
        }

        $cart = $this->getCart();

        // Check if product already exists in cart
        $cartItem = $cart->items()
            ->where('product_id', $product->id)
            ->where('size', $request->size)
            ->where('color', $request->color)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($newQuantity > $product->stock) {
                return response()->json(['error' => 'Cannot add more of this item. Maximum available: ' . $product->stock], 422);
            }

            $cartItem->update([
                'quantity' => $newQuantity
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'size' => $request->size,
                'color' => $request->color
            ]);
        }

        return response()->json([
            'message' => 'Product added to cart successfully',
            'cart_count' => $cart->item_count
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('shop.cart.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return redirect()->route('shop.cart.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $request->validate([
                'cart_item_id' => 'required|exists:cart_items,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem = CartItem::with('product')->findOrFail($request->cart_item_id);

            // Check if the requested quantity is available in stock
            if ($request->quantity > $cartItem->product->stock) {
                return response()->json([
                    'success' => false,
                    'error' => 'Requested quantity not available in stock. Maximum available: ' . $cartItem->product->stock
                ]);
            }

            // Update the quantity
            $cartItem->update([
                'quantity' => $request->quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully',
                'new_quantity' => $cartItem->quantity,
                'new_total' => number_format($cartItem->price * $cartItem->quantity, 2)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to update cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function remove($id)
    {
        try {
        $cart = $this->getCart();
            $cartItem = $cart->items()->findOrFail($id);
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart'
            ], 500);
        }
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        return back()->with('success', 'Cart cleared successfully.');
    }

    /**
     * Process the checkout.
     */
    public function checkout(Request $request)
    {
        $cart = $this->getCart();

        if ($cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        $validator = Validator::make($request->all(), [
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Validate all products before processing
            foreach ($cart->items as $item) {
                $product = $item->product;
                if (!$product->is_active) {
                    throw new \Exception("Product {$product->name} is no longer available.");
                }

                if ($product->stock < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$product->name}. Available: {$product->stock}");
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . date('Ymd') . '-' . Str::random(6),
                'total_amount' => $cart->total,
                'status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status_history' => [[
                    'status' => 'pending',
                    'notes' => 'Order placed by customer',
                    'changed_at' => now()
                ]]
            ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'size' => $item->size,
                    'color' => $item->color,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->update(['status' => 'completed']);

            DB::commit();

            return redirect()->route('shop.orders.show', $order)
                ->with('success', 'Order placed successfully. Your order number is ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Get cart count for header display
     */
    public function getCartCount()
    {
        $cart = $this->getCart();
        return response()->json(['count' => $cart->item_count]);
    }

    public function add($product, Request $request)
    {
        // Add product to cart logic here
        return back()->with('success', 'Product added to cart successfully.');
    }
}
