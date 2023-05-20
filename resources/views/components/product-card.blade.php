@if($type === 'carousel')
<li class="splide__slide cat_block">
@else
<div class="cat_block">
@endif
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block position-relative mb-2">
        @if($product->discount_prc)
        <div class="cat_img_badge small bg-color-red">-{{ $product->discount_prc }}%</div>
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

    <button type="button" class="btn2 btn2-primary addtocart_btn">В корзину</button>

    <div class="d-flex flex-row small mb-4">
        <span class="cat_block_addbtn me-3">
            <span class="bi-bar-chart me-1"></span>Сравнить
        </span>
        <span class="cat_block_addbtn">
            <span class="bi-heart me-1"></span>В избранное
        </span>
    </div>
@if($type === 'carousel')
</li>
@else
</div>
@endif

