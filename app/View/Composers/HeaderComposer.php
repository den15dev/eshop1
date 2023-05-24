<?php


namespace App\View\Composers;

use App\Services\CategoryService;
use Illuminate\View\View;

class HeaderComposer
{
    public function compose(View $view): void
    {
        $menu_data = [
            'menu_catalog' => (new CategoryService())->buildMenu(),
            'comparison' => 0,
            'favourites' => 0,
            'orders' => false,
        ];

        $view->with('menu_data', $menu_data);
    }
}
