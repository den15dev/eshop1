<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Site\CartService;
use App\Services\Site\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cartService, ProductService $productService): View
    {
        $products = $cartService->getCartProducts();

        if ($products->count()) {
            $cart_cost = $cartService->getCartCost($products);
            $shops = Shop::where('is_active', 1)->get();
            $user = Auth::user();

            return view('layout.cart', compact(
                'products',
                'cart_cost',
                'user',
                'shops',
            ));
        }

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));

        return view('layout.cart', compact('recently_viewed'));

    }


    public function remove(Request $request, CartService $cartService)
    {
        $product_id = $request->input('product_id');
        $cartService->removeFromCart($product_id);

        return response('ok', 200)->header('Content-Type', 'text/plain');
    }


    public function clear(Request $request, CartService $cartService)
    {
        if ($request->input('action') == 'clear') {
            $cartService->clearCart();
            return response('ok', 200)->header('Content-Type', 'text/plain');
        }

        return response('Bad request', 400)->header('Content-Type', 'text/plain');
    }
}
