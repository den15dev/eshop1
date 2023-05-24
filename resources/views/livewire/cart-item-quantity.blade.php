<div class="cart_qty_price">
    <div class="cart_qty_cont">
        <button wire:click.debounce.100ms="decrease" class="item-decrease-btn">-</button>
        <input wire:model.debounce.100ms="qty" type="text" class="item-qty-input" value="{{ $qty }}">
        <button wire:click.debounce.100ms="increase" class="item-increase-btn">+</button>
    </div>
    <div class="cart_price">
        @if($product->discount_prc)
            <div class="text-secondary fs-6 price_old"><del>{{ format_price($cost) }} ₽</del></div>
        @endif
        <div class="text-dark fw-semibold">{{ format_price($final_cost) }} ₽</div>
    </div>
</div>
