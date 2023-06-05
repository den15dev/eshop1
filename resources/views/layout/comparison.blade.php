@extends('layout.layout')

@section('page_title', 'Сравнение товаров - ' . config('app.name'))

@section('main_content')
    <div class="container">

        @if(isset($products))
            <h2>Сравнение характеристик</h2>

            <div class="container compare_main_cont px-0 mb-5">
                <table class="table w-auto text-center">
                    <thead>
                    <tr class="compare_head_row">
                        <td class="compare_col1 align-top text-start">
                            <div class="blue_link" style="width: fit-content" onclick="clearComparisonList()">
                                <span class="bi-x me-1"></span>Очистить список
                            </div>
                        </td>

                        @foreach($products as $product)
                            <x-comparison-column-head :product="$product" />
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                        <tr class="fs-5">
                            <td class="text-start"></td>
                            @foreach($products as $product)
                                <td class="pb-3">{{ format_price($product->final_price) }} ₽</td>
                            @endforeach
                        </tr>

                        @foreach($specs as $spec)
                        <tr>
                            <td class="text-start">{{ $spec->name }}</td>
                            @foreach($products as $product)
                                @php $product_spec = $product->specifications->firstWhere('id', $spec->id); @endphp
                                <td>{{ $product_spec ? $product_spec->pivot->spec_value : '-' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @push('scripts')
                <script src="{{ asset('js/comparison.js') }}"></script>
            @endpush

        @else

            <div class="text-center fs-2 lightgrey_text" style="padding: 120px 0">
                Товары для сравнения не выбраны
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
