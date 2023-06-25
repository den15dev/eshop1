<?php


namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexService
{
    /**
     * @var array|array[] - [
     *     <column>,
     *     <title>,
     *     <align - start/end/center(default)>,
     *     <is sortable>,
     *     <current order>,
     *     <is searchable>
     * ]
     */
    private static array $products = [
        ['id', 'id', '', true, false, true],
        ['images', '', '', false, false, false],
        ['name', 'Наименование', 'start', true, false, true],
        ['is_active', 'Активно', '', true, false, false],
        ['discount_prc', 'Скидка %', '', true, false, false],
        ['final_price', 'Цена, ₽', '', true, false, false],
    ];

    private static array $brands = [
        ['id', 'id', '', true, false, true],
        ['name', 'Название', '', true, false, true],
        ['slug', '', '', false, false, false], // An image with a name by the slug will be output
    ];

    private static array $promos = [
        ['id', 'id', '', true, false, true],
        ['image', '', '', false, false, false],
        ['name', 'Название', 'start', true, false, true],
        ['until', 'Дата окончания', '', true, false, false],
        ['is_active', 'Активно', '', true, false, false],
    ];

    private static array $users = [
        ['id', 'id', '', true, false, true],
        ['image', '', '', false, false, false],
        ['name', 'Имя', '', true, false, true],
        ['role', 'Роль', '', true, false, false],
        ['email', 'Email', '', true, false, true],
        ['is_active', 'Активно', '', true, false, false],
    ];

    private static array $orders = [
        ['id', 'id', '', true, false, true],
        ['status', 'Статус', '', true, false, false],
        ['name', 'Имя', '', true, false, true],
//        ['phone', 'Телефон', '', false, false, true],
//        ['payment_status', 'Статус оплаты', '', false, false, false],
        ['delivery_type', 'Способ получения', '', false, false, false],
        ['total_cost', 'Стоимость, ₽', '', true, false, false],
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
                    $column[4] = $request->query('order_dir');
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
     * @return EBuilder
     */
    public function buildTableQuery(
        string $table,
        Request $request
    ): EBuilder
    {
        $table_settings = self::getTableSettings($table, $request);

        $col_list = [];
        foreach ($table_settings as $column) {
            array_push($col_list, $column[0]);
        }

        $model_name = 'App\\Models\\' . Str::studly(Str::singular($table));
        $result_query = $model_name::select($col_list);

        $order_by = ['id', 'desc'];

        if ($request) {
            $is_active = $request->query('is_active');
            if ($is_active !== null) {
                $result_query = $result_query->where('is_active', $is_active);
            }

            $search_query = $request->query('query');
            if ($search_query) {
                $result_query = $result_query->where(function (EBuilder $query) use ($table_settings, $search_query) {

                    $col_index = 0;
                    foreach ($table_settings as $column) {
                        if ($column[5]) {

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
