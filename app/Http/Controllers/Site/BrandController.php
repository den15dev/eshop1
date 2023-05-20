<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function show(string $brand_slug): View
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();

        return view('layout.brand', compact('brand'));
    }
}
