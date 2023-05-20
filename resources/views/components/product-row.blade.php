<div class="col px-0 cat_block_row">
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block float-start me-18 position-relative">
        @if($product->discount_prc)
            <div class="cat_img_badge small bg-color-red">-{{ $product->discount_prc }}%</div>
        @endif
        <img src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $product->images[0] . '_242.jpg') }}" alt="{{ $product->name }}">
    </a>
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block cat_block_title">
        <span class="fw-semibold">{{ $product->name }}</span><br>
    </a>

    <span class="d-block mt-1 mb-2 small text-secondary">{{ $product->short_descr }}</span>

    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}#reviews"
       class="d-flex flex-row rating-link small"
       title="{{ $product->rating }}">
        <ul class="d-flex flex-row rating-list">
            @for($i=0; $i<5; $i++)
                @if($product->rating - $i > 0.75)
                    <li class="bi-star-fill"></li>
                @elseif($product->rating - $i > 0.25)
                    <li class="bi-star-half"></li>
                @else
                    <li class="bi-star"></li>
                @endif
            @endfor
        </ul>
        @if($product->vote_num)
        <span class="rating-num-votes">({{ $product->vote_num }})</span>
        @endif
    </a>

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
</div>
