<tr>
    <td>{{ $index + 1 }}</td>
    <td>
        <a href="{{ route('product', [$orderitem->product->category_slug, $orderitem->product->slug . '-' . $orderitem->product->id]) }}">
            <img src="{{ asset('storage/images/products/temp/' . ($orderitem->product->id % 20 + 1) . '/' . $orderitem->product->images[0] . '_80.jpg') }}" alt="{{ $orderitem->product->name }}">
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
