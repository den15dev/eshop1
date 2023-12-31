<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewOrderRequest;
use App\Services\Site\CartService;
use App\Services\Site\OrderService;
use App\Services\Site\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function create(
        CartService $cartService,
        NewOrderRequest $request
    )
    {
        $products = $cartService->getCartProducts();

        // Check if all products still active (in stock)
        $inactive_list = $cartService->getInactive($products);
        if (count($inactive_list)) {
            $request->session()->flash('message', [
                'type' => 'info',
                'content' => 'К сожалению, следующие товары закончились:<br>' . implode('<br>', $inactive_list),
                'align' => 'start',
            ]);

            return back();
        }

        $cart_cost = $cartService->getCartCost($products);
        $order = null;

        DB::transaction(function () use (
            $cartService,
            $products,
            $cart_cost,
            &$order,
            $request
        ) {
            $orderService = new OrderService();
            $order = $orderService->storeOrder($request, $cart_cost);
            $orderService->storeOrderItems($products, $order);
            $orderService->saveMissingUserData($request);
            $cartService->clearCart();
        }, 3);

        // Set cookie with order list if user is not authorized
        if (!$request->user()) {
            $order_ids = json_decode($request->cookie('ord')) ?? [];
            array_push($order_ids, $order->id);
            Cookie::queue('ord', json_encode($order_ids), 2628000); // 5 years
        }

        Log::channel('events')->info('<span class=\'fw-semibold text-color-main2\'>Создан новый заказ №' . $order->id . '.</span>');

        return redirect()->route('new-order', $order->id);
    }


    public function showNew(OrderService $orderService, $order_id)
    {
        $user_id = Auth::id();
        $order = $orderService->getNewOrder($order_id, $user_id);

        if (!$order) return redirect()->route('orders');

        return view('layout.order-new', compact('order'));
    }


    public function index(OrderService $orderService, ProductService $productService)
    {
        $orders = $orderService->getOrders();

        if ($orders->count()) {
            return view('layout.orders', compact('orders'));
        }

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));

        return view('layout.orders', compact('orders', 'recently_viewed'));
    }
}
