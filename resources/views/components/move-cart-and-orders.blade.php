<div class="mt-2 form-check">
    <input type="checkbox" name="move_cart_and_orders" class="form-check-input" id="move_cart_and_orders" checked>
    @php
        if ($cart && $orders) {
            $label = 'Перенести корзину и заказы';
            $note = 'Имеются товары в <a href="' . route('cart') . '" class="blue_link">корзине</a> и <a href="' . route('orders') . '" class="blue_link">заказы</a>, которые ранее были сделаны на этом устройстве. Если устройством пользовались не Вы, отключите этот чекбокс.';
        } elseif ($cart) {
            $label = 'Перенести товары из корзины';
            $note = 'В данный момент в <a href="' . route('cart') . '" class="blue_link">корзине</a> имеются товары. Если их добавляли не Вы, отключите этот чекбокс.';
        } elseif ($orders) {
            $label = 'Перенести заказы';
            $note = 'Имеются <a href="' . route('orders') . '" class="blue_link">заказы</a>, которые ранее были сделаны на этом устройстве. Если устройством пользовались не Вы, отключите этот чекбокс.';
        }
    @endphp
    <label class="form-check-label" for="move_cart_and_orders">{!! $label !!}</label>
    <div class="lightgrey_text small fst-italic">{!! $note !!}</div>
</div>
