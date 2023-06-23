<?php


namespace App\Services\Site;

use Illuminate\Database\Eloquent\Collection as ECollection;

class ShopService
{
    public function getJSON(ECollection $shops): string
    {
        $shops_data = [];
        foreach ($shops as $shop) {
            array_push($shops_data, [
                $shop->id,
                [$shop->name, $shop->address, 'Пн-Пт: 9:00 - 21:00'],
                json_decode($shop->location),
            ]);
        }

        return json_encode($shops_data, JSON_UNESCAPED_UNICODE);
    }
}
