<div class="col adm_sidebar_cont">
    <ul class="adm_sidebar_list">
        <li>
            <a href="{{ route('admin.home') }}" class="d-block black_link {{ active_link('admin.home', 'fw-bold adm_sidebar_active') }}">
                <span class="bi-house me-1"></span>
                Главная
            </a>
        </li>
        <li>
            <a href="{{ route('admin.products') }}" class="d-block black_link {{ active_link('admin.products', 'fw-bold adm_sidebar_active') }}">
                <span class="bi-box me-1"></span>
                Товары
            </a>
        </li>
        <li>
            <a href="{{ route('admin.categories') }}" class="d-block black_link {{ active_link('admin.categories', 'fw-bold adm_sidebar_active') }}">
                <span class="bi-list-check me-1"></span>
                Категории
            </a>
        </li>
        <li>
            <a href="{{ route('admin.brands') }}" class="d-block black_link {{ active_link('admin.brands', 'fw-bold adm_sidebar_active') }}">
                <span class="bi-star me-1"></span>
                Бренды
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users') }}" class="d-block black_link {{ active_link('admin.users', 'fw-bold adm_sidebar_active') }}">
                <span class="bi-person me-1"></span>
                Пользователи
            </a>
        </li>
        <li>
            <a href="{{ route('admin.orders') }}" class="d-block black_link {{ active_link('admin.orders', 'fw-bold adm_sidebar_active') }}">
                <span class="bi-basket me-1"></span>
                Заказы
            </a>
        </li>
    </ul>
</div>
