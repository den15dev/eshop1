<a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="search_result_block text-dark">
    @if($product->images)
        <img src="{{ get_image('storage/images/products/' . $product->id . '/' . $product->images[0] . '_80.jpg', 80) }}">
    @else
        <img src="{{ asset('storage/images/default/no-image_80.jpg') }}">
    @endif
    <div class="search_result_block_title">
        {{ $product->name }}
    </div>
    <div class="fw-semibold">
        {{ format_price($product->final_price) }} ₽
    </div>
</a>
