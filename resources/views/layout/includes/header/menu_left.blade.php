<ul class="nav col-4 col-md-6 me-auto mb-lg-0">
    <li class="nav-item dropdown me-3">
        <div class="btn2 btn2-red dropdown-toggle" id="catalog_btn" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Каталог
        </div>
        @include('layout.includes.header.menu_catalog')
    </li>

    <li class="nav-item d-none d-md-inline">
        <a href="{{ route('delivery') }}" class="nav-link dark_link">
            Доставка
        </a>
    </li>

    <li class="nav-item d-none d-md-inline">
        <a href="{{ route('shops') }}" class="nav-link dark_link">
            Магазины
        </a>
    </li>
</ul>
