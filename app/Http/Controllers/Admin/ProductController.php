<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public static function create(): View
    {
        return view('admin.products.create');
    }


    public static function store()
    {
        // return
    }


    public static function edit(string $id): View
    {
        $product = Product::with('specifications')->find($id);

        return view('admin.products.edit', compact('product'));
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
