<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BaseRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Promo;
use App\Services\Admin\ProductService;
use App\Services\Admin\CategoryService;
use Illuminate\View\View;

class ProductController extends Controller
{
    public static function create(
        CategoryService $categoryService,
        ProductService $productService,
    ): View
    {
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $promos = Promo::select('id', 'name')->orderBy('created_at')->get();
        $categories = $categoryService->getEndCategories();
        $spec_list = $productService->getProductSpecList($categories[0]->id);

        return view('admin.products.create', compact(
            'brands',
            'promos',
            'categories',
            'spec_list',
        ));
    }


    public static function store(StoreProductRequest $request, ProductService $productService)
    {
        $product = $productService->saveProduct($request);
        $productService->saveImages($request, $product->id);
        $productService->saveSpecifications($request->input('specs'), $product->category_id, $product->id);

        $request->flashMessage('Товар ' . $product->id . ' успешно создан.');

        return redirect()->route('admin.products');
    }


    public static function edit(
        CategoryService $categoryService,
        ProductService $productService,
        string $id
    ): View
    {
        $product = Product::find($id);
        if (!$product) abort(404);
        $brands = Brand::select('id', 'name')->orderBy('name')->get();
        $promos = Promo::select('id', 'name')->orderBy('created_at')->get();
        $categories = $categoryService->getEndCategories();
        $spec_list = $productService->getProductSpecList($product->category_id, $product->id);

        return view('admin.products.edit', compact(
            'product',
            'brands',
            'promos',
            'categories',
            'spec_list'
        ));
    }


    public static function update(
        StoreProductRequest $request,
        ProductService $productService,
        string $id
    )
    {
        $message = '';

        if ($request->has('name')) {
            Product::where('id', $id)->update($request->validated());
            $message = 'Товар успешно обновлён.';
        }

        if ($request->has('images')) {
            $productService->updateImages($request, $id);

            $message = 'Изображения успешно обновлены.';
        }

        if ($request->has('specs')) {
            $category_id = $request->input('category_id');
            $productService->updateCategoryId($id, $category_id);
            $productService->saveSpecifications($request->input('specs'), $category_id, $id);

            $message = 'Характеристики успешно обновлены.';
        }

        $request->flashMessage($message);

        return back();
    }


    public static function destroy(
        BaseRequest $request,
        ProductService $productService,
        int $id
    )
    {
        $product = Product::find($id);
        $product->delete();
        $productService->deleteImages($id);

        $request->flashMessage('Товар ' . $id . ' успешно удалён.');

        return redirect()->route('admin.products');
    }
}
