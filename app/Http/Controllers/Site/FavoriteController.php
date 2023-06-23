<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Site\FavoriteService;
use App\Services\Site\ProductService;
use Illuminate\View\View;

class FavoriteController extends Controller
{
    public function index(
        FavoriteService $favoriteService,
        ProductService $productService
    ): View
    {
        $products = $favoriteService->getProducts();

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));

        return view('layout.favorites', compact(
            'products',
            'recently_viewed'
        ));
    }
}
