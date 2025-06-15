<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Get user count
        $userCount = User::count();

        // Get profits (assuming you have an Order model with total_price field)
        $profits = Order::sum('total_price');

        // Get gender percentages
        $maleCount = User::where('gender', 'male')->count();
        $femaleCount = User::where('gender', 'female')->count();
        $totalGender = $maleCount + $femaleCount;
        
        $malePercent = $totalGender > 0 ? round(($maleCount / $totalGender) * 100) : 0;
        $femalePercent = $totalGender > 0 ? round(($femaleCount / $totalGender) * 100) : 0;

        // Get top products by orders
        $topProducts = Product::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // Get top users by orders
        $topUsers = User::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.home', compact(
            'userCount',
            'profits',
            'malePercent',
            'femalePercent',
            'topProducts',
            'topUsers'
        ));
    }
} 