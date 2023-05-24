<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\CartService;

class CartTotal extends Component
{
    public $cost;
    public $total; // Without discounts
    public $final_total;

    protected $listeners = ['updateCartTotal'];

    public function mount()
    {
        $this->total = $this->cost['total'];
        $this->final_total = $this->cost['final_total'];
    }

    public function updateCartTotal()
    {
        $cartService = new CartService();

        $products = $cartService->getCartProducts();
        $this->cost = $cartService->getCartCost($products);

        $this->total = $this->cost['total'];
        $this->final_total = $this->cost['final_total'];
    }

    public function render()
    {
        return view('livewire.cart-total');
    }
}
