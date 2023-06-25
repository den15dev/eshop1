<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public static function create(): View
    {
        return view('admin.brands.create');
    }


    public static function store()
    {
        // return
    }


    public static function edit(string $id): View
    {
        $brand_id = $id;

        return view('admin.brands.edit', compact('brand_id'));
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
