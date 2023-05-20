<?php


namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class ProductService
{
    /**
     * Builds a query to get a Product with brand_name and brand_slug.
     *
     * @param int $product_id
     * @return Product
     */
    public function getProduct(int $product_id): Product
    {
        return Product::select(
            'products.*',
            'brands.name as brand_name',
            'brands.slug as brand_slug'
        )->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->where('products.id', $product_id)
            ->firstOrFail();
    }


    /**
     * Gets a collection of recently viewed products from DB preserving a giving order.
     *
     * @param array|null $ids - product ids or null in case of empty session variable.
     * @param int $exclude_id - product id that must be excluded from results.
     * @return Collection - will be empty in case of empty session variable.
     */
    public function getRecentlyViewed(array|null $ids, int $exclude_id = 0): Collection
    {
        $recently_viewed = collect([]);

        if ($ids && $exclude_id) {
            $ids = array_values(array_filter($ids, function ($e) use ($exclude_id) {
                return $e !== $exclude_id;
            }));
        }

        if ($ids) {
            // Keeping order
            $orderByStr = 'FIELD(id';
            foreach ($ids as $id) {
                $orderByStr .= ', ' . $id;
            }
            $orderByStr .= ')';
            $recently_viewed = Product::whereIn('id', $ids)->orderByRaw($orderByStr)->get();
        }

        return $recently_viewed;
    }



    /**
     * Adds a new product id to 'rct_viewed' cookie array for 1 day.
     *
     * @param int $product_id
     * @param int $limit - maximum number of products in the array.
     */
    public function addToRecentlyViewed(int $product_id, int $limit = 10): void
    {
        $recently_viewed_arr = [$product_id];
        $cookie_arr = json_decode(Request::cookie('rct_viewed'));

        if ($cookie_arr) {
            $recently_viewed_arr = $cookie_arr;
            if (!in_array($product_id, $recently_viewed_arr)) {
                array_unshift($recently_viewed_arr, $product_id);
                $recently_viewed_arr = array_slice($recently_viewed_arr, 0, $limit);
            }
        }

        Cookie::queue('rct_viewed', json_encode($recently_viewed_arr), 1440);
    }



    /**
     * Gets min and max prices of a given query.
     *
     * @param HasMany $filtered_query
     * @return array
     */
    public function getPriceMinMax(HasMany $filtered_query): array
    {
        $priceMinMax = ['', ''];
        $prices = $filtered_query->get()->pluck('final_price');

        if ($prices) {
            $priceMinMax = [$prices->min(), $prices->max()];
        }
        return $priceMinMax;
    }
}
