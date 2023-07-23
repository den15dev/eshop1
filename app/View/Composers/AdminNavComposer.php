<?php


namespace App\View\Composers;

use App\Services\Admin\OrderService;
use Illuminate\View\View;

class AdminNavComposer
{
    public function compose(View $view): void
    {
        $new_orders_num = (new OrderService())->checkForNewOrders();

        /**
         * [
         * name,
         * route name without 'admin' prefix,
         * bootstrap icon name,
         * badge count,
         * ]
         */
        $nav_items = [
            ['Статистика', 'dashboard', 'bar-chart', 0],
            ['Журнал', 'logs', 'book', 0],
            ['Товары', 'products', 'box', 0],
            ['Категории', 'categories', 'list-check', 0],
            ['Бренды', 'brands', 'star', 0],
            ['Акции', 'promos', 'percent', 0],
            ['Пользователи', 'users', 'person', 0],
            ['Отзывы', 'reviews', 'chat-left', 0],
            ['Заказы', 'orders', 'basket', $new_orders_num],
            ['Магазины', 'shops', 'geo-alt', 0],
        ];

        $view->with('nav_items', $nav_items);
    }
}
