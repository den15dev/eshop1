<a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="search_result_block text-dark">
    <img src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $product->images[0] . '_80.jpg') }}">
    <div class="search_result_block_title">
        {{ $product->name }}
    </div>
    <div class="fw-semibold">
        {{ format_price($product->final_price) }} ₽
    </div>
</a>
