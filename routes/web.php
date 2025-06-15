<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\AboutController;
use App\Http\Controllers\Shop\ContactController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Shop\FavoriteController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Shop\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('shop.home');
Route::get('/shop', [ProductController::class, 'index'])->name('shop.products.index');
Route::get('/shop/product/{product}', [ProductController::class, 'show'])->name('shop.products.show');
Route::post('/shop/cart/add', [CartController::class, 'store'])->name('shop.cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart/add', [CartController::class, 'store'])->name('shop.cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('shop.cart.update');
Route::get('/about', [AboutController::class, 'index'])->name('shop.about');
Route::get('/contact', [ContactController::class, 'index'])->name('shop.contact');

// Admin routes
Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [AdminHomeController::class, 'index'])->name('admin.home');
    Route::resource('products', AdminProductController::class)->except(['show'])->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('categories', AdminCategoryController::class)->except(['show'])->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
});

Route::prefix('shop')->name('shop.')->group(function () {
    // Favorites routes
    Route::middleware('auth')->group(function () {
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');
        Route::post('/favorites/{product}/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
        Route::get('/favorites/{product}/check', [FavoriteController::class, 'check'])->name('favorites.check');
        Route::get('/favorites/count', [FavoriteController::class, 'count'])->name('favorites.count');
        Route::delete('/favorites/{id}', [FavoriteController::class, 'remove'])->name('favorites.remove');

        // Profile routes
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Cart routes
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Orders routes
    Route::middleware('auth')->group(function () {
        Route::get('/checkout', [OrderController::class, 'create'])->name('checkout');
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    });
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'showLogoutForm'])->name('logout.form')->middleware('auth');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Auth::routes();
