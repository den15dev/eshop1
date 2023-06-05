<?php


namespace App\Services;

use Illuminate\Http\Request;

class UserService
{
    /**
     * Checks for cart, orders and favorites of a guest user.
     *
     * @param Request $request
     * @return array
     */
    public function getGuestActivitySettings(Request $request): array
    {
        $activity_settings = [];

        $cart = session('cart');
        if ($cart) $activity_settings['cart'] = $cart;
        $orders = json_decode($request->cookie('ord'));
        if ($orders) $activity_settings['orders'] = $orders;
        $favorites = json_decode($request->cookie('fav'));
        if ($favorites) $activity_settings['favorites'] = $favorites;

        return $activity_settings;
    }


    /**
     * Moves cart, orders and favorites of a guest user to database.
     *
     * @param Request $request
     */
    public function moveGuestActivitySettings(Request $request): void
    {
        $user_id = $request->user()->id;
        $user_email = $request->user()->email;

        if ($request->boolean('move_cart')) {
            (new CartService())->moveCartFromSessionToDB($user_id);
        }
        if ($request->boolean('move_orders')) {
            (new OrderService())->moveOrdersFromCookie($user_id, $user_email);
        }
        if ($request->boolean('move_favorites')) {
            (new FavoriteService())->moveFromCookieToDB($user_id);
        }
    }
}
