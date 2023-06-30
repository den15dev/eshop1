<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\View\View;

class PromoController extends Controller
{
    public function show($promo_slug): View
    {
        $slug_id = parse_slug($promo_slug);

        $promo = Promo::findOrFail($slug_id[1]);

        if ($slug_id[0] !== $promo->slug) abort(404);

        $bread_crumb = [['Промо-акции']];

        $products = Product::where('promo_id', $slug_id[1])
            ->where('is_active', 1)
            ->get();

        return view('layout.promo', compact(
            'promo',
            'bread_crumb',
            'products'
        ));
    }
}
