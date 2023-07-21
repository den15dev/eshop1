<td class="compare_col px-4 align-top">
    <div class="blue_link mb-2" onclick="removeFromComparison({{ $product->id }})" title="Удалить из списка сравнения">
        <span class="bi-x me-1"></span>Удалить
    </div>
    <a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="d-block cat_block_title">
        <div class="mb-1">
            @if($product->images)
                <img src="{{ get_image('storage/images/products/' . $product->id . '/' . $product->images[0] . '_242.jpg', 242) }}" class="compare_img" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('img/default/no-image_242.jpg') }}" class="compare_img" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="fw-semibold">
            {{ $product->name }}
        </div>
    </a>
    <div class="grey_text my-1">{{ format_price($product->final_price) }} ₽</div>
</td>
