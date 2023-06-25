<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public static function edit(string $id): View
    {
        $order_id = $id;

        return view('admin.orders.edit', compact('order_id'));
    }


    public static function update()
    {
        // return
    }


    public static function destroy()
    {
        // return
    }
}
