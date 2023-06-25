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
use App\Http\Controllers\Admin\IndexController as AdmIndexController;
use App\Http\Controllers\Admin\HomeController as AdmHomeController;
use App\Http\Controllers\Admin\ProductController as AdmProductController;
use App\Http\Controllers\Admin\CategoryController as AdmCategoryController;
use App\Http\Controllers\Admin\BrandController as AdmBrandController;
use App\Http\Controllers\Admin\PromoController as AdmPromoController;
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


Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [AdmHomeController::class, 'index'])->name('home');

    Route::get('/search', AdmIndexController::class)->name('search');

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

    Route::get('/orders', AdmIndexController::class)->name('orders');
    Route::get('/orders/{id}/edit', [AdmOrderController::class, 'edit'])->whereNumber('id')->name('orders.edit');
    Route::put('/orders/{id}', [AdmOrderController::class, 'update'])->whereNumber('id')->name('orders.update');
    Route::delete('/orders/{id}', [AdmOrderController::class, 'destroy'])->whereNumber('id')->name('orders.destroy');
});


// Route::get('/handle-images', [\App\Http\Controllers\Temp\ImageHandleController::class, 'handle']);
