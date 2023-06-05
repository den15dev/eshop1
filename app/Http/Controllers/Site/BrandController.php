<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\BrandService;
use Illuminate\View\View;

class BrandController extends Controller
{
    public function show(
        string $brand_slug,
        BrandService $brandService
    ): View
    {
        $brand = Brand::where('slug', $brand_slug)->firstOrFail();

        $categories = $brandService->groupProductsForBrand($brand->id);

        return view('layout.brand', compact('brand', 'categories'));
    }
}
