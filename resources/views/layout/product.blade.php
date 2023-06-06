@extends('layout.layout')

@section('page_title', $product->name . ' - ' . config('app.name'))

@section('main_content')
@include('layout.includes.breadcrumb')

<div class="container">

    <h2 class="mb-3">
        {{ $product->name }}
        @if($product->discount_prc)
        <span class="item_badge fw-normal bg-color-red">-{{ $product->discount_prc }}%</span>
        @endif
    </h2>

    <div class="d-flex flex-row mb-3">
        <span class="d-block me-5">Код товара: {{ $product->id }}</span>

        <x-rating-stars tag="div" size="small" :product="$product"/>
    </div>


    {{-- --------------- Main section ------------------ --}}

    <div class="row mb-4" id="item_top_section">
        <div class="col-xl-5 col-md-7 col-12 mb-4" id="item_img_block">
            <div class="splide mb-2" id="item_img_main">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($product->images as $image)
                        <li class="splide__slide">
                            <img src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $image . '_600.jpg') }}">
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="splide" id="item_thumbnails">
                <div class="splide__track">
                    <ul class="splide__list">
                        @foreach($product->images as $image)
                            <li class="splide__slide thumb_slide">
                                <img src="{{ asset('storage/images/products/temp/' . ($product->id % 20 + 1) . '/' . $image . '_80.jpg') }}">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="d-none d-xl-block col-4 ps-5" id="item_spec_block">
            <span class="d-block mb-4">
                <span class="d-block fw-bold mb-1">Код производителя:</span>
                {{ $product->sku }}
            </span>

            <span class="d-block fw-bold mb-1">Характеристики:</span>
            <ul class="item_specs mb-1">
                @foreach($product->specifications->sortBy('sort') as $spec)
                <li><span class="text-secondary">{{ $spec->name }}:</span> {{ $spec->pivot->spec_value }} {{ $spec->units ?? '' }}</li>
                @if($loop->index > 5)
                    @break
                @endif
                @endforeach
            </ul>

            <a href="#specifications" class="d-block blue_link mb-5" style="width: fit-content" id="all_specs_link">Все характеристики</a>

            <a href="{{ route('brand', $product->brand_slug) }}" class="d-block mb-4" style="width: fit-content">
                <img style="width: 120px" src="{{ get_any_image('storage/images/brands/' . $product->brand_slug) }}" alt="{{ $product->brand_name }}">
            </a>
        </div>

        <div class="col-xl-3 col-md-5 col-12 px-4" id="item_order_block">
            @if($product->discount_prc)
            <span class="d-block text-secondary fs-5 price_old_item"><del>{{ format_price($product->price) }} ₽</del></span>
            @endif
            <span class="d-block text-dark fw-semibold fs-2 lh-1 mb-4">{{ format_price($product->final_price) }} ₽</span>

            <div class="item_qty_cont">
                <button class="item-decrease-btn">-</button>
                <input type="text" class="item-qty-input" id="item_qty_input" value="{{ $in_cart ?? 1 }}">
                <button class="item-increase-btn">+</button>
            </div>

            <livewire:add-to-cart-big-btn wire:click="updateCart" :product_id="$product->id" :in_cart="$in_cart" />

            <div class="d-flex flex-row mb-4">
                <livewire:compare-button :product_id="$product->id" :category_id="$product->category_id" size="big" type="short" />
                <livewire:favorites-button :product_id="$product->id" size="big" />
            </div>
        </div>
    </div>



    {{-- ================= TABs ==================== --}}

    <nav class="mb-4">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a href="#description" class="nav-link active" id="description-tab" data-bs-toggle="tab" type="button" role="tab" aria-controls="description" aria-selected="true">Описание</a>
            <a href="#specifications" class="nav-link" id="specifications-tab" data-bs-toggle="tab" type="button" role="tab" aria-controls="specifications" aria-selected="false">Характеристики</a>
            <a href="#reviews" class="nav-link" id="reviews-tab" data-bs-toggle="tab" type="button" role="tab" aria-controls="reviews" aria-selected="false">Отзывы</a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent" style="margin-bottom: 60px">

        {{-- ----------- Description ------------ --}}

        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            {!! to_paragraphs($product->description) !!}
        </div>


        {{-- ----------- Specifications ------------ --}}

        <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
            <table class="table spec_table mb-4">
                <tbody>
                @foreach($product->specifications->sortBy('sort') as $spec)
                    <tr>
                        <td>{{ $spec->name }}</td>
                        @php
                            $spec_value = $spec->pivot->spec_value;
                            $units = $spec->units;
                            if (in_array($spec->pivot->spec_value, ['нет', 'да', 'есть', '-'])) $units = '';
                        @endphp
                        @if($loop->first)
                        <td class="item_spec_col2">{{ $spec_value }} {{ $units }}</td>
                        @else
                        <td>{{ $spec_value }} {{ $units }}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>

            <livewire:compare-button :product_id="$product->id" :category_id="$product->category_id" size="big" type="extended" />
        </div>


        {{-- ----------- Reviews ------------ --}}

        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

            <div class="d-flex flex-column flex-sm-row mb-4">
                <div class="item_review_total_cont mb-3">
                    @if($product->rating)
                    <span class="item_review_total_score">{{ number_format($product->rating, 1, ',') }}</span>
                    @else
                    <span class="item_review_no_score lightgrey_text">Нет оценок</span>
                    @endif
                    <x-rating-stars tag="div" size="" :product="$product"/>
                </div>

                <div class="mb-3">
                    <table>
                        <tbody>
                        @for($i=5; $i>0; $i--)
                            <x-rating-bar :mark="$i" :num="$rating ? $rating[$i] : 0" :max="$rating ? $rating[0] : 0" />
                        @endfor
                        </tbody>
                    </table>
                </div>
            </div>

            @forelse($reviews as $review)
            @if($review->pros || $review->cons || $review->comnt)
            <x-review :review="$review" :userid="$user_id" />
            @endif
            @empty
            <div class="text-center fs-2 mb-4 lightgrey_text">
                Нет отзывов
            </div>
            @endforelse


            @if($user_id)
                @if($is_reviewed)
                    <h4 class="mb-3 pt-2 pb-4 lightgrey_text fw-normal">Ваш отзыв был опубликован</h4>
                @else
                    @include('layout.includes.review-form')
                @endif
            @else
                <h4 class="mb-3 pt-2 pb-4 lightgrey_text fw-normal">Зарегистрируйтесь или войдите, чтобы оставлять отзывы</h4>
            @endif

        </div>
    </div>



    @if($recently_viewed->count())
        <x-carousel title="Недавно просмотренные" section="crs_recently_viewed">
            @foreach($recently_viewed as $item)
                <x-product-card type="carousel" :product="$item" />
            @endforeach
        </x-carousel>
        <script>let carousel_perpage = 5;</script>
    @endif
</div>
@endsection

@push('css')
    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/splide.min.js') }}"></script>
    <script src="{{ asset('js/product.js') }}"></script>
@endpush

@if($recently_viewed->count())
    @push('scripts')
        <script src="{{ asset('js/recently_viewed.js') }}"></script>
    @endpush
@endif

