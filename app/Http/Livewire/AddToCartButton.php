<?php

namespace App\Http\Livewire;

use App\Services\CartService;
use Livewire\Component;

class AddToCartButton extends Component
{
    public string $size;
    public int $product_id; // Product id
    public int $quantity = 1;
    public bool $is_in_cart = false;

    const BTN_CLASS = 'addtocart_btn';
    const BTN_CLASS_BIG = 'addtocart_big_btn';
    public string $btn_class;

    const BTN_BLUE_CLASS = 'btn2-primary';
    const BTN_RED_CLASS = 'btn2-red';
    public string $btn_color_class;

    const BTN_TITLE = 'В корзину';
    const BTN_TITLE_IN = 'В корзине <span class="fw-lighter opacity-75">(';
    public string $btn_title;

    const TITLE_REMOVE_HINT = ' title="Удалить из корзины"';
    public string $title_attr = '';

    protected $listeners = ['updateQuantity'];

    public function mount()
    {
        $this->size === 'big' ? $this->btn_class = self::BTN_CLASS_BIG : $this->btn_class = self::BTN_CLASS;

        $cart = CartService::getCart();
        if (array_key_exists($this->product_id, $cart)) {
            $this->is_in_cart = true;
            $this->quantity = $cart[$this->product_id][0];
        }

        $this->is_in_cart ? $this->makeInCartBtn() : $this->makeNormalBtn();
    }


    public function updateQuantity(int $quantity)
    {
        $this->quantity = $quantity;
    }


    private function makeInCartBtn(): void
    {
        $this->btn_color_class = self::BTN_RED_CLASS;
        $this->btn_title = self::BTN_TITLE_IN . $this->quantity . ')</span>';
        $this->title_attr = self::TITLE_REMOVE_HINT;
    }


    private function makeNormalBtn(): void
    {
        $this->btn_color_class = self::BTN_BLUE_CLASS;
        $this->btn_title = self::BTN_TITLE;
    }


    public function updateCart()
    {
        $cartService = new CartService();

        if ($this->is_in_cart) {
            $cart_count = count($cartService->removeFromCart($this->product_id));
            $this->makeNormalBtn();
            $this->is_in_cart = false;
        } else {
            $cart_count = count($cartService->addToCart($this->product_id, $this->quantity));
            $this->makeInCartBtn();
            $this->is_in_cart = true;
        }

        $this->emit('updateCartBadge', $cart_count);
    }


    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
