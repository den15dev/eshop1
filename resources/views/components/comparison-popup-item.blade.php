<div class="d-flex flex-row gap-1 comp_popup_item mb-1">
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block darkgrey_link small comp_popup_link_cont">
        <img class="d-block h-100 float-start me-2" src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $product->images[0] . '_80.jpg') }}">
        <div class="comp_popup_name_cont">{{ $product->name }}</div>
    </a>
    <div class="comp_popup_remove_btn lightgrey_text" wire:click="comparisonRemoveItem({{ $product->id }})">
        <span class="bi-x-lg fs-6"></span>
    </div>
</div>
