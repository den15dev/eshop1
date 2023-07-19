@extends('layout.layout')

@section('page_title', 'Избранное - ' . config('app.name'))

@section('main_content')
    <div class="container">

        <h2 class="mb-4">Избранное</h2>

        <div class="container mb-5 block_container">
            @if($products->isNotEmpty())
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                    @foreach($products as $item)
                        <div class="col px-0 pb-1">
                            <x-product-card type="favorites" :product="$item" />
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center fw-light fs-2 lightgrey_text" style="padding: 100px 0">
                    Нет товаров
                </div>
            @endif
        </div>


        @if($recently_viewed->count())
            <x-carousel title="Недавно просмотренные" section="crs_recently_viewed">
                @foreach($recently_viewed as $item)
                    <x-product-card type="carousel" :product="$item" />
                @endforeach
            </x-carousel>
            <script>let carousel_perpage = 4;</script>
        @endif
    </div>
@endsection

@if($recently_viewed->count())
    @push('css')
        <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/splide.min.js') }}"></script>
        <script src="{{ asset('js/recently_viewed.js') }}"></script>
    @endpush
@endif
