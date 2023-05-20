<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $promos = Promo::all();

        $discounted = Product::discount()->get();
        $latest = Product::latest()->get();
        $popular = Product::popular()->get();

        return view('layout.home', compact('promos', 'discounted', 'latest', 'popular'));
    }
}
