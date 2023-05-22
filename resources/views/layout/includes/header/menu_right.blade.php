{{--    Data passed from app/View/Composers/MenuComposer.php --}}

<ul class="nav col-12 col-lg-5">
    <li class="nav-item ms-auto">
        <a class="nav-link text-color-main" href="#">
            <span class="bi-heart me-1 count_label_cont">
                @if($menu_data['favourites'])
                    <div class="count_label">{{ $menu_data['favourites'] }}</div>
                @endif
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
        <a class="nav-link text-color-main" href="#">
            <span class="bi-receipt me-1 count_label_cont">
                @if($menu_data['orders'])
                    <div class="user_notify_dot dot_icon_pos"></div>
                @endif
            </span>
            Заказы
        </a>
    </li>
</ul>
