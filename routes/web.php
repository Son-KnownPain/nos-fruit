<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\SiteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;

use \App\Http\Middleware\IsAdmin;
use Illuminate\Http\Request;

Auth::routes([
    'verify' => true
]);

// Base routing
Route::get('/', [SiteController::class, 'index']);
Route::get('/introduce', [SiteController::class, 'introduce']);
Route::get('/contact', [SiteController::class, 'contact']);
Route::get('/products', [SiteController::class, 'products']);
Route::get('/product-detail/{id}', [SiteController::class, 'productDetail']);
Route::get('/search', [SiteController::class, 'search']);

Route::get('/cart', [SiteController::class, 'cart']);
Route::get('/add-to-cart/{id}', [SiteController::class, 'addToCart']);
Route::get('/add-multi-to-cart/{id}', [SiteController::class, 'addMultiToCart']);
Route::get('/cart/increase/{id}', [SiteController::class, 'increaseQuantity']);
Route::get('/cart/decrease/{id}', [SiteController::class, 'decreaseQuantity']);
Route::get('/cart/delete/{id}', [SiteController::class, 'delete']);

Route::get('/login', [SiteController::class, 'login'])->name('login');
Route::get('/register', [SiteController::class, 'register']);
Route::post('/contact/send', [ContactController::class, 'send']); // Người dùng submit contact
// Checkout
Route::get('/checkout', [SiteController::class, 'checkout'])->middleware(['auth', 'verified']);
Route::post('/checkout/confirm', [SiteController::class, 'checkoutConfirm'])->middleware(['auth', 'verified']);



// User routing
Route::post('/login/store', [UserController::class, 'loginCheck']);
Route::post('/register/store', [UserController::class, 'store']);
// Resend email verify
Route::post('/email/verification-notification', [UserController::class, 'resendEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::middleware('auth')->group(function() {

    // Email verify
    Route::get('/email/verify', [UserController::class, 'emailVerify'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [UserController::class, 'emailConfirm'])->middleware('signed')->name('verification.verify');

    // Others
    Route::get('/logout', [UserController::class, 'logout'])->middleware('auth');

});
Route::middleware(['auth', 'verified'])->prefix('/profile')->group(function () {
    Route::get('/', [UserController::class, 'profile']);

    // Chỉnh sửa địa chỉ
    Route::put('/address/update', [UserController::class, 'updateAddress']);

    // Lấy ra các orders
    Route::get('/order-detail/{id}', [UserController::class, 'userOrderDetail']);
});



// Admin routing
Route::middleware([IsAdmin::class])->prefix('/admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']);
    
    Route::get('/login', [AdminController::class, 'login'])->withoutMiddleware([IsAdmin::class])->name('admin_login');
    Route::post('/login/store', [AdminController::class, 'store'])->withoutMiddleware([IsAdmin::class]);
    Route::get('/logout', [AdminController::class, 'logout']);

    // Quản lí khách hàng
    Route::get('/users', [UserController::class, 'users']);
    Route::get('/users/edit/{id}', [UserController::class, 'edit']);
    Route::put('/users/{id}/update', [UserController::class, 'update']);

    // Quản lí sản phẩm
    Route::get('/products', [ProductController::class, 'products']);
    Route::get('/products/add', [ProductController::class, 'add']);
    Route::post('/products/add/store', [ProductController::class, 'store']);
    Route::get('/products/edit/{id}', [ProductController::class, 'edit']);
    Route::put('/products/edit/{id}/update', [ProductController::class, 'update']);

    // Quản lí danh mục
    Route::get('/categories', [CategoryController::class, 'categories']);
    Route::get('/categories/add', [CategoryController::class, 'add']);
    Route::post('/categories/add/store', [CategoryController::class, 'store']);
    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit']);
    Route::put('/categories/edit/{id}/update', [CategoryController::class, 'update']);

    // Quản lí liên hệ
    Route::get('/contacts', [ContactController::class, 'contacts']);

    // Quản lí đơn hàng
    Route::get('/orders', [OrderController::class, 'orders']);
    Route::get('/orders/confirm/{id}', [OrderController::class, 'confirmOrder']);
    Route::get('/orders/deliveried/{id}', [OrderController::class, 'deliveryOrder']);
});


Route::fallback([SiteController::class, 'fallback']);