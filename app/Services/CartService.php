<?php


namespace App\Services;

use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    private static null|array $cart = null;

    public static function getCart(): array
    {
        if (self::$cart === null) {
            self::$cart = [];
            $user_id = Auth::id();
            if ($user_id) {
                $cart_items = CartItem::where('user_id', $user_id)
                    ->orderBy('created_at')
                    ->get();
                if ($cart_items) {
                    foreach ($cart_items as $cart_item) {
                        self::$cart[$cart_item->product_id] = [$cart_item->quantity, $cart_item->created_at];
                    }
                }
            } else {
                if (session()->has('cart')) {
                    self::$cart = session('cart');
                }
            }
        }
        return self::$cart;
    }


    public function addToCart(int $product_id, int $qty): array
    {
        $cart = self::getCart();
        $time = time();
        if (array_key_exists($product_id, $cart)) {
            $cart[$product_id][0] = $qty;
            $time = $cart[$product_id][1];
        } else {
            $cart[$product_id] = [$qty, $time];
        }
        self::$cart = $cart;

        $user_id = Auth::id();
        if ($user_id) {
            CartItem::updateOrCreate(
                ['product_id' => $product_id, 'user_id' => $user_id],
                ['quantity' => $qty, 'created_at' => $time]
            );
        } else {
            session(['cart' => $cart]);
        }

        return $cart;
    }


    public function removeFromCart(int $product_id): array
    {
        $cart = self::getCart();
        if (array_key_exists($product_id, $cart)) {
            unset($cart[$product_id]);
        }
        self::$cart = $cart;

        $user_id = Auth::id();
        if ($user_id) {
            DB::table('cart_items')
                ->where('product_id', $product_id)
                ->where('user_id', $user_id)
                ->delete();
        } else {
            $cart ? session(['cart' => $cart]) : session()->forget('cart');
        }

        return $cart;
    }


    public function moveCartFromSessionToDB(int $user_id): void
    {
        if (session()->has('cart')) {
            $cart = session('cart');
            foreach ($cart as $product_id => $qty_stamp) {
                CartItem::updateOrCreate(
                    ['product_id' => $product_id, 'user_id' => $user_id],
                    ['quantity' => $qty_stamp[0], 'created_at' => $qty_stamp[1]]
                );
            }
            session()->forget('cart');
        }
    }
}
