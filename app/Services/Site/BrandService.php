<?php


namespace App\Services\Site;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BrandService
{
    /**
     * Get brands with product count for a given category
     *
     * @param int $category_id
     * @return Collection - collection of objects with parameters {id, name, product_num}
     */
    public function groupProductsForCategory(int $category_id): Collection
    {
        return DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->selectRaw('products.brand_id as id, brands.name, COUNT(*) AS product_num')
            ->where('products.category_id', $category_id)
            ->groupBy('products.brand_id')
            ->orderBy('brands.name')
            ->get();
    }


    /**
     * Get categories with product count for a given brand
     *
     * @param int $brand_id
     * @return Collection
     */
    public function groupProductsForBrand(int $brand_id): Collection
    {
        return DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->selectRaw('categories.name, categories.slug, count(*) as products_total')
            ->where('brand_id', $brand_id)
            ->groupBy('category_id')
            ->get();
    }
}
