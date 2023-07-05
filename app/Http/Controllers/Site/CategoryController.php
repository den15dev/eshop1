<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Site\BrandService;
use App\Services\Site\CategoryService;
use App\Services\Site\ProductService;
use App\Services\Site\SpecificationService;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(
        CategoryService $categoryService,
        BrandService $brandService,
        ProductService $productService,
        SpecificationService $specService,
        string $category_slug
    ): View
    {
        $category = $categoryService->getCategories()->where('slug', $category_slug)->first();
        if (!$category) abort(404);

        $children = $categoryService->getChildren($category->id);
        $bread_crumb = $categoryService->getBreadCrumb($category);

        if ($children->isNotEmpty()) {
            return view('layout.category', compact(
                'category',
                'children',
                'bread_crumb'
            ));
        }

        $filter_specs = $specService->getFilterSpecs($category);
        $brands = $brandService->groupProductsForCategory($category->id);

        $layout = $categoryService->getLayoutSettings();

        $filtered_query = $categoryService->buildFilteredQuery($category, $layout[0]);

        $priceMinMax = $productService->getPriceMinMax($filtered_query);

        $products = $filtered_query->paginate($layout[1]);

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));

        return view('layout.products', compact(
            'category',
            'bread_crumb',
            'layout',
            'brands',
            'products',
            'priceMinMax',
            'filter_specs',
            'recently_viewed'
        ));
    }
}
