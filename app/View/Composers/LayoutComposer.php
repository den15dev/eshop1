<?php


namespace App\View\Composers;

use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class LayoutComposer
{
    public function compose(View $view): void
    {
        $is_first_visit = false;
        if (!request()->cookie('vis')) {
            Cookie::queue('vis', 1, 2628000);
            $is_first_visit = true;
        }

        $view->with('is_first_visit', $is_first_visit);
    }
}
