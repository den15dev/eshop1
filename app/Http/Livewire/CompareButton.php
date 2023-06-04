<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\ComparisonService;

class CompareButton extends Component
{
    public int $product_id;
    public int $category_id;
    public bool $isInList;
    public string $size;
    public string $type;

    public $icon_class;
    public $color_class;
    public $inner_text;
    const ICON_NORMAL = 'bi-bar-chart';
    const ICON_ACTIVE = 'bi-bar-chart-fill';
    const COLOR_NORMAL = '';
    const COLOR_ACTIVE = ' icon_active';

    const TEXT_SHORT_NORMAL = 'Сравнить';
    const TEXT_SHORT_ACTIVE = 'В сравнении';

    const TEXT_EXTENDED_NORMAL = 'Сравнить характеристики';
    const TEXT_EXTENDED_ACTIVE = 'Добавлено в список сравнения';


    public function mount()
    {
        $this->isInList = (new ComparisonService())->isInList($this->product_id);

        $this->isInList ? $this->makeActive() : $this->makeNormal();

    }

    public function makeNormal()
    {
        $this->icon_class = self::ICON_NORMAL;
        $this->color_class = self::COLOR_NORMAL;
        if ($this->type === 'short') {
            $this->inner_text = self::TEXT_SHORT_NORMAL;
        } else {
            $this->inner_text = self::TEXT_EXTENDED_NORMAL;
        }
    }

    public function makeActive()
    {
        $this->icon_class = self::ICON_ACTIVE;
        $this->color_class = self::COLOR_ACTIVE;
        if ($this->type === 'short') {
            $this->inner_text = self::TEXT_SHORT_ACTIVE;
        } else {
            $this->inner_text = self::TEXT_EXTENDED_ACTIVE;
        }
    }

    public function updateComparisonList(): void
    {
        $comparisonService = new ComparisonService();
        $comparison_list = $comparisonService->get();

        if ($this->isInList) {
            $comparisonService->remove($this->product_id);
            $this->makeNormal();
            $this->isInList = false;
            $this->emit('updatePopup');
        } else {
            if (!$comparison_list || $this->category_id === $comparison_list[0]) {
                $comparisonService->add($this->product_id, $this->category_id);
                $this->makeActive();
                $this->isInList = true;
                $this->emit('updatePopup');
            } else {
                $this->emit('comparisonCatChangeRequest', [$this->product_id, $this->category_id]);
            }
        }
    }

    public function render()
    {
        return view('livewire.compare-button');
    }
}
