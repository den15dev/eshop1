<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(
        DashboardService $dashboardService
    ): View {
        $current_year = intval(date('Y'));
        $current_month = intval(date('n'));
        $years = $dashboardService->getYears();
        $months = $dashboardService->getMonths($current_year);

        $category_id = 0;
        $dashboard = $dashboardService->getDashboard($current_year, $current_month, $category_id);

        return view('admin.dashboard.index', compact(
            'current_year',
            'current_month',
            'years',
            'months',
            'dashboard',
            'category_id'
        ));
    }
}
