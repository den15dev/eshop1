<?php


namespace App\Services\Site;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\Collection as ECollection;

class ComparisonService
{
    /**
     * The first element of the comparison array is a category id.
     * The second element is an array of product ids.
     *
     * @return array|null
     */
    public function get(): array|null
    {
        return json_decode(Request::cookie('compare'));
    }


    public function getProducts(bool $with_specs = false): ECollection|null
    {
        $products = null;
        $comparison_arr = $this->get();

        if ($comparison_arr) {
            $products = Product::select('id', 'name', 'slug', 'category_id', 'final_price', 'images')
                ->where('is_active', 1)
                ->whereIn('id', $comparison_arr[1])
                ->when($with_specs, function ($query) {
                    $query->with('specifications');
                })
                ->orderByRaw('FIELD(id, ' . implode(', ', $comparison_arr[1]) . ')')
                ->get();
        }

        return $products;
    }


    public function getCategorySpecs(int $category_id): ECollection
    {
        return Category::find($category_id)
            ->specifications()
            ->orderBy('sort')
            ->get();
    }


    public function isInList(int $product_id): bool
    {
        $comparison_arr = json_decode(Request::cookie('compare'));

        if (is_array($comparison_arr) && in_array($product_id, $comparison_arr[1])) {
            return true;
        }

        return false;
    }


    public function add(int $product_id, int $category_id, int $limit = 10): array
    {
        $comparison_arr = [$category_id, [$product_id]];
        $cookie_arr = json_decode(Request::cookie('compare'));

        if ($cookie_arr && $cookie_arr[0] === $category_id) {
            $comparison_arr = $cookie_arr;

            if (!in_array($product_id, $comparison_arr[1])) {
                array_push($comparison_arr[1], $product_id);

                while (count($comparison_arr[1]) > $limit) {
                    array_shift($comparison_arr[1]);
                }
            }
        }

        $this->setCookie($comparison_arr);

        return $comparison_arr;
    }


    public function remove(int $product_id): array|null
    {
        $comparison_arr = json_decode(Request::cookie('compare'));

        if ($comparison_arr) {
            $index = array_search($product_id, $comparison_arr[1]);
            if ($index !== false) {
                array_splice($comparison_arr[1], $index, 1);
            }

            if (count($comparison_arr[1])) {
                $this->setCookie($comparison_arr);
                return $comparison_arr;
            } else {
                $this->clear();
            }
        }

        return null;
    }


    public function setCookie(array $comparison): void
    {
        // Set cookie on 30 days with disabled "HttpOnly" parameter.
        // The cookie encryption should be disabled in
        // EncryptCookies.php middleware in protected $except property.
        // All these should be done for cookie can be read by javascript on a client.
        Cookie::queue('compare', json_encode($comparison), 43200, null, null, false, false);
    }


    public function clear(): void
    {
        Cookie::expire('compare');
    }
}
