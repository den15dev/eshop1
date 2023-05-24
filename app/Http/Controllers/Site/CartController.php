<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\ProductService;
use Illuminate\View\View;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(CartService $cartService, ProductService $productService): View
    {
        $products = $cartService->getCartProducts();

        $cart_cost = $cartService->getCartCost($products);

        $recently_viewed = collect([]);
        if (!$products->count()) {
            $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));
        }

        return view('layout.cart', compact(
            'products',
            'cart_cost',
            'recently_viewed'
        ));
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
