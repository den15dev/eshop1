<?php


namespace App\Services\Admin;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexService
{
    /**
     * @var array|array[] - [<column>, <title>, <is sortable>, <current order>, <is searchable>]
     */
    private static array $products = [
        ['id', 'id', true, false, true],
        ['images', '', false, false, false],
        ['name', 'Наименование', true, false, true],
        ['is_active', 'Активно', true, false, false],
        ['discount_prc', 'Скидка %', true, false, false],
        ['final_price', 'Цена', true, false, false],
    ];


    /**
     * Gets given table settings, updates current sorting order
     *
     * @param string $table
     * @param Request $request
     * @return array
     */
    public static function getTableSettings(string $table, Request $request): array
    {
        $settings = self::$$table;

        if ($request->query('order_by')) {
            foreach ($settings as &$column) {
                if ($column[0] === $request->query('order_by')) {
                    $column[3] = $request->query('order_dir');
                }
            }
        }

        return $settings;
    }


    /**
     * Builds a DB query when a live searching requested
     *
     * @param string $table
     * @param Request $request
     * @return Builder
     */
    public function buildTableQuery(
        string $table,
        Request $request
    ): Builder
    {
        $table_settings = self::getTableSettings($table, $request);

        $col_list = [];
        foreach ($table_settings as $column) {
            array_push($col_list, $column[0]);
        }

        $result_query = DB::table($table)
            ->select($col_list);

        $order_by = ['id', 'desc'];

        if ($request) {
            $is_active = $request->query('is_active');
            if ($is_active !== null) {
                $result_query = $result_query->where('is_active', $is_active);
            }

            $search_query = $request->query('query');
            if ($search_query) {
                $result_query = $result_query->where(function (Builder $query) use ($table_settings, $search_query) {

                    $col_index = 0;
                    foreach ($table_settings as $column) {
                        if ($column[4]) {

                            if ($col_index) {
                                $query = $query->orWhere($column[0], 'like', '%' . $search_query . '%');
                            } else {
                                $query = $query->where($column[0], 'like', '%' . $search_query . '%');
                            }

                        }
                        $col_index++;
                    }
                });
            }

            $order_query = $request->query('order_by');
            if ($order_query !== null) {
                $order_by = [$request->query('order_by'), $request->query('order_dir')];
            }
        }

        return $result_query->orderBy($order_by[0], $order_by[1]);
    }


    /**
     * Gets number table rows per page
     *
     * @param Request $request
     * @return int
     */
    public function getTablePerPageNum(Request $request): int
    {
        $tbl_ppage = 10; // Default
        $cookie = $request->cookie('tbl_ppage');
        if ($cookie) {
            $tbl_ppage = intval($cookie);
        } else {
            // Set cookie on 5 years with disabled "HttpOnly" parameter.
            // The cookie encryption should be disabled in
            // EncryptCookies.php middleware in protected $except property.
            // All these should be done for cookie can be read by javascript on a client.
            Cookie::queue('tbl_ppage', $tbl_ppage, 2628000, null, null, false, false);
        }
        return $tbl_ppage;
    }
}
