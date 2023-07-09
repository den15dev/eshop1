<?php


namespace App\Services\Admin;

use Illuminate\Database\Eloquent\Builder as EBuilder;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IndexService
{
    /**
     * Gets given table settings, updates current sorting order
     *
     * @param string $table
     * @param Request $request
     * @return array
     */
    public static function getTableSettings(string $table, Request $request): array
    {
        $serviceClass = 'App\\Services\\Admin\\' . Str::studly(Str::singular($table)) . 'Service';
        $settings = $serviceClass::$table_settings;

        if ($request->query('order_by')) {
            foreach ($settings as &$column) {
                $column['order_dir'] = $column['column'] === $request->query('order_by')
                    ? $request->query('order_dir')
                    : false;
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
            array_push($col_list, $column['column']);
        }

        $model_name = 'App\\Models\\' . Str::studly(Str::singular($table));
        $result_query = $model_name::select($col_list);

        $order_by = ['id', 'desc'];

        // For reviews: show only not empty reviews
        if ($table === 'reviews') {
            $result_query = $result_query->where(function(EBuilder $query) {
                $query = $query->whereNotNull('pros')
                    ->orWhereNotNull('cons')
                    ->orWhereNotNull('comnt');
            });
        }

        if ($request) {
            $is_active = $request->query('is_active');
            if ($is_active !== null) {
                $result_query = $result_query->where('is_active', $is_active);
            }

            $order_status = $request->query('order_status');
            if ($order_status !== null) {
                $result_query = $result_query->where('status', $order_status);
            }

            $search_query = $request->query('query');
            if ($search_query) {
                $result_query = $result_query->where(function (EBuilder $query) use ($table_settings, $search_query) {

                    $col_index = 0;
                    foreach ($table_settings as $column) {
                        if ($column['is_searchable']) {

                            $pattern = mb_strlen($search_query) === 1 ? $search_query : '%' . $search_query . '%';

                            if ($col_index) {
                                $query = $query->orWhere($column['column'], 'like', $pattern);
                            } else {
                                $query = $query->where($column['column'], 'like', $pattern);
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
