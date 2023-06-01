@extends('layout.layout')

@section('page_title', 'Заказы - ' . config('app.name'))

@section('main_content')
    <div class="container">

        @if($orders->count())
            <h2 class="mb-45">Заказы</h2>

            @foreach($orders as $order)
                <x-order-block :order="$order" type="list"/>
            @endforeach
            <div style="height: 26px"></div>

        @else

            <div class="text-center fs-2 lightgrey_text" style="padding: 120px 0">
                Заказов нет
            </div>

            @if($recently_viewed->count())
                <x-carousel title="Недавно просмотренные" section="crs_recently_viewed">
                    @foreach($recently_viewed as $item)
                        <x-product-card type="carousel" :product="$item" />
                    @endforeach
                </x-carousel>
                <script>let carousel_perpage = 5;</script>

                @push('css')
                    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
                @endpush

                @push('scripts')
                    <script src="{{ asset('js/splide.min.js') }}"></script>
                    <script src="{{ asset('js/recently_viewed.js') }}"></script>
                @endpush
            @endif
        @endif
    </div>
@endsection
