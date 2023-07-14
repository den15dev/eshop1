<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Models\Brand;
use App\Http\Requests\Admin\StoreBrandRequest;
use App\Services\Admin\ImageService as AdminImageService;
use Illuminate\View\View;

class BrandController extends Controller
{
    public static function create(): View
    {
        return view('admin.brands.create');
    }


    public static function store(
        StoreBrandRequest $request,
        AdminImageService $admImageService
    ) {
        $validated = $request->validated();

        $brand = new Brand();
        $brand->name = $validated['name'];
        $brand->slug = $validated['slug'];
        $brand->description = $validated['description'];
        $brand->save();

        $admImageService->saveImageBySlug(
            'brands',
            $request->file('image'),
            $brand->slug
        );

        $request->flashMessage('Бренд ' . $brand->name . ' добавлен.');

        return redirect()->route('admin.brands');
    }


    public static function edit(string $id): View
    {
        $brand = Brand::find($id);

        return view('admin.brands.edit', compact('brand'));
    }


    public static function update(
        StoreBrandRequest $request,
        AdminImageService $admImageService,
        int $id
    ) {
        $message = '';

        if ($request->has('name')) {
            $validated = $request->validated();
            Brand::where('id', $id)->update($validated);

            $admImageService->renameImageBySlug(
                'brands',
                $validated['slug'],
                $request->input('slug_old')
            );

            $message = 'Бренд обновлён.';
        }

        if ($request->hasFile('image')) {
            $admImageService->saveImageBySlug(
                'brands',
                $request->file('image'),
                $request->input('slug')
            );

            $message = 'Изображение обновлено.';
        }

        $request->flashMessage($message);

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        AdminImageService $admImageService,
        int $id
    ) {
        $brand = Brand::find($id);
        $brand->delete();
        $admImageService->deleteImageBySlug('brands', $brand->slug);

        $request->flashMessage('Бренд ' . $brand->name . ' удалён.');

        return redirect()->route('admin.brands');
    }
}
