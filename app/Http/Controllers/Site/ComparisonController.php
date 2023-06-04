<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\ComparisonService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ComparisonController extends Controller
{
    public function index(
        ComparisonService $comparisonService,
        ProductService $productService
    ): View
    {
        $products = $comparisonService->getProducts(true);

        if ($products) {
            $category_id = $comparisonService->get()[0];
            $specs = $comparisonService->getCategorySpecs($category_id);

            return view('layout.comparison', compact('products', 'specs'));
        }

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));

        return view('layout.comparison', compact('recently_viewed'));
    }


    public function remove(Request $request, ComparisonService $comparisonService)
    {
        $product_id = $request->input('product_id');
        $comparisonService->remove($product_id);

        return response('ok', 200)->header('Content-Type', 'text/plain');
    }


    public function clear(Request $request, ComparisonService $comparisonService)
    {
        if ($request->input('action') == 'clear') {
            $comparisonService->clear();
            return response('ok', 200)->header('Content-Type', 'text/plain');
        }

        return response('Bad request', 400)->header('Content-Type', 'text/plain');
    }
}
