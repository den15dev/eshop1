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
            'comparison' => 2,
            'favourites' => 3,
            'orders' => true,
        ];

        $view->with('menu_data', $menu_data);
    }
}
