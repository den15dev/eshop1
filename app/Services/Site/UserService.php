<?php


namespace App\Services\Site;

use App\Http\Requests\ProfileUpdateRequest;
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


    public function saveUserImage(ProfileUpdateRequest $request): void
    {
        $user_img_dir = storage_path('app/public/images/users/' . $request->user()->id);

        // If a user image directory doesn't exists create it
        if (!is_dir($user_img_dir)) {
            mkdir($user_img_dir);
        } else {
            // otherwise clear it.
            $old_images = array_diff(scandir($user_img_dir), array('..', '.'));
            foreach ($old_images as $old_image) {
                unlink($user_img_dir . '/' . $old_image);
            }
        }

        $source_path = $request->file('user_image')->path();
        $orig_name = $request->file('user_image')->getClientOriginalName();
        $out_path = $user_img_dir . '/' . $orig_name;

        ImageService::saveToSquare($source_path, $out_path, 200, false);
        ImageService::saveToSquare($source_path, $out_path, 38, 'thumbnail');

        $request->user()->update(['image' => $orig_name]);
    }
}
