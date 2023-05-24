<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\PromoController;
use App\Http\Controllers\Site\BrandController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Admin\HomeController as AdmHomeController;
use App\Http\Controllers\Admin\ProductController as AdmProductController;
use App\Http\Controllers\Admin\CategoryController as AdmCategoryController;
use App\Http\Controllers\Admin\BrandController as AdmBrandController;
use App\Http\Controllers\Admin\UserController as AdmUserController;
use App\Http\Controllers\Admin\OrderController as AdmOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog/{category}', [CategoryController::class, 'index'])->name('category');
Route::get('/catalog/{category}/{product}', [ProductController::class, 'show'])->name('product');
Route::post('/catalog/{category}/{product}', [ReviewController::class, 'store'])->name('review.add');
Route::get('/promo/{promo}', [PromoController::class, 'show'])->name('promo');
Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brand');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

require __DIR__.'/auth.php';



Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdmHomeController::class, 'index'])->name('home');
    Route::get('/products', [AdmProductController::class, 'index'])->name('products');
    Route::get('/categories', [AdmCategoryController::class, 'index'])->name('categories');
    Route::get('/brands', [AdmBrandController::class, 'index'])->name('brands');
    Route::get('/users', [AdmUserController::class, 'index'])->name('users');
    Route::get('/orders', [AdmOrderController::class, 'index'])->name('orders');

});


// Route::get('/handle-images', [\App\Http\Controllers\Temp\ImageHandleController::class, 'handle']);
