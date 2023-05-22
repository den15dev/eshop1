<?php

namespace App\Http\Livewire;

use App\Services\CartService;
use Livewire\Component;

class CartBadge extends Component
{
    public $cart_qty;

    protected $listeners = ['updateCartBadge'];

    public function mount()
    {
        $this->cart_qty = count(CartService::getCart());
    }


    public function updateCartBadge(int $cart_count)
    {
        $this->cart_qty = $cart_count;
    }


    public function render()
    {
        return view('livewire.cart-badge');
    }
}
