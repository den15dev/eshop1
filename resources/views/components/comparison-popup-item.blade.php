<div class="d-flex flex-row gap-1 comp_popup_item mb-1">
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block darkgrey_link small comp_popup_link_cont">
        @if($product->images)
            <img class="d-block h-100 float-start me-2" src="{{ get_image('storage/images/products/' . $product->id . '/' . $product->images[0] . '_80.jpg', 80) }}" alt="">
        @else
            <img class="d-block h-100 float-start me-2" src="{{ asset('img/default/no-image_80.jpg') }}" alt="">
        @endif
        <div class="comp_popup_name_cont">{{ $product->name }}</div>
    </a>
    <div class="comp_popup_remove_btn lightgrey_text" wire:click="comparisonRemoveItem({{ $product->id }})">
        <span class="bi-x-lg fs-6"></span>
    </div>
</div>
