<?php


namespace App\Services;

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
}
