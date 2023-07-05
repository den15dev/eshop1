<div class="cart_block border-bottom">
    <div class="cart_order">{{ $index + 1 }}</div>
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="cart_img">
        @if($product->images)
        <img src="{{ get_image('storage/images/products/' . $product->id . '/' . $product->images[0] . '_242.jpg', 242) }}" alt="{{ $product->name }}">
        @else
        <img src="{{ asset('storage/images/default/no-image_242.jpg') }}" alt="{{ $product->name }}">
        @endif
    </a>
    <div class="cart_descr">
        <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block fw-semibold mb-1 cat_block_title">
            {{ $product->name }}
        </a>
        <span class="d-block text-secondary small mb-2">{{ $product->short_descr }}</span>
        <span class="d-block small mb-2">Код товара: {{ $product->id }}</span>

        @if($product->discount_prc)
        <span class="d-block text-secondary fs-6 price_old mt-1"><del>{{ format_price($product->price) }} ₽</del></span>
        @endif
        <span class="d-block text-dark fs-5">{{ format_price($product->final_price) }} ₽</span>
    </div>

    <livewire:cart-item-quantity :product="$product" />

    <div class="cart_btns">
        <span class="cart_btn_link" title="Удалить из корзины" onclick="removeFromCart({{ $product->id }})">
            <span class="bi-x-lg fs-5"></span>
        </span>
    </div>
</div>
