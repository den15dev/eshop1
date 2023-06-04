<?php


namespace App\View\Composers;

use App\Services\CategoryService;
use App\Services\OrderService;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        $menu_data = [
            'menu_catalog' => (new CategoryService())->buildMenu(),
            'orders' => (new OrderService())->checkForUncompleteOrders(),
        ];

        $view->with('menu_data', $menu_data);
    }
}
