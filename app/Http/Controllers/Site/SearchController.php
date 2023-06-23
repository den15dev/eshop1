<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Services\Site\CategoryService;
use App\Services\Site\ProductService;
use App\Services\Site\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function autocomplete(Request $request, SearchService $searchService): View
    {
        $query_str = $request->query('query');

        $total = $searchService->countResults($query_str);
        $brands = $searchService->getBrandsForAutocomplete($query_str, 6);
        $products = $searchService->getProductsForAutocomplete($query_str, 6);

        return view('layout.search-autocomplete', compact(
            'brands',
            'products',
            'total',
            'query_str'
        ));
    }


    public function index(
        Request $request,
        CategoryService $categoryService,
        ProductService $productService,
        SearchService $searchService
    ): View
    {
        $query_str = $request->query('query');

        $brands = $searchService->groupProductsByBrand($query_str);
        $categories = $searchService->groupProductsByCategory($query_str);

        $layout = $categoryService->getLayoutSettings();

        $filtered_query = $searchService->buildFilteredQuery($query_str, $layout[0]);

        $priceMinMax = $productService->getPriceMinMax($filtered_query);

        $products = $filtered_query->paginate($layout[1]);

        $bread_crumb = [['Результаты поиска по запросу "' . $query_str . '" (' . $products->total() . ')']];

        $recently_viewed = $productService->getRecentlyViewed(json_decode(request()->cookie('rct_viewed')));

        return view('layout.search', compact(
            'bread_crumb',
            'query_str',
            'layout',
            'brands',
            'categories',
            'products',
            'priceMinMax',
            'recently_viewed'
        ));
    }
}
