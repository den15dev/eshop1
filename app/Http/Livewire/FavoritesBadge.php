<?php

namespace App\Http\Livewire;

use App\Services\FavoritesService;
use Livewire\Component;

class FavoritesBadge extends Component
{
    public $favorites_num;

    protected $listeners = ['updateFavoritesBadge'];

    public function mount()
    {
        $this->favorites_num = count((new FavoritesService)->get());
    }

    public function updateFavoritesBadge(int $favorites_num)
    {
        $this->favorites_num = $favorites_num;
    }

    public function render()
    {
        return view('livewire.favorites-badge');
    }
}
