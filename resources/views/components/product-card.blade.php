@if($type === 'carousel')
<li class="splide__slide cat_block">
@else
<div class="cat_block">
@endif
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block position-relative mb-2">
        <div class="cat_badge_cont">
            @if($type !== 'promo' && $product->promo_id)
            <div class="cat_img_badge small bg-color-action" title="{{ $product->promo_name }}">Акция</div>
            @endif
            @if($product->discount_prc)
            <div class="cat_img_badge small bg-color-red">-{{ $product->discount_prc }}%</div>
            @endif
        </div>

        @if($type === 'favorites')
        <livewire:favorites-remove-btn :product_id="$product->id" />
        @endif

        <img src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $product->images[0] . '_242.jpg') }}" alt="{{ $product->name }}">
    </a>
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block cat_block_title">
        <span class="fw-semibold">{{ $product->name }}</span><br>
    </a>

    <span class="d-block mt-1 mb-2 small text-secondary">{{ $product->short_descr }}</span>

    <x-rating-stars tag="a" size="small" :product="$product"/>

    @if($product->discount_prc)
        <span class="d-block text-secondary fs-6 price_old mt-1"><del>{{ format_price($product->price) }} ₽</del></span>
    @endif
    <span class="d-block text-dark fw-semibold fs-4 mb-2">{{ format_price($product->final_price) }} ₽</span>

    <livewire:add-to-cart-small-btn wire:click="updateCart" :product_id="$product->id" />

    <div class="d-flex flex-row small mb-4">
        <livewire:compare-button :product_id="$product->id" :category_id="$product->category_id" size="small" type="short" />
        <livewire:favorites-button :product_id="$product->id" size="small" />
    </div>

@if($type === 'carousel')
</li>
@else
</div>
@endif

