@extends('admin.layout')

@section('page_title', 'Заказы - Администрирование')

@section('main_content')

    <h2 class="mb-4">Заказы</h2>

    <div class="mb-4">
        <div>
            <div class="d-flex gap-4 mb-2" id="order_status_filter">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="show_orders" value="all" id="orders_all" checked>
                    <label class="form-check-label" for="orders_all">
                        Все
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="show_orders" value="new" id="orders_new">
                    <label class="form-check-label" for="orders_new">
                        Новые
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="show_orders" value="ready" id="orders_ready">
                    <label class="form-check-label" for="orders_ready">
                        Готовые
                    </label>
                </div>
            </div>


            <div class="adm_search_input_cont">
                <input class="search_input" name="search" placeholder="Поиск" autocomplete="off" id="search_input">
                <span class="clear_btn bi-x-lg" id="clear_btn"></span>
            </div>
        </div>
    </div>


    <div id="index_table_cont">

        @include('admin.includes.index-table')

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/search.js') }}"></script>
@endpush
