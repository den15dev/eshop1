<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <a href="{{ route('product', [$orderitem->product->category_slug, $orderitem->product->slug . '-' . $orderitem->product->id]) }}">
            @if($orderitem->product->images)
                <img src="{{ get_image('storage/images/products/' . $orderitem->product->id . '/' . $orderitem->product->images[0] . '_80.jpg', 80) }}" alt="{{ $orderitem->product->name }}">
            @else
                <img src="{{ asset('img/default/no-image_80.jpg') }}" alt="{{ $orderitem->product->name }}">
            @endif
        </a>
    </td>
    <td class="text-start">
        <a href="{{ route('product', [$orderitem->product->category_slug, $orderitem->product->slug . '-' . $orderitem->product->id]) }}" class="black_link">{{ $orderitem->product->name }}</a>
    </td>
    <td>{{ $orderitem->product->id }}</td>
    <td>{{ $orderitem->quantity }}</td>
    <td class="text-end text-nowrap">{{ format_price($orderitem->price) }} ₽</td>
    <td class="text-end text-nowrap">{{ format_price($orderitem->cost) }} ₽</td>
</tr>
