<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'slider'], function () {
        Route::get('/', [SliderController::class, 'index'])->name('slider.index');
        Route::get('/trash', [SliderController::class, 'trash'])->name('slider.trash');
        Route::get('/create', [SliderController::class, 'create'])->name('slider.create');
        Route::post('/store', [SliderController::class, 'store'])->name('slider.store');
        Route::get('/{slider}/edit', [SliderController::class, 'edit'])->name('slider.edit');
        Route::get('/{slider}/restore', [SliderController::class, 'restore'])->name('slider.restore');
        Route::put('/{slider}/update', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
    });
    Route::group(['prefix' => 'feature'], function () {
        Route::get('/', [FeatureController::class, 'index'])->name('feature.index');
        Route::get('/create', [FeatureController::class, 'create'])->name('feature.create');
        Route::post('/store', [FeatureController::class, 'store'])->name('feature.store');
        Route::get('/{feature}/edit', [FeatureController::class, 'edit'])->name('feature.edit');
        Route::put('/{feature}/update', [FeatureController::class, 'update'])->name('feature.update');
        Route::delete('/{feature}', [FeatureController::class, 'destroy'])->name('feature.destroy');
    });
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
        Route::get('/trash', [CategoryController::class, 'trash'])->name('category.trash');
        Route::get('/create', [CategoryController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
        Route::get('/{category}/restore', [CategoryController::class, 'restore'])->name('category.restore');
        Route::put('/{category}/update', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    });

    Route::group(['prefix' => 'coupon'], function () {
        Route::get('/', [CouponController::class, 'index'])->name('coupon.index');
        Route::get('/trash', [CouponController::class, 'trash'])->name('coupon.trash');
        Route::get('/create', [CouponController::class, 'create'])->name('coupon.create');
        Route::post('/store', [CouponController::class, 'store'])->name('coupon.store');
        Route::get('/{coupon}/edit', [CouponController::class, 'edit'])->name('coupon.edit');
        Route::get('/{coupon}/restore', [CouponController::class, 'restore'])->name('coupon.restore');
        Route::put('/{coupon}/update', [CouponController::class, 'update'])->name('coupon.update');
        Route::delete('/{coupon}', [CouponController::class, 'destroy'])->name('coupon.destroy');
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/trash', [ProductController::class, 'trash'])->name('product.trash');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
        Route::get('/{product}/restore', [ProductController::class, 'restore'])->name('product.restore');
        Route::put('/{product}/update', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction.index');

    
    Route::group(['prefix' => 'users', 'middleware' => 'can:admin'], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('user.update');
    });

    Route::group(['prefix' => 'roles', 'middleware' => 'can:admin'], function () {
        Route::get('/', [RoleController::class, 'index'])->name('role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('/', [RoleController::class, 'store'])->name('role.store');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('role.edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('role.update');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
