<?php


namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BrandService
{
    /**
     * Gets and counts brands from a given category
     *
     * @param Category $category
     * @return Collection - collection of brands like {{id, name, product_num}, ... }
     */
    public function getByCategory(Category $category): Collection
    {
        return DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->selectRaw('products.brand_id as id, brands.name, COUNT(*) AS product_num')
            ->where('products.category_id', $category->id)
            ->groupBy('products.brand_id')
            ->orderBy('brands.name')
            ->get();
    }
}
