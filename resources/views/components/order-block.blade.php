<div @if($type === 'new') class="mx-auto mt-5" style="width: fit-content" @else class="order_cont" @endif>
    @if($type === 'new')
        <h3 class="mb-45" style="margin-left: 8px">Заказ №{{ $order->id }} успешно создан</h3>
    @else
        <h4 class="ps-3">№{{ $order->id }}</h4>
    @endif

    <ul class="order_main_list mb-2">
        <li><span class="lightgrey_text">Дата и время:</span> {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D.MM.YYYY, H:mm') }}</li>
        @php
            $status_class = '';
            if ($order->status === 'new' || $order->status === 'accepted') $status_class = ' text-color-main2';
            elseif ($order->status === 'ready' || $order->status === 'sent') $status_class = ' text-color-green';
        @endphp
        <li><span class="lightgrey_text">Статус:</span>
            @if($status_class)
                <span class="fw-semibold{{ $status_class }}">{{ $order->status_str }}</span>
            @else
                {{ $order->status_str }}
            @endif
        </li>
        <li><span class="lightgrey_text">Способ получения:</span> {{ $order->delivery_type_str }}</li>
        <li><span class="lightgrey_text">Адрес:</span> {{ $order->shop ? $order->shop->address : $order->delivery_address }}</li>
        <li><span class="lightgrey_text">Способ оплаты:</span> {{ $order->payment_method_str }}</li>
        <li><span class="lightgrey_text">Статус оплаты:</span> {!! $order->payment_status ? 'оплачен' : '<span class="text-color-red">не оплачен</span>' !!}</li>
    </ul>

    <table class="table table-borderless order_table text-center w-auto align-middle @if($type === 'new') mb-4 @endif">
        <thead>
        <tr class="lightgrey_text small">
            <td>№</td>
            <td></td>
            <td class="order_table_name_col">Наименование</td>
            <td>Код товара</td>
            <td>Количество</td>
            <td>Цена</td>
            <td>Стоимость</td>
        </tr>
        </thead>
        <tbody>

        @foreach($order->orderItems as $orderItem)
            <x-order-item :orderitem="$orderItem" :index="$loop->index" />
        @endforeach

        <tr class="border-top">
            <td colspan="6"></td>
            <td class="fw-semibold fs-4 text-end text-nowrap">{{ format_price($order->total_cost) }} ₽</td>
        </tr>
        </tbody>
    </table>

    @if($type === 'new')
        <p style="margin-left: 8px">
            Пожалуйста, дождитесь звонка сотрудника, чтобы уточнить стоимость доставки и подтвердить заказ.<br>
            Информацию обо всех ваших заказах можно посмотреть в разделе <a href="{{ route('orders') }}" class="blue_link">Заказы</a>.
        </p>
    @endif
</div>
