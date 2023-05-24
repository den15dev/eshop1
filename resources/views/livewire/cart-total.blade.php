<div class="cart_total_cont">
    @if($final_total !== $total)
        <div class="text-secondary text-end fs-6 price_old" style="margin-bottom: -16px"><del>{{ format_price($total) }} ₽</del></div>
    @endif
    <div class="cart_total_title">Общая стоимость:</div>
    <div class="fw-semibold cart_total_price">{{ format_price($final_total) }} ₽</div>
</div>
