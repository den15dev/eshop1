@extends('layout.layout')

@section('main_content')
    @include('layout.includes.breadcrumb')

    <div class="container">
        <div class="row">

            {{-- --------------- Sidebar ------------------ --}}

            <div class="d-none d-lg-block col" id="sidebar">
                <form method="GET" action="{{ route('category', $category_slug) }}">
                    <ul class="list-unstyled ps-0">
                        <x-sidebar-section title="Цена" sectionid="price_range" collapsed="{{ false }}">
                            <div class="d-flex flex-row small ps-3 mt-2">
                                <span class="mt-1 me-1">От</span>
                                <input type="text" name="price_min"
                                       class="form-control form-control-sm w-40"
                                       id="price_min"
                                       value="{{ format_price(request('price_min')) }}"
                                       placeholder="{{ format_price($priceMinMax[0]) }}">
                                <span class="mt-1 ms-1">руб</span>
                            </div>
                            <div class="d-flex flex-row small ps-3 mt-2 mb-2">
                                <span class="mt-1 me-1">до</span>
                                <input type="text" name="price_max"
                                       class="form-control form-control-sm w-40"
                                       id="price_max"
                                       value="{{ format_price(request('price_max')) }}"
                                       placeholder="{{ format_price($priceMinMax[1]) }}">
                                <span class="mt-1 ms-1">руб</span>
                            </div>
                        </x-sidebar-section>


                        <x-sidebar-section title="Брэнд" sectionid="brand" collapsed="{{ false }}">
                            <ul class="btn-toggle-nav list-unstyled fw-normal small mt-1 scrollbar-thin">
                                @foreach($brands as $brand)
                                <x-sidebar-checkbox filtername="brands"
                                                    id="{{ $brand->id }}"
                                                    index=""
                                                    value="{{ $brand->name }}"
                                                    units=""
                                                    quantity="{{ $brand->product_num }}" />
                                @endforeach
                            </ul>
                        </x-sidebar-section>

                        @foreach($filter_specs as $spec)
                        <x-sidebar-section title="{{ $spec->name }}" sectionid="{{ str($spec->name)->slug() }}" collapsed="{{ $loop->index > 0 && !request('specs.' . $spec->id) }}">
                            <ul class="btn-toggle-nav list-unstyled fw-normal small mt-1 scrollbar-thin">
                                @foreach($spec->values as $spec_val => $qty)
                                <x-sidebar-checkbox filtername="specs"
                                                    id="{{ $spec->id }}"
                                                    index="{{ $loop->index }}"
                                                    value="{{ $spec_val }}"
                                                    units="{{ $spec->units ?? '' }}"
                                                    quantity="{{ $qty }}" />
                                @endforeach
                            </ul>
                        </x-sidebar-section>
                        @endforeach

                        <div class="row gx-1 mt-4 pt-2">
                            <button type="submit" class="col btn2 btn2-primary me-1" id="sidebar_submit_btn">Применить</button>
                            <a href="{{ route('category', $category_slug) }}" class="col btn2 btn2-secondary text-center">Сброс</a>
                        </div>
                    </ul>
                </form>
            </div>



            {{-- --------------- Main section ------------------ --}}

            <div class="col ps-3" id="catalog">

                @include('layout.includes.layout-settings')

                <div class="container mb-2 block_container">
                    @if($products->isNotEmpty())

                        @if($layout[2] == 1)
                            <div class="row row-cols-2 row-cols-xl-3 row-cols-xxl-4">
                                @foreach($products as $item)
                                    <div class="col px-0 pb-1">
                                        <x-product-card type="catalog" :product="$item" />
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row row-cols-1">
                                @foreach($products as $item)
                                    <x-product-row :product="$item" />
                                @endforeach
                            </div>
                        @endif

                    @else
                    <div class="text-center fs-2 lightgrey_text" style="padding: 100px 0">
                        Товары не найдены
                    </div>
                    @endif
                </div>


                {{-- --------------- Pagination ------------------ --}}

                @if($products->total() > 0)
                {{ $products->links('layout.pagination.results-shown') }}
                @endif
                @if($products->total() > $layout[1])
                {{ $products->withQueryString()->links('layout.pagination.page-links') }}
                @endif
                <div style="height: 46px"></div>


                @if($recently_viewed->count())
                <x-carousel title="Недавно просмотренные" section="crs_recently_viewed">
                    @foreach($recently_viewed as $item)
                        <x-product-card type="carousel" :product="$item" />
                    @endforeach
                </x-carousel>
                <script>let carousel_perpage = 4;</script>
                @endif
            </div>

        </div>


    {{--    Prevent submitting empty input field values (min & max prices)  --}}
        <script>
            window.addEventListener('load', function() {
                let forms = document.getElementsByTagName('form');
                for (let form of forms) {
                    form.addEventListener('formdata', function(event) {
                        let formData = event.formData;
                        for (let [name, value] of Array.from(formData.entries())) {
                            if (value === '') formData.delete(name);
                        }
                    });
                }
            });
        </script>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/sidebar.js') }}"></script>
@endpush

@if($recently_viewed->count())
    @push('css')
        <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
    @endpush

    @push('scripts')
        <script src="{{ asset('js/splide.min.js') }}"></script>
        <script src="{{ asset('js/recently_viewed.js') }}"></script>
    @endpush
@endif
