{{--    Data passed from app/View/Composers/MenuComposer.php --}}

<ul class="nav justify-content-end col-8 col-md-6" id="right_menu">
    <li class="nav-item d-inline d-md-none">
        <a href="{{ route('delivery') }}" class="nav-link text-color-main">
            <span class="bi-truck me-1"></span>
        </a>
    </li>
    <li class="nav-item d-inline d-md-none">
        <a href="{{ route('shops') }}" class="nav-link text-color-main">
            <span class="bi-geo-alt me-1"></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('favorites') }}" class="nav-link text-color-main">
            <span class="bi-heart me-1 count_label_cont">
                <livewire:favorites-badge />
            </span>
            <span class="d-none d-lg-inline">Избранное</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('cart') }}" class="nav-link text-color-main">
            <span class="bi-cart me-1 count_label_cont">
                <livewire:cart-badge />
            </span>
            <span class="d-none d-lg-inline">Корзина</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('orders') }}" class="nav-link text-color-main" style="padding-right: 12px">
            <span class="bi-receipt me-1 count_label_cont">
                @if($header['orders'] === 1)
                    <div class="user_notify_dot dot_blue dot_icon_pos"></div>
                @elseif($header['orders'] === 2)
                    <div class="user_notify_dot dot_green dot_icon_pos"></div>
                @endif
            </span>
            <span class="d-none d-lg-inline">Заказы</span>
        </a>
    </li>
</ul>
