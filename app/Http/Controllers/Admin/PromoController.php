<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PromoController extends Controller
{
    public static function create(): View
    {
        return view('admin.promos.create');
    }


    public static function store()
    {
        // return
    }


    public static function edit(string $id): View
    {
        $promo_id = $id;

        return view('admin.products.edit', compact('promo_id'));
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
