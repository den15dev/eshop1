<?php

namespace App\Http\Livewire;

use App\Services\Site\FavoriteService;
use Livewire\Component;

class FavoritesRemoveBtn extends Component
{
    public int $product_id;

    public function removeFromFavorites()
    {
        (new FavoriteService())->remove($this->product_id);
        $this->emit('reloadPageByJS');
    }

    public function render()
    {
        return <<<'blade'
            <div class="card_remove_btn" wire:click="removeFromFavorites" title="Удалить из избранного"><span class="bi-x-lg fs-4"></span></div>
        blade;
    }
}
