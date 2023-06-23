<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\Site\ShopService;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function __invoke(ShopService $shopService): View
    {
        $shops = Shop::where('is_active', 1)->orderBy('sort')->get();

        $shops_json = $shopService->getJSON($shops);

        return view('layout.shops', compact('shops', 'shops_json'));
    }
}
