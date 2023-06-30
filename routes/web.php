<?php

use App\Http\Controllers\Site\DeliveryController;
use App\Http\Controllers\Site\ShopController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\PromoController;
use App\Http\Controllers\Site\BrandController;
use App\Http\Controllers\Site\ReviewController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\OrderController;
use App\Http\Controllers\Site\SearchController;
use App\Http\Controllers\Site\ComparisonController;
use App\Http\Controllers\Site\FavoriteController;
use App\Http\Controllers\Site\UserProfileController;
use App\Http\Controllers\Site\UserNotificationController;

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

Route::post('/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::get('/new-order/{order_id}', [OrderController::class, 'showNew'])->whereNumber('order_id')->name('new-order');
Route::get('/orders', [OrderController::class, 'index'])->name('orders');

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/autocomplete', [SearchController::class, 'autocomplete'])->name('search.autocomplete');

Route::get('/comparison', [ComparisonController::class, 'index'])->name('comparison');
Route::post('/comparison/remove', [ComparisonController::class, 'remove'])->name('comparison.remove');
Route::post('/comparison/clear', [ComparisonController::class, 'clear'])->name('comparison.clear');

Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites');

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/notifications', [UserNotificationController::class, 'index'])->name('notifications');
});

Route::get('/delivery', DeliveryController::class)->name('delivery');
Route::get('/shops', ShopController::class)->name('shops');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

// Route::get('/handle-images', [\App\Http\Controllers\Temp\ImageHandleController::class, 'handle']);
