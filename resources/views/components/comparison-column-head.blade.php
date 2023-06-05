<td class="compare_col px-4 align-top">
    <div class="blue_link mb-2" onclick="removeFromComparison({{ $product->id }})" title="Удалить из списка сравнения">
        <span class="bi-x me-1"></span>Удалить
    </div>
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block cat_block_title">
        <div class="mb-1">
            <img src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $product->images[0] . '_242.jpg') }}" class="compare_img" alt="{{ $product->name }}">
        </div>
        <div class="fw-semibold">
            {{ $product->name }}
        </div>
    </a>
</td>
