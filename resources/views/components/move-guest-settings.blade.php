<div class="mt-2">
    @isset($settings['cart'])
        <div class="form-check">
            <input type="checkbox" name="move_cart" class="form-check-input" id="move_cart" checked>
            <label class="form-check-label" for="move_cart">Перенести корзину</label>
        </div>
    @endisset

    @isset($settings['orders'])
        <div class="form-check">
            <input type="checkbox" name="move_orders" class="form-check-input" id="move_orders" checked>
            <label class="form-check-label" for="move_orders">Перенести заказы</label>
        </div>
    @endisset

    @isset($settings['favorites'])
        <div class="form-check">
            <input type="checkbox" name="move_favorites" class="form-check-input" id="move_favorites" checked>
            <label class="form-check-label" for="move_favorites">Перенести избранное</label>
        </div>
    @endisset

    <div class="lightgrey_text small fst-italic">Если это не Ваш личный компьютер, пожалуйста, отключите {{ count($settings) > 1 ? 'чекбоксы выше.' : 'этот чекбокс.' }}</div>
</div>
