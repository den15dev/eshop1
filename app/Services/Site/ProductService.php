<?php


namespace App\Services\Site;

use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class ProductService
{
    /**
     * Gets a product with brand data.
     *
     * @param int $product_id
     * @return Product
     */
    public function getProduct(int $product_id): Product
    {
        return Product::with('brand:id,name,slug')->find($product_id);
    }


    /**
     * Gets a collection of recently viewed products from DB preserving a giving order.
     *
     * @param array|null $ids - product ids or null in case of empty cookie array.
     * @param int $exclude_id - product id that must be excluded from results.
     * @return Collection - will be empty in case of empty cookie array.
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
            $recently_viewed = Product::whereIn('id', $ids)
                ->orderByRaw('FIELD(id, ' . implode(', ', $ids) . ')')
                ->get();
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
     * @param HasMany|EBuilder $filtered_query
     * @return array
     */
    public function getPriceMinMax(HasMany|EBuilder $filtered_query): array
    {
        $priceMinMax = ['', ''];
        $prices = $filtered_query->get()->pluck('final_price');

        if ($prices) {
            $priceMinMax = [$prices->min(), $prices->max()];
        }
        return $priceMinMax;
    }
}
