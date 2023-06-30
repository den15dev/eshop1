@extends('layout.layout')

@section('main_content')
    <div class="container">
        <section class="splide crs_actions mb-5 mt-2" aria-label="Splide Basic HTML Example" id="action_carousel">
            <div class="splide__track">
                <ul class="splide__list">
                    @foreach($promos as $promo)
                        <li class="splide__slide">
                            <a href="{{ route('promo', $promo->slug . '-' . $promo->id) }}">
                                <img src="{{ asset('storage/images/promos/' . $promo->id . '/' . $promo->image) }}" alt="{{ $promo->name }}">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <x-carousel title="Лучшие цены" section="crs_best_prices">
            @foreach($discounted as $disc_item)
                <x-product-card type="carousel" :product="$disc_item" />
            @endforeach
        </x-carousel>

        <x-carousel title="Новинки" section="crs_new">
            @foreach($newest as $newest_item)
                <x-product-card type="carousel" :product="$newest_item" />
            @endforeach
        </x-carousel>

        <x-carousel title="Популярные" section="crs_most_popular">
            @foreach($popular as $pop_item)
                <x-product-card type="carousel" :product="$pop_item" />
            @endforeach
        </x-carousel>

        <script>let carousel_perpage = 5;</script>
    </div>
@endsection

@push('css')
    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
