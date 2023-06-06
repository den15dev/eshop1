<?php


namespace App\View\Composers;

use App\Services\CategoryService;
use App\Services\OrderService;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        $header_data = [
            'category_tree' => (new CategoryService())->buildMenu(),
            'orders' => (new OrderService())->checkForUncompleteOrders(),
        ];

        $view->with('header', $header_data);
    }
}
