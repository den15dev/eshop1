<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\IndexService;
use App\Services\Admin\CategoryService as AdmCategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __invoke(Request $request, IndexService $indexService): View
    {
        $route_suffix = substr($request->route()->getName(), strlen('admin.'));
        $table_name = $request->query('table') ?? $route_suffix;

        $columns = IndexService::getTableSettings($table_name, $request);

        $table_query = $indexService->buildTableQuery($table_name, $request);

        $per_page = $indexService->getTablePerPageNum($request);
        $table_data = $table_query->paginate($per_page);

        $data = [
            'table_name',
            'columns',
            'table_data',
            'per_page',
        ];

        if ($table_name === 'products' && $route_suffix !== 'search') {
            $categories = (new AdmCategoryService())->getEndCategories();
            array_push($data, 'categories');
        }

        $view = $route_suffix === 'search' ?
            'admin.includes.index-table' :
            'admin.' . $table_name . '.index';

        return view($view, compact($data));
    }
}
