<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Http\Requests\Admin\StorePromoRequest;
use App\Models\Product;
use App\Models\Promo;
use App\Services\Admin\ImageService as AdminImageService;
use App\Services\Admin\PromoService;
use Illuminate\View\View;

class PromoController extends Controller
{
    public static function create(): View
    {
        return view('admin.promos.create');
    }


    public static function store(
        StorePromoRequest $request,
        PromoService $promoService
    ) {
        $promo = $promoService->createPromo($request);

        $request->flashMessage('Акция ' . $promo->name . ' успешно добавлена.');

        return redirect()->route('admin.promos');
    }


    public static function edit(PromoService $promoService, string $id): View
    {
        $promo = $promoService->getPromoWithProducts($id);

        return view('admin.promos.edit', compact('promo'));
    }


    public static function update(
        StorePromoRequest $request,
        PromoService $promoService,
        int $id
    ) {
        $message = '';

        if ($request->has('name')) {
            $promoService->updateMainData($request, $id);

            $message = 'Акция успешно обновлена.';
        }

        if ($request->hasFile('image')) {
            $promoService->updateImage($request, $id);

            $message = 'Изображение успешно обновлено.';
        }

        if ($request->has('add_products')) {
            $id_list = parse_comma_list($request->validated('add_products'));
            if ($id_list) {
                Product::whereIn('id', $id_list)->update(['promo_id' => $id]);
                $message = 'Товары успешно добавлены.';
            }
        }

        $request->flashMessage($message);

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        AdminImageService $admImageService,
        int $id
    ) {
        $promo = Promo::find($id);
        $promo->delete();
        $admImageService->deleteImageByName('promos', $id, $promo->image);

        $request->flashMessage('Акция ' . $promo->name . ' успешно удалена.');

        return redirect()->route('admin.promos');
    }
}
