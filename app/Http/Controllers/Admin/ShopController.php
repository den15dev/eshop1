<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Http\Requests\Admin\StoreShopRequest;
use App\Services\Admin\ShopService;
use App\Models\Shop;
use Illuminate\View\View;

class ShopController extends Controller
{
    public static function create(ShopService $shopService): View
    {
        $shops_order = $shopService->getSortCollection();
        $hours_list = $shopService->getHoursList();

        return view('admin.shops.create', compact(
            'shops_order',
            'hours_list'
        ));
    }


    public static function store(
        StoreShopRequest $request,
        ShopService $shopService
    ) {
        $shop = $shopService->create($request);
        $request->flashMessage('Магазин ' . $shop->name . ' добавлен.');

        return redirect()->route('admin.shops');
    }


    public static function edit(
        ShopService $shopService,
        int $id
    ): View {
        $shop = Shop::find($id);
        $shops_order = Shop::select('id', 'sort')->orderBy('sort')->get();
        $hours_list = $shopService->getHoursList($shop->opening_hours);

        return view('admin.shops.edit', compact(
            'shop',
            'shops_order',
            'hours_list'
        ));
    }


    public static function update(
        StoreShopRequest $request,
        ShopService $shopService,
        int $id
    ) {
        $shopService->update($request, $id);
        $request->flashMessage('Магазин обновлён.');

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        int $id
    ) {
        $shop = Shop::find($id);
        $shop->delete();
        Shop::where('sort', '>', $shop->sort)->decrement('sort');

        $request->flashMessage('Магазин ' . $shop->name . ' удалён.');

        return redirect()->route('admin.shops');
    }
}
