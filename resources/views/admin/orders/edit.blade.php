@extends('admin.layout')

@section('page_title', 'Заказ ' . $order->id . ' - Администрирование')

@section('main_content')

    <div class="mb-3">
        <h2 class="ms-2 mb-3">Заказ №{{ $order->id }}</h2>

        <ul class="order_main_list mb-2">
            <li><span class="lightgrey_text">Оформлен:</span> {{ \Carbon\Carbon::parse($order->created_at)->isoFormat('D.MM.YYYY, H:mm') }}</li>
            @php
                $status_class = match ($order->status) {
                                'new' => 'fw-semibold text-color-red',
                                'accepted' => 'text-color-main2',
                                'completed' => 'lightgrey_text',
                                'cancelled' => 'fst-italic',
                                'ready', 'sent' => 'text-color-green',
                                default => '',
                            }
            @endphp
            <li><span class="lightgrey_text">Статус:</span>
                @if($status_class)
                    <span class="{{ $status_class }}">{{ $order->status_str }}</span>
                @else
                    {{ $order->status_str }}
                @endif
            </li>
            <li><span class="lightgrey_text">Имя:</span> {{ $order->name }}</li>
            <li><span class="lightgrey_text">Телефон:</span> {{ $order->phone }}</li>
            <li><span class="lightgrey_text">Способ получения:</span> {{ $order->delivery_type_str }}</li>
            <li><span class="lightgrey_text">Адрес:</span> {{ $order->shop ? $order->shop->address : $order->delivery_address }}</li>
            <li><span class="lightgrey_text">Способ оплаты:</span> {{ $order->payment_method_str }}</li>
            <li><span class="lightgrey_text">Статус оплаты:</span> {!! $order->payment_status ? 'оплачен' : '<span class="text-color-red">не оплачен</span>' !!}</li>
        </ul>

        <table class="table table-borderless order_table text-center w-auto align-middle">
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
    </div>

    <div class="d-flex gap-2">
        @php
            $value = null;
            if ($order->status === 'new') {
                $message = 'Принять заказ?';
                $ok_btn_text = 'Принять';
                $value = 'accepted';
                $value_str = 'Принят';
                $submit_btn_text = 'Принять';

            } elseif (in_array($order->status, ['ready', 'sent'])) {
                $message = 'Завершить заказ?';
                $ok_btn_text = 'Завершить';
                $value = 'completed';
                $value_str = 'Завершён';
                $submit_btn_text = 'Завершить';

            } elseif (!in_array($order->status, ['completed', 'cancelled'])) {
                if ($order->delivery_type === 'delivery') {
                    $message = 'Заказ отправлен?';
                    $ok_btn_text = 'Да';
                    $value = 'sent';
                    $value_str = 'Отправлен';
                    $submit_btn_text = 'Отправлен';
                } else {
                    $message = 'Заказ готов к получению?';
                    $ok_btn_text = 'Да';
                    $value = 'ready';
                    $value_str = 'Готов к получению';
                    $submit_btn_text = 'Готов';
                }
            }
        @endphp
        @if($value)
            <form class="mb-5" method="POST" action="{{ route('admin.orders.update', $order->id) }}" onsubmit="return confirmChangingStatus(this, '{{ $message }}', '{{ $ok_btn_text }}')" novalidate>
                @method('PUT')
                @csrf
                <input type="hidden" name="status" value="{{ $value }}" />
                <input type="hidden" name="status_str" value="{{ $value_str }}" />
                <button type="submit" class="btn2 btn2-primary px-4" style="width: fit-content;">{{ $submit_btn_text }}</button>
            </form>
        @endif

        @unless(in_array($order->status, ['completed', 'cancelled']))
            <form class="mb-5" method="POST" action="{{ route('admin.orders.update', $order->id) }}" onsubmit="return confirmChangingStatus(this, 'Отменить заказ?', 'Отменить', 'Назад')" novalidate>
                @method('PUT')
                @csrf
                <input type="hidden" name="status" value="cancelled" />
                <input type="hidden" name="status_str" value="Отменён" />
                <button type="submit" class="btn2 btn2-red px-4" style="width: fit-content;">Отменить</button>
            </form>
        @endunless
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/order.js') }}"></script>
@endpush
