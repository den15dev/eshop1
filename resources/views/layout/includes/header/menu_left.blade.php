<ul class="nav col-12 col-lg-7 me-auto mb-2 mb-lg-0">
    <li class="nav-item dropdown me-3">
        <div class="btn2 btn2-red dropdown-toggle" id="catalog_btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Каталог
        </div>
        @include('layout.includes.header.menu_catalog')
    </li>

    <li class="nav-item">
        <a class="nav-link text-color-main" href="#">
            <span class="bi-bar-chart-fill me-1 count_label_cont">
                @if($menu_data['comparison'])
                <div class="count_label">{{ $menu_data['comparison'] }}</div>
                @endif
            </span>
            Сравнение
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-color-main" href="#">Доставка</a>
    </li>

    <li class="nav-item">
        <a class="nav-link text-color-main" href="#">Магазины</a>
    </li>
</ul>
