<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Models\Order;
use App\Services\Admin\OrderService;
use Illuminate\View\View;

class OrderController extends Controller
{
    public static function edit(int $id): View
    {
        $order = Order::with(['shop:id,address', 'orderItems', 'orderItems.product:id,name,slug,category_id,images'])
            ->find($id);

        foreach ($order->orderItems as $orderItem) {
            $orderItem->cost = bcmul($orderItem->price, $orderItem->quantity);
        }

        return view('admin.orders.edit', compact('order'));
    }


    public static function update(
        BaseRequest $request,
        OrderService $orderService,
        int $id
    ) {
        $status = $request->input('status');
        $status_str = $request->input('status_str');

        $order = Order::find($id);
        $order->status = $status;
        $order->save();

        $orderService->sendSiteNotification($order);

        $request->flashMessage('Статус заказа ' . $id . ' изменён на "' . $status_str . '".');

        return back();
    }
}
