<?php


namespace App\Services\Site;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


class CategoryService
{
    private static Collection $categories;


    public function getCategories(): Collection
    {
        if (!isset(self::$categories)) {
            self::$categories = $this->getCategoriesCounted();
        }

        return self::$categories;
    }


    /**
     * Gets categories counting all products in each category.
     *
     * Adds 2 properties to model:
     * 'products_self' - number of products in this category only.
     * 'products_total' - number of products in this category and all
     * children categories.
     *
     * @return Collection
     */
    public function getCategoriesCounted(): Collection
    {
        $categories_counted = Category::selectRaw('categories.*, COUNT(products.category_id) AS products_self')
            ->leftJoin('products', 'products.category_id', '=', 'categories.id')
            ->groupBy('products.category_id', 'categories.id')
            ->orderBy('id')
            ->get()
            ->map(function ($cat) {
                $cat->products_total = 0;
                return $cat;
            });

        foreach ($categories_counted as $category) {
            $cur_category = $category;
            $parent_id = $cur_category->parent_id;

            $prod_self = $cur_category->products_self;
            $cur_category->products_total += $prod_self;

            while ($parent_id) {
                $parent = $categories_counted->where('id', $cur_category->parent_id)->first();
                $parent->products_total += $prod_self;

                $cur_category = $parent;
                $parent_id = $cur_category->parent_id;
            }
        }

        return $categories_counted;
    }



    /**
     * Gets children categories (without sub-children) for a given category.
     *
     * @param Category $category - parent category
     * @return Collection
     */
    public function getChildren(Category $category): Collection
    {
        return $this->getCategories()->filter(function ($child) use ($category) {
            return $child->parent_id === $category->id;
        });
    }



    /**
     * Creates an array of [name, slug] for breadcrumbs.
     *
     * @param $last_item - last child item, a product or a category
     * @return array[] - like [[name, slug], [name, slug], [name]]
     */
    public function getBreadCrumb($last_item): array
    {
        $bread_crumb = [[$last_item->name]];
        $categories = $this->getCategories();

        $parent = null;
        if ($last_item instanceof Product) {
            $parent = $categories->firstWhere('id', $last_item->category_id);
        } elseif ($last_item instanceof Category) {
            $parent = $categories->firstWhere('id', $last_item->parent_id);
        }

        while ($parent) {
            array_unshift($bread_crumb, [$parent->name, $parent->slug]);
            $parent = $categories->firstWhere('id', $parent->parent_id);
        };

        return $bread_crumb;
    }



    /**
     * Creates multidimensional array of Categories.
     *
     * Gets Categories from DB, creates an array of nested categories according
     * their "parent_id" column values, and sorts by "sort" column values.
     *
     * @return array - like [[id, name, slug, <array of children>], ...].
     */
    public function buildMenu(): array
    {
        $menu_arr = [];
        $categories = $this->getCategories();

        $sortCmp = function ($a, $b) {
            if ($a[0] == $b[0]) { return 0; }
            return ($a[0] < $b[0]) ? -1 : 1;
        };

        function menuLoop($categories, $menu_arr, $category, $sortCmp): array
        {
            $cur_arr = [$category->sort, $category->id, $category->name, $category->slug, $category->products_total];

            $children = [];
            foreach ($categories as $child) {
                if ($child->parent_id === $category->id) {
                    $children = menuLoop($categories, $children, $child, $sortCmp);
                }
            }
            if (count($children) > 0) {
                // Sort and clear sort keys
                uasort($children, $sortCmp);
                foreach ($children as &$child) array_shift($child);

                array_push($cur_arr, $children);
            }

            array_push($menu_arr, $cur_arr);

            return $menu_arr;
        }


        foreach ($categories as $category) {
            if ($category->parent_id === 0) {
                $menu_arr = menuLoop($categories, $menu_arr, $category, $sortCmp);
            }
        }

        uasort($menu_arr, $sortCmp);
        foreach ($menu_arr as &$child) array_shift($child);

        return $menu_arr;
    }


    /**
     * Builds a DB query for a given category considering all filter conditions.
     *
     * @param Category $category
     * @param int $order_by
     * @return HasMany
     */
    public function buildFilteredQuery(Category $category, int $order_by): HasMany
    {
        $price_min = parse_price(request('price_min'));
        $price_max = parse_price(request('price_max'));

        $req_brands = request('brands') ? array_keys(request('brands')) : [];

        $filter_query = $category->products()
            ->select('id', 'name', 'slug', 'category_id', 'short_descr', 'price', 'discount_prc', 'final_price', 'rating', 'vote_num', 'images')
            ->when($price_min, function (EBuilder $query, string $price_min) {
                $query->where('final_price', '>=', $price_min);
            })
            ->when($price_max, function (EBuilder $query, string $price_max) {
                $query->where('final_price', '<=', $price_max);
            })
            ->when($req_brands, function (EBuilder $query, array $req_brands) {
                $query->whereIn('brand_id', $req_brands);
            })
            ->where('is_active', 1);

        if (request('specs')) {
            $req_specs = request('specs');

            $key0 = array_keys($req_specs)[0];
            $spec_product_ids = DB::table('product_specification')->selectRaw('product_id, COUNT(*) AS dups')
                ->where('specification_id', $key0)
                ->whereIn('spec_value', $req_specs[$key0]);

            foreach ($req_specs as $key => $spec) {
                if ($key !== $key0) {
                    $spec_product_ids = $spec_product_ids->orWhere(function (Builder $query) use ($key, $spec) {
                        $query->where('specification_id', $key)
                            ->whereIn('spec_value', $spec);
                    });
                }
            }

            $spec_product_ids = $spec_product_ids->groupBy('product_id')
                ->get()
                ->filter(function ($value) use ($req_specs) {
                    return $value->dups === count($req_specs);
                })
                ->pluck('product_id');

            $filter_query = $filter_query->whereIn('id', $spec_product_ids);

        }

        return self::orderQuery($filter_query, $order_by);
    }


    public static function orderQuery(HasMany|EBuilder $query, int $order_by): HasMany|EBuilder
    {
        return match ($order_by) {
            1 => $query->orderBy('final_price', 'asc'),
            2 => $query->orderBy('final_price', 'desc'),
            3 => $query->orderBy('created_at', 'desc'),
            4 => $query->orderBy('vote_num', 'desc'),
            5 => $query->orderBy('discount_prc', 'desc'),
        };
    }


    /**
     * Gets values for "Sort products by:", "Show per page:",
     * and "Tile/List layout" settings.
     *
     * @return int[]
     */
    public function getLayoutSettings(): array
    {
        $layout_arr = [3, 12, 1];
        $cookie = Request::cookie('layout');
        if ($cookie) {
            $layout_arr = json_decode($cookie);
            if (!in_array($layout_arr[1], [12, 24, 36, 48])) {
                $layout_arr[1] = 12;
            }
        } else {
             // Set cookie on 5 years with disabled "HttpOnly" parameter.
             // The cookie encryption should be disabled in
             // EncryptCookies.php middleware in protected $except property.
             // All these should be done for cookie can be read by javascript on a client.
             Cookie::queue('layout', json_encode($layout_arr), 2628000, null, null, false, false);
        }
        return $layout_arr;
    }
}
