<?php


namespace App\Services;

use App\Http\Requests\NewOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Collection as ECollection;

class OrderService
{
    public function storeOrder(NewOrderRequest $request, $user_id, $cart_cost): Order
    {
        $validated = $request->validated();

        $order = new Order();
        $order->status = 'new';
        if ($user_id) { $order->user_id = $user_id; }
        $order->name = $validated['name'];
        $order->phone = $validated['phone'];
        if ($validated['email']) { $order->email = $validated['email']; }
        $order->payment_method = $request->payment_method;
        $order->items_cost = $cart_cost['final_total'];
        $order->total_cost = $cart_cost['final_total'];
        if ($request->delivery_type === 'delivery') {
            $order->delivery_type = 'delivery';
            $order->delivery_address = $request->delivery_address;
        } else {
            $order->delivery_type = 'self';
            $order->shop_id = $request->shop_id;
        }
        $order->save();

        return $order;
    }


    public function storeOrderItems($cartProducts, $order): void
    {
        foreach ($cartProducts as $product) {
            $order_item = new OrderItem();
            $order_item->product_id = $product->id;
            $order_item->order_id = $order->id;
            $order_item->quantity = $product->cart_qty;
            $order_item->price = $product->final_price;
            $order_item->save();
        }
    }


    public function getNewOrder($order_id, $user_id): Order|null
    {
        $order = null;
        if ($user_id) {
            $order = Order::where('id', $order_id)
                ->where('status', 'new')
                ->where('user_id', $user_id)
                ->with(['shop:id,address', 'orderItems', 'orderItems.product:id,name,slug,category_id,images'])
                ->first();
        } else {
            $order_ids = json_decode(request()->cookie('ord'));
            if (is_array($order_ids) && in_array($order_id, $order_ids)) {
                $order = Order::where('id', $order_id)
                    ->where('status', 'new')
                    ->with(['shop:id,address', 'orderItems', 'orderItems.product:id,name,slug,category_id,images'])
                    ->first();
            }
        }

        if ($order) {
            foreach ($order->orderItems as $orderItem) {
                $orderItem->cost = bcmul($orderItem->price, $orderItem->quantity);
            }
        }

        return $order;
    }



    public function getOrders(): ECollection
    {
        $orders = new ECollection([]);
        $user_id = Auth::id();

        if ($user_id) {
            $orders = Order::where('user_id', $user_id)
                ->with(['shop:id,address', 'orderItems', 'orderItems.product:id,name,slug,category_id,images'])
                ->get();
        } else {
            $order_ids = json_decode(request()->cookie('ord'));
            if (is_array($order_ids)) {
                $orders = Order::whereIn('id', $order_ids)
                    ->with(['shop:id,address', 'orderItems', 'orderItems.product:id,name,slug,category_id,images'])
                    ->get();
            }
        }

        if ($orders) {
            foreach ($orders as $order) {
                foreach ($order->orderItems as $orderItem) {
                    $orderItem->cost = bcmul($orderItem->price, $orderItem->quantity);
                }
            }
        }

        return $orders;
    }


    /**
     * Checks for all order states for indication on the navigation button.
     *
     * @return int - 0: no active orders,
     *               1: there are 'new' or 'accepted' orders,
     *               2: there are 'ready' or 'sent' orders.
     */
    public function checkForUncompleteOrders(): int
    {
        $current_state = 0;
        $orders = new ECollection([]);
        $user_id = Auth::id();

        if ($user_id) {
            $orders = Order::select('id', 'status')
                ->where('user_id', $user_id)
                ->get();
        } else {
            $order_ids = json_decode(request()->cookie('ord'));
            if (is_array($order_ids)) {
                $orders = Order::select('id', 'status')
                    ->whereIn('id', $order_ids)
                    ->get();
            }
        }

        if ($orders) {
            $state1 = $orders->filter(function($value) {
                return $value->status === 'new' || $value->status === 'accepted';
            })->count();

            if ($state1) {
                $current_state = 1;
            } else {
                $state2 = $orders->filter(function($value) {
                    return $value->status === 'ready' || $value->status === 'sent';
                })->count();

                if ($state2) {
                    $current_state = 2;
                }
            }
        }

        return  $current_state;
    }


    /**
     * After user authentication, takes order ids from cookie
     * and associate the orders in DB with the user.
     *
     * @param int $user_id
     * @param string $email
     * @return Void
     */
    public function moveOrdersFromCookie(int $user_id, string $email): Void
    {
        $orders = json_decode(request()->cookie('ord'));

        if ($orders) {
            foreach ($orders as $order_id) {
                $order = Order::find($order_id);
                $order->user_id = $user_id;
                if (!$order->email) {
                    $order->email = $email;
                }
                $order->save();
            }
            Cookie::expire('ord');
        }
    }
}
