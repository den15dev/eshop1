<div class="comparison_popup{{ $display_toggle }}">
    <div class="mb-2 fw-semibold">Сравнение характеристик:</div>
    <div class="mb-2">
        @empty(!$products)
        @foreach($products as $product)
        <x-comparison-popup-item :product="$product" />
        @endforeach
        @endempty
    </div>
    <div class="d-flex flex-row">
        <a href="{{ route('comparison') }}" class="d-block blue_link me-3">Сравнить</a>
        <div class="blue_link" role="button" wire:click="clearComparisonList">Очистить список</div>
    </div>
</div>
