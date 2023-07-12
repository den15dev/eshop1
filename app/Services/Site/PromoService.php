<?php


namespace App\Services\Site;


use App\Models\Promo;
use Illuminate\Database\Eloquent\Collection as ECollection;

class PromoService
{
    private static ECollection|null $active_promos = null;

    public static function getActivePromos(): ECollection|null
    {
        if (self::$active_promos === null) {
            self::$active_promos = Promo::select('id', 'name', 'slug', 'image')
                ->whereDate('started_at', '<=', now()->toDateString())
                ->whereDate('until', '>=', now()->toDateString())
                ->get();
        }

        return self::$active_promos;
    }
}
