<div class="col-12 col-xxl-6 mb-4">
    <div class="card">
        <h5 class="card-header">Общее</h5>
        <div class="card-body">
            <div>Завершено заказов:</div>
            <h4 class="card-title pt-0 mb-2">{{ format_price($dashboard->completed_orders_count) }}</h4>

            <div>На сумму:</div>
            <h4 class="card-title pt-0 mb-3">{{ format_price($dashboard->completed_orders_sum) }} ₽</h4>

            <hr/>

            <div>Зарегистрировано пользователей:</div>
            <h4 class="card-title pt-0 mb-1">{{ format_price($dashboard->registered_users_count) }}</h4>
        </div>
    </div>
</div>

<div class="col-12 col-xxl-6 mb-3">
    <div class="card mb-4">
        <h5 class="card-header">По категориям</h5>

        <div class="card-body">
            <select class="form-select mb-3" aria-label="Выбрать категорию" id="category_select">
                <option value="0"{{ $category_id === 0 ? ' selected' : '' }}>Все категории</option>
                @foreach($dashboard->categories as $category)
                    <option value="{{ $category->id }}"{{ $category_id === $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>

            <div>Продано на сумму:</div>
            <h4 class="card-title pt-0 mb-2">{{ format_price($dashboard->category_sale_sum) }} ₽</h4>

            <div>Добавлено товаров:</div>
            <h4 class="card-title pt-0 mb-2">{{ format_price($dashboard->added_products_count) }}</h4>

            <div>Оставлено отзывов:</div>
            <h4 class="card-title pt-0 mb-1">{{ format_price($dashboard->added_reviews_count) }}</h4>
        </div>


        @if($dashboard->products_by_qty->count())
            <hr class="my-0"/>

            <div class="card-body">
                <div class="fw-semibold mb-0">Топ-5 продаж по количеству, шт:</div>
            </div>

            <ul class="list-group list-group-flush">
                @foreach($dashboard->products_by_qty as $order_item)
                    <li class="list-group-item">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="small me-3">
                                <a href="{{ route('product', [$order_item->product->category_slug, $order_item->product->slug . '-' . $order_item->product->id]) }}" class="darkgrey_link text-decoration-none">
                                    {{ $order_item->product->name }}
                                </a>
                            </div>
                            <div class="text-nowrap">{{ format_price($order_item->qty) }}</div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="card-body">
                <div class="fw-semibold mb-0">Топ-5 продаж по сумме, ₽:</div>
            </div>

            <ul class="list-group list-group-flush">
                @foreach($dashboard->products_by_cost as $order_item)
                    <li class="list-group-item">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="small me-3">
                                <a href="{{ route('product', [$order_item->product->category_slug, $order_item->product->slug . '-' . $order_item->product->id]) }}" class="darkgrey_link text-decoration-none">
                                    {{ $order_item->product->name }}
                                </a>
                            </div>
                            <div class="text-nowrap">{{ format_price($order_item->cost) }} ₽</div>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
