<div class="col px-0">
    <div class="cat_block">
        <a href="{{ route('category', $category->slug) }}" class="d-block mb-2 text-center cat_block_title"
           onmouseover="this.getElementsByTagName('div')[0].style.backgroundPosition = 'right';"
           onmouseout="this.getElementsByTagName('div')[0].style.backgroundPosition = 'left';">

            <div class="category_img_cont mb-1"
                 style="background: left url('{{ asset('storage/images/categories/' . $category->slug . '.jpg') }}');"></div>

            <span class="d-block fs-5 lh-sm fw-semibold mb-1">{{ $category->name }}</span>
            @if($category->products_total)
            <span class="d-block text-secondary">{{ trans_choice(implode('|', [':count товар', ':count товара', ':count товаров']), $category->products_total) }}</span>
            @else
            <span class="d-block text-secondary">Нет товаров</span>
            @endif
        </a>
    </div>
</div>
