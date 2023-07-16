<?php


namespace App\View\Composers;

use Illuminate\View\View;

class AdminNavComposer
{
    public function compose(View $view): void
    {
        // [name, route name without 'admin' prefix, bootstrap icon name]
        $nav_items = [
            ['Статистика', 'dashboard', 'bar-chart'],
            ['Товары', 'products', 'box'],
            ['Категории', 'categories', 'list-check'],
            ['Бренды', 'brands', 'star'],
            ['Акции', 'promos', 'percent'],
            ['Пользователи', 'users', 'person'],
            ['Отзывы', 'reviews', 'chat-left'],
            ['Заказы', 'orders', 'basket'],
            ['Магазины', 'shops', 'geo-alt'],
        ];

        $view->with('nav_items', $nav_items);
    }
}
