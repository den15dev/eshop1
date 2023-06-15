<ul class="nav col-8 col-lg-6 me-auto mb-lg-0">
    <li class="nav-item dropdown me-3">
        <div class="btn2 btn2-red dropdown-toggle" id="catalog_btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Каталог
        </div>
        @include('layout.includes.header.menu_catalog')
    </li>

    <li class="nav-item">
        <a href="{{ route('delivery') }}" class="nav-link text-color-main">Доставка</a>
    </li>

    <li class="nav-item">
        <a href="{{ route('shops') }}" class="nav-link text-color-main">Магазины</a>
    </li>
</ul>
