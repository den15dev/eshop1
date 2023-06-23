<?php

namespace App\Http\Livewire;

use App\Services\Site\CartService;
use Livewire\Component;

class AddToCartBigBtn extends Component
{
    public int $product_id;
    public int $quantity; // The quantity shown in the +/- input
    public int|null $in_cart = null; // Actual quantity in cart, or null if the product not in cart

    const BTN_NORMAL_CLASS = 'btn2-primary';
    const BTN_IN_CART_CLASS = 'btn2-red';
    public string $btn_color_class;

    const BTN_TITLE = 'В корзину';
    const BTN_TITLE_IN = 'В корзине';
    public string $btn_title;

    const TITLE_REMOVE_HINT = ' title="Удалить из корзины"';
    public string $title_attr = '';

    protected $listeners = ['updateQuantity'];


    public function mount()
    {
        $this->quantity = $this->in_cart ?? 1;
        $this->in_cart ? $this->makeInCartBtn() : $this->makeNormalBtn();
    }


    public function updateQuantity(int $quantity)
    {
        $this->quantity = $quantity;

        if ($quantity && $this->in_cart) {
            $cartService = new CartService();
            $cartService->addToCart($this->product_id, $this->quantity);
            $this->in_cart = $quantity;
        }
    }


    private function makeInCartBtn(): void
    {
        $this->btn_color_class = self::BTN_IN_CART_CLASS;
        $this->btn_title = self::BTN_TITLE_IN;
        $this->title_attr = self::TITLE_REMOVE_HINT;
    }


    private function makeNormalBtn(): void
    {
        $this->btn_color_class = self::BTN_NORMAL_CLASS;
        $this->btn_title = self::BTN_TITLE;
        $this->title_attr = '';
    }


    public function updateCart()
    {
        $cartService = new CartService();

        if ($this->in_cart) {
            $cart_count = count($cartService->removeFromCart($this->product_id));
            $this->makeNormalBtn();
            $this->in_cart = null;
        } else {
            $cart_count = count($cartService->addToCart($this->product_id, $this->quantity));
            $this->makeInCartBtn();
            $this->in_cart = $this->quantity;
        }

        $this->emit('updateCartBadge', $cart_count);
    }


    public function render()
    {
        return view('livewire.add-to-cart-big-btn');
    }
}
