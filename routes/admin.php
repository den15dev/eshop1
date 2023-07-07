<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController as AdmIndexController;
use App\Http\Controllers\Admin\HomeController as AdmHomeController;
use App\Http\Controllers\Admin\ProductController as AdmProductController;
use App\Http\Controllers\Admin\CategoryController as AdmCategoryController;
use App\Http\Controllers\Admin\BrandController as AdmBrandController;
use App\Http\Controllers\Admin\PromoController as AdmPromoController;
use App\Http\Controllers\Admin\UserController as AdmUserController;
use App\Http\Controllers\Admin\ReviewController as AdmReviewController;
use App\Http\Controllers\Admin\OrderController as AdmOrderController;
use App\Http\Controllers\Admin\AjaxController;


Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdmHomeController::class, 'index'])->name('home');

    Route::get('/search', AdmIndexController::class)->name('search');
    Route::get('/ajax', AjaxController::class)->name('ajax');

    Route::get('/products', AdmIndexController::class)->name('products');
    Route::get('/products/create', [AdmProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdmProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdmProductController::class, 'edit'])->whereNumber('id')->name('products.edit');
    Route::put('/products/{id}', [AdmProductController::class, 'update'])->whereNumber('id')->name('products.update');
    Route::delete('/products/{id}', [AdmProductController::class, 'destroy'])->whereNumber('id')->name('products.destroy');

    Route::get('/categories', [AdmCategoryController::class, 'index'])->name('categories');
    Route::get('/categories/create', [AdmCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [AdmCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdmCategoryController::class, 'edit'])->whereNumber('id')->name('categories.edit');
    Route::put('/categories/{id}', [AdmCategoryController::class, 'update'])->whereNumber('id')->name('categories.update');
    Route::delete('/categories/{id}', [AdmCategoryController::class, 'destroy'])->whereNumber('id')->name('categories.destroy');

    Route::get('/brands', AdmIndexController::class)->name('brands');
    Route::get('/brands/create', [AdmBrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [AdmBrandController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [AdmBrandController::class, 'edit'])->whereNumber('id')->name('brands.edit');
    Route::put('/brands/{id}', [AdmBrandController::class, 'update'])->whereNumber('id')->name('brands.update');
    Route::delete('/brands/{id}', [AdmBrandController::class, 'destroy'])->whereNumber('id')->name('brands.destroy');

    Route::get('/promos', AdmIndexController::class)->name('promos');
    Route::get('/promos/create', [AdmPromoController::class, 'create'])->name('promos.create');
    Route::post('/promos', [AdmPromoController::class, 'store'])->name('promos.store');
    Route::get('/promos/{id}/edit', [AdmPromoController::class, 'edit'])->whereNumber('id')->name('promos.edit');
    Route::put('/promos/{id}', [AdmPromoController::class, 'update'])->whereNumber('id')->name('promos.update');
    Route::delete('/promos/{id}', [AdmPromoController::class, 'destroy'])->whereNumber('id')->name('promos.destroy');

    Route::get('/users', AdmIndexController::class)->name('users');
    Route::get('/users/{id}/edit', [AdmUserController::class, 'edit'])->whereNumber('id')->name('users.edit');
    Route::put('/users/{id}', [AdmUserController::class, 'update'])->whereNumber('id')->name('users.update');
    Route::delete('/users/{id}', [AdmUserController::class, 'destroy'])->whereNumber('id')->name('users.destroy');

    Route::get('/reviews', AdmIndexController::class)->name('reviews');
    Route::get('/reviews/{id}/edit', [AdmReviewController::class, 'edit'])->whereNumber('id')->name('reviews.edit');
    Route::put('/reviews/{id}', [AdmReviewController::class, 'update'])->whereNumber('id')->name('reviews.update');
    Route::delete('/reviews/{id}', [AdmReviewController::class, 'destroy'])->whereNumber('id')->name('reviews.destroy');

    Route::get('/orders', AdmIndexController::class)->name('orders');
    Route::get('/orders/{id}/edit', [AdmOrderController::class, 'edit'])->whereNumber('id')->name('orders.edit');
    Route::put('/orders/{id}', [AdmOrderController::class, 'update'])->whereNumber('id')->name('orders.update');
    Route::delete('/orders/{id}', [AdmOrderController::class, 'destroy'])->whereNumber('id')->name('orders.destroy');
});
