<?php

namespace App\Http\Livewire;

use App\Services\Site\CartService;
use Livewire\Component;

class AddToCartSmallBtn extends Component
{
    public int $product_id;
    public int|null $in_cart = null; // Actual quantity in cart, or null if the product not in cart

    const BTN_NORMAL_CLASS = 'btn2-primary';
    const BTN_IN_CART_CLASS = 'btn2-red';
    public string $btn_color_class;

    const BTN_TITLE = 'В корзину';
    const BTN_TITLE_IN = 'В корзине';
    public string $btn_title;

    const TITLE_REMOVE_HINT = ' title="Удалить из корзины"';
    public string $title_attr = '';


    public function mount()
    {
        $cartService = new CartService();
        $this->in_cart = $cartService->isInCart($this->product_id);

        $this->in_cart ? $this->makeInCartBtn() : $this->makeNormalBtn();
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
    }


    public function updateCart()
    {
        $cartService = new CartService();

        if ($this->in_cart) {
            $cart_count = count($cartService->removeFromCart($this->product_id));
            $this->makeNormalBtn();
            $this->in_cart = null;
        } else {
            $cart_count = count($cartService->addToCart($this->product_id, 1));
            $this->makeInCartBtn();
            $this->in_cart = 1;
        }

        $this->emit('updateCartBadge', $cart_count);
    }


    public function render()
    {
        return view('livewire.add-to-cart-small-btn');
    }
}
