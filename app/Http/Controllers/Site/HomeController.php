<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Site\PromoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $promos = PromoService::getActivePromos();

        $discounted = Product::discount()->get();
        $newest = Product::newest()->get();
        $popular = Product::popular()->get();

        return view('layout.home', compact('promos', 'discounted', 'newest', 'popular'));
    }
}
