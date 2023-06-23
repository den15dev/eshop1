<?php

namespace App\Http\Livewire;

use App\Services\Site\FavoriteService;
use Livewire\Component;

class FavoritesButton extends Component
{
    public int $product_id;
    public bool $isInList;
    public string $size;

    public $icon_class;
    public $color_class;
    public $inner_text;

    const ICON_NORMAL = 'bi-heart';
    const ICON_ACTIVE = 'bi-heart-fill';
    const COLOR_NORMAL = '';
    const COLOR_ACTIVE = ' icon_active_red';
    const TEXT_NORMAL = 'В избранное';
    const TEXT_ACTIVE = 'В избранном';

    const TITLE_REMOVE_HINT = ' title="Удалить из избранного"';
    public string $title_attr = '';

    public function mount()
    {
        $this->isInList = (new FavoriteService())->isInList($this->product_id);
        $this->isInList ? $this->makeActive() : $this->makeNormal();
    }

    public function makeNormal()
    {
        $this->icon_class = self::ICON_NORMAL;
        $this->color_class = self::COLOR_NORMAL;
        $this->inner_text = self::TEXT_NORMAL;
        $this->title_attr = '';
    }

    public function makeActive()
    {
        $this->icon_class = self::ICON_ACTIVE;
        $this->color_class = self::COLOR_ACTIVE;
        $this->inner_text = self::TEXT_ACTIVE;
        $this->title_attr = self::TITLE_REMOVE_HINT;
    }

    public function updateFavoritesList(): void
    {
        $favoritesService = new FavoriteService();

        if ($this->isInList) {
            $favorites = $favoritesService->remove($this->product_id);
            $this->makeNormal();
            $this->isInList = false;
        } else {
            $favorites = $favoritesService->add($this->product_id);
            $this->makeActive();
            $this->isInList = true;
        }

        $this->emit('updateFavoritesBadge', count($favorites));
    }

    public function render()
    {
        return view('livewire.favorites-button');
    }
}
