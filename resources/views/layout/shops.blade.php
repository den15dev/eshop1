@extends('layout.layout')

@section('page_title', 'Магазины - ' . config('app.name'))

@section('main_content')
    <div class="container">

        <h2 class="mb-4">Магазины</h2>

        {{-- --------------- Tabs ------------------ --}}

        <ul class="d-lg-none nav nav-tabs mb-4" id="shops_tab_cont">
            <li class="nav-item">
                <div class="nav-link active" data-pageid="shop_list">Список</div>
            </li>
            <li class="nav-item">
                <div class="nav-link blue_link" data-pageid="shop_map">Карта</div>
            </li>
        </ul>

        <div class="row mb-5">
            <div class="col-12 col-lg-4 shops_list" id="shop_list_page">
                <div class="shop_items_cont scrollbar-thin">

                    @foreach($shops as $shop)
                        <div class="shop_item"{!! $loop->last ? ' style="border-bottom: none"' : '' !!} data-shopid="{{ $shop->id }}">
                            <div class="fw-semibold">{{ $shop->name }}</div>
                            <div class="grey_text mb-25">{{ $shop->address }}</div>
                            <div class="grey_text mb-25">Пн-Пт: 9:00 - 21:00</div>
                            <div class="shop_info grey_text small mb-25" style="display: none">{{ $shop->info }}</div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="col-12 col-lg-8 shops_map" id="shop_map_page">
                <div class="shops_map_cont" id="map"></div>
            </div>

            <script>
                const shops_data = {!! $shops_json !!};
            </script>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://api-maps.yandex.ru/2.1/?apikey={{ config('app.ymap_api_key') }}&lang={{ config('app.loc_reg') }}"></script>
    <script src="{{ asset('js/shops.js') }}"></script>
@endpush
