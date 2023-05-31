<?php


namespace App\Services;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    private static null|array $cart = null;

    /**
     * Gets cart array either from session or from db (in case user is authenticated).
     *
     * @return array - array where keys are product ids,
     *                 and values are array [quantity, timestamp].
     *                 Empty array if cart is empty.
     */
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


    /**
     * Returns product's quantity in cart or null if the product not in cart.
     *
     * @param int $product_id
     * @return int|null
     */
    public function isInCart(int $product_id): int|null
    {
        $cart = self::getCart();
        if (array_key_exists($product_id, $cart)) {
            return $cart[$product_id][0];
        }
        return null;
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


    /**
     * Removes given product from cart.
     *
     * @param int $product_id
     * @return array - the cart.
     */
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


    public function clearCart(): void
    {
        $user_id = Auth::id();
        if ($user_id) {
            DB::table('cart_items')
                ->where('user_id', $user_id)
                ->delete();
        } else {
            session()->forget('cart');
        }
        self::$cart = null;
    }


    /**
     * After user authentication, moves its cart from session to DB.
     *
     * @param int $user_id
     */
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


    public function getCartProducts(): ECollection
    {
        $cart = self::getCart();

        if ($cart) {
            $products = Product::select('id', 'name', 'slug', 'category_id', 'short_descr', 'price', 'discount_prc', 'final_price', 'images')
                ->whereIn('id', array_keys($cart))
                ->get();

            foreach ($cart as $product_id => $qty_time) {
                $product = $products->firstWhere('id', $product_id);
                $product->cart_created_at = $qty_time[1];
                $product->cart_qty = $qty_time[0];
                $product->cost = bcmul($product->price, $qty_time[0]);
                $product->final_cost = bcmul($product->final_price, $qty_time[0]);
            }

            return $products->sortBy('cart_created_at');
        }

        return new ECollection([]);
    }


    public function getCartItem(int $product_id)
    {
        $cart = self::getCart();

        $product = Product::select('id', 'name', 'slug', 'category_id', 'short_descr', 'price', 'discount_prc', 'final_price', 'images')
            ->firstWhere('id', $product_id);

        $product->cart_created_at = $cart[$product_id][1];
        $product->cart_qty = $cart[$product_id][0];
        $product->cost = bcmul($product->price, $cart[$product_id][0]);
        $product->final_cost = bcmul($product->final_price, $cart[$product_id][0]);

        return $product;
    }


    /**
     * Returns 2-elements array - ['total' => ..., 'final_total' => ...].
     *
     * @param ECollection $products
     * @return array|string[]
     */
    public function getCartCost(ECollection $products): array
    {
        $cost = [
            'total' => '0',
            'final_total' => '0',
        ];

        $products->each(function (Product $item) use (&$cost) {
            $cost['total'] = bcadd($cost['total'], $item->cost);
            $cost['final_total'] = bcadd($cost['final_total'], $item->final_cost);
        });

        return $cost;
    }
}
