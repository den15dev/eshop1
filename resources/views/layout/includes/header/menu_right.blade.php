{{--    Data passed from app/View/Composers/MenuComposer.php --}}

<ul class="nav col-12 col-lg-5">
    <li class="nav-item ms-auto">
        <a href="{{ route('favorites') }}" class="nav-link text-color-main">
            <span class="bi-heart me-1 count_label_cont">
                <livewire:favorites-badge />
            </span>
            Избранное
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cart') }}" class="nav-link text-color-main">
            <span class="bi-cart me-1 count_label_cont">
                <livewire:cart-badge />
            </span>
            Корзина
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('orders') }}" class="nav-link text-color-main">
            <span class="bi-receipt me-1 count_label_cont">
                @if($header['orders'] === 1)
                    <div class="user_notify_dot dot_blue dot_icon_pos"></div>
                @elseif($header['orders'] === 2)
                    <div class="user_notify_dot dot_green dot_icon_pos"></div>
                @endif
            </span>
            Заказы
        </a>
    </li>
</ul>
