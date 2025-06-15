<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->get();
        return view('shop.orders.index', compact('orders'));
    }

    /**
     * Show the checkout form.
     */
    public function create()
    {
        $cart = auth()->user()->activeCart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        // Load cart items with their relationships
        $cart->load(['items.product']);

        return view('shop.orders.create', compact('cart'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = auth()->user()->activeCart;

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('shop.cart')->with('error', 'Your cart is empty.');
        }

        // Load cart items with their relationships
        $cart->load(['items.product']);

        try {
            DB::beginTransaction();

            // Check stock availability for all items first
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    throw new \Exception("Sorry, we only have {$product->stock} units of {$product->name} in stock. You requested {$item->quantity} units.");
                }
            }

            // Calculate totals
            $subtotal = $cart->items->sum(function($item) {
                return $item->price * $item->quantity;
            });
            $shipping = $subtotal * 0.02; // 2% shipping
            $total = $subtotal + $shipping;

            // Create order
        $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => 'ORD-' . strtoupper(Str::random(10)),
                'total_amount' => $total,
            'shipping_name' => $request->shipping_name,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

            // Create order items and update stock
            foreach ($cart->items as $item) {
                $product = $item->product;

                // Create order item
                $orderItem = OrderItem::create([
                'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'size' => $item->size,
                    'color' => $item->color
            ]);

                // Update product stock
                $product->decrement('stock', $item->quantity);
        }

            // Clear the cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Redirect to the order show page with the order ID
            return redirect()->route('shop.orders.show', ['order' => $order->id])
                ->with('success', 'Your order has been placed successfully! Order number: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('shop.orders.show', compact('order'));
    }

    /**
     * Cancel the specified order.
     */
    public function cancel(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Order has been cancelled successfully.');
    }
}
