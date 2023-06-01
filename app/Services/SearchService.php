<?php


namespace App\Services;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection as ECollection;

class SearchService
{
    /**
     * Counts total search results in brands and products.
     *
     * @param string $search_str
     * @return \stdClass - object with 'brands' and 'products' properties.
     */
    public function countResults(string $search_str): \stdClass
    {
        return DB::select(
            'SELECT
            (SELECT COUNT(*) FROM brands WHERE name LIKE \'%' . $search_str . '%\') AS brands,
            (SELECT COUNT(*) FROM products WHERE name LIKE \'%' . $search_str . '%\') AS products'
        )[0];
    }


    public function getBrandsForAutocomplete(string $search_str, int $limit): ECollection
    {
        return Brand::select('id', 'name', 'slug')
            ->where('name', 'like', '%' . $search_str . '%')
            ->limit($limit)
            ->get();
    }


    public function getProductsForAutocomplete(string $search_str, int $limit): ECollection
    {
        return Product::select('id', 'name', 'slug', 'category_id', 'final_price', 'images')
            ->where('name', 'like', '%' . $search_str . '%')
            ->limit($limit)
            ->get();
    }


    public function buildFilteredQuery(string $query_str, int $order_by): HasMany|EBuilder
    {
        $price_min = parse_price(request('price_min'));
        $price_max = parse_price(request('price_max'));

        $req_brands = request('brands') ? array_keys(request('brands')) : [];
        $req_categories = request('categories') ? array_keys(request('categories')) : [];

        $filter_query = Product::select('id', 'name', 'slug', 'category_id', 'short_descr', 'price', 'discount_prc', 'final_price', 'rating', 'vote_num', 'images')
            ->where('name', 'like', '%' . $query_str . '%')
            ->when($price_min, function (EBuilder $query, string $price_min) {
                $query->where('final_price', '>=', $price_min);
            })
            ->when($price_max, function (EBuilder $query, string $price_max) {
                $query->where('final_price', '<=', $price_max);
            })
            ->when($req_brands, function (EBuilder $query, array $req_brands) {
                $query->whereIn('brand_id', $req_brands);
            })
            ->when($req_categories, function (EBuilder $query, array $req_categories) {
                $query->whereIn('category_id', $req_categories);
            })
            ->where('is_active', 1);

        return CategoryService::orderQuery($filter_query, $order_by);
    }


    /**
     * Get brands with product count for a given search criteria
     *
     * @param string $query_str
     * @return Collection
     */
    public function groupProductsByBrand(string $query_str): Collection
    {
        return DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->selectRaw('products.brand_id as id, brands.name, COUNT(*) AS product_num')
            ->where('products.name', 'like', '%' . $query_str . '%')
            ->groupBy('products.brand_id')
            ->orderBy('brands.name')
            ->get();
    }


    /**
     * Get categories with product count for a given search criteria
     *
     * @param string $query_str
     * @return Collection
     */
    public function groupProductsByCategory(string $query_str): Collection
    {
        return DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('products.category_id as id, categories.name, COUNT(*) AS product_num')
            ->where('products.name', 'like', '%' . $query_str . '%')
            ->groupBy('products.category_id')
            ->orderBy('categories.name')
            ->get();
    }
}
