@php
    $href = '';
    $rating_link = '';
    if ($tag == 'a' && $product->vote_num > 0) {
        $href = ' href="' . route('product', [$product->category_slug, $product->slug . '-' . $product->id]) . '#reviews"';
        $rating_link = ' rating-link';
    }
    if (!$product->vote_num) {
        $tag = 'div';
    }
@endphp
<{{ $tag }}{!! $href !!} class="d-flex flex-row{{ $rating_link }}{{ $size == 'small' ? ' small' : '' }}" title="{{ $product->rating ?? 'Нет оценок' }}">
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
</{{ $tag }}>
