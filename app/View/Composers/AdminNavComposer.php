<?php


namespace App\View\Composers;

use Illuminate\View\View;

class AdminNavComposer
{
    public function compose(View $view): void
    {
        // [name, route name without 'admin' prefix, bootstrap icon name]
        $nav_items = [
            ['Главная', 'home', 'house'],
            ['Товары', 'products', 'box'],
            ['Категории', 'categories', 'list-check'],
            ['Бренды', 'brands', 'star'],
            ['Акции', 'promos', 'percent'],
            ['Пользователи', 'users', 'person'],
            ['Заказы', 'orders', 'basket'],
        ];

        $view->with('nav_items', $nav_items);
    }
}
