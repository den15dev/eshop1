<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Promo;
use App\Services\Admin\ProductService;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public static function create(): View
    {
        return view('admin.products.create');
    }


    public static function store(StoreProductRequest $request)
    {
        // return
    }


    public static function edit(
        CategoryService $categoryService,
        ProductService $productService,
        string $id
    ): View
    {
        $product = Product::find($id);
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
            $images_json = $request->input('images') ?: null;
            $images_arr = $images_json ? json_decode($images_json) : [];
            $images_db = $productService->getImages($id);

            $productService->removeImageFiles($id, $images_db, $images_arr);

            if ($request->hasFile('new_image')) {
                $new_name_base = $productService->getNewImageNameBase($images_db);
                $productService->saveImage($request, $id, $new_name_base);

                array_push($images_arr, $new_name_base);
                $images_json = json_encode($images_arr);
            }

            if (json_encode($images_db) !== $images_json) {
                Product::where('id', $id)->update(['images' => $images_json]);
            }

            $message = 'Изображения успешно обновлены.';
        }

        if ($request->has('specs')) {
            $new_category_id = $request->input('category_id');
            $old_category_id = $request->input('old_category_id');

            if ($new_category_id !== $old_category_id) {
                Product::where('id', $id)->update(['category_id' => $new_category_id]);
            }

            $input_specs = $productService->getInputSpecs(trim($request->input('specs')));

            // Check if a given input specification exists in the category. If not, remove it.
            $category_specs = $productService->getCategorySpecs($new_category_id);
            $input_specs = $input_specs->filter(function ($input_spec) use ($category_specs) {
                return $category_specs->contains('id', $input_spec->specification_id);
            });

            $current_specs = $productService->getProductSpecs($id);

            $productService->updateSpecs($id, $input_specs, $current_specs);

            $message = 'Характеристики успешно обновлены.';
        }

        if ($message) {
            $request->session()->flash('message', [
                'type' => 'info',
                'content' => $message,
                'align' => 'center',
            ]);
        }

        return back();
    }


    public static function destroy()
    {
        // return
    }


    public function ajax(Request $request, ProductService $productService)
    {
        if ($request->has('action')) {
            $action = camel_case($request->query('action'));

            if (method_exists($productService, $action)) {
                $query_arr = $request->query();
                unset($query_arr['action']);

                return call_user_func_array(array($productService, $action), $query_arr);
            }
        }

        return response(404);
    }
}
