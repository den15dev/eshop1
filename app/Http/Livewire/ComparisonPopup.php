<?php

namespace App\Http\Livewire;

use App\Services\ComparisonService;
use Livewire\Component;

class ComparisonPopup extends Component
{
    public $items = '';
    public $display_toggle = ' d-none';
    public $products;

    protected $listeners = ['updatePopup'];

    public function mount()
    {
        $this->products = (new ComparisonService())->getProducts();
        $this->display_toggle = $this->products ? '' : ' d-none';
    }

    public function updatePopup()
    {
        $this->products = (new ComparisonService())->getProducts();
        $this->display_toggle = $this->products ? '' : ' d-none';
    }

    public function clearComparisonList()
    {
        (new ComparisonService())->clear();
        $this->emit('reloadPageByJS');
    }

    public function comparisonRemoveItem(int $product_id)
    {
        (new ComparisonService())->remove($product_id);
        $this->emit('reloadPageByJS');
    }

    public function render()
    {
        $products = $this->products;

        return view('livewire.comparison-popup', compact('products'));
    }
}
