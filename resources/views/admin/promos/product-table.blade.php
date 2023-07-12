@if($promo->products->count())
    <h4 class="mb-3">{{ trans_choice(implode('|', [':count товар участвует', ':count товара участвуют', ':count товаров участвуют']), $promo->products->count()) }} в акции</h4>

    <table class="table text-center small align-middle mb-5" id="index_table">
        <thead>
        <tr class="lightgrey_text">
            <td>id</td>
            <td></td>
            <td>Наименование</td>
            <td>Цена</td>
            <td></td>
        </tr>
        </thead>
        <tbody>
        @foreach($promo->products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="dark_link">
                        @if($product->images)
                            <img src="{{ get_image('storage/images/products/' . $product->id . '/' . $product->images[0] . '_80.jpg', 80) }}">
                        @else
                            <img src="{{ asset('storage/images/default/no-image_80.jpg') }}">
                        @endif
                    </a>
                </td>
                <td class="text-start"><a href="{{ route('admin.products.edit', $product->id) }}" class="dark_link">{{ $product->name }}</a></td>
                <td>{{ format_price($product->final_price) }}</td>
                <td>
                    <div class="bi-x-lg fs-5 p-1" role="button" style="color: #d2d2d2" title="Изъять из акции"
                         onclick="removeFromPromo({{ $promo->id . ', ' . $product->id . ', ' . "'" . csrf_token() . "'" }})">
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="mb-45">В акции не участвует ни один товар.</div>
@endif
