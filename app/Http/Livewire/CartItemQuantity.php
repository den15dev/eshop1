<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartItemQuantity extends Component
{
    public $product;
    public string|int $qty;
    public string $cost;
    public string $final_cost;

    public function mount()
    {
        $this->qty = $this->product->cart_qty;
        $this->cost = $this->product->cost;
        $this->final_cost = $this->product->final_cost;
    }

    public function increase()
    {
        $this->updateCart($this->qty + 1);
    }

    public function decrease()
    {
        if ($this->qty > 1) {
            $this->updateCart($this->qty - 1);
        }
    }

    public function updatedQty()
    {
        $qty = intval($this->qty) === 0 ? 1 : $this->qty;
        $this->updateCart($qty);
    }


    public function updateCart(int $qty)
    {
        $cartService = new CartService();
        $cartService->addToCart($this->product->id, $qty);
        $this->product = $cartService->getCartItem($this->product->id);

        $this->qty = $this->product->cart_qty;
        $this->cost = $this->product->cost;
        $this->final_cost = $this->product->final_cost;

        $this->emit('updateCartTotal');
    }


    public function render()
    {
        return view('livewire.cart-item-quantity');
    }
}
