<?php


namespace App\Services;


use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class FavoritesService
{
    private static array|null $favorites = null;

    public function get(): array
    {
        if (self::$favorites === null) {
            $user_id = Auth::id();
            if ($user_id) {
                self::$favorites = Favorite::select('id', 'product_id')
                    ->where('user_id', $user_id)
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->pluck('product_id')
                    ->all();
            } else {
                self::$favorites = $this->getFromCookie() ?? [];
            }
        }

        return self::$favorites;
    }


    public function isInList(int $product_id): bool
    {
        $favorites = $this->get();

        if ($favorites && in_array($product_id, $favorites)) {
            return true;
        }

        return false;
    }


    public function add(int $product_id): array
    {
        $favorites = $this->get();
        if (!in_array($product_id, $favorites)) {
            array_unshift($favorites, $product_id);
        }

        $user_id = Auth::id();
        if ($user_id) {
            Favorite::firstOrCreate(
                ['product_id' => $product_id, 'user_id' => $user_id]
            );
        } else {
            $this->setCookie($favorites);
        }

        self::$favorites = $favorites;

        return $favorites;
    }


    public function remove(int $product_id): array
    {
        $favorites = $this->get();
        $index = array_search($product_id, $favorites);
        if ($index !== false) {
            array_splice($favorites, $index, 1);
        }

        $user_id = Auth::id();
        if ($user_id) {
            DB::table('favorites')
                ->where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->delete();
        } else {
            $favorites ? $this->setCookie($favorites) : $this->clearCookie();
        }

        self::$favorites = $favorites;

        return $favorites;
    }


    public function moveFromCookieToDB(int $user_id)
    {
        $favorites = $this->getFromCookie();

        if ($favorites) {
            foreach ($favorites as $product_id) {
                Favorite::firstOrCreate(
                    ['product_id' => $product_id, 'user_id' => $user_id]
                );
            }

            $this->clearCookie();
        }
    }


    private function getFromCookie(): array|null
    {
        return json_decode(Request::cookie('fav'));
    }


    private function setCookie($favorites): void
    {
        Cookie::queue('fav', json_encode($favorites), 2628000); // 5 years
    }


    private function clearCookie(): void
    {
        Cookie::expire('fav');
    }
}
