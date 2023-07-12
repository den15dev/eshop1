@extends('layout.layout')

@section('page_title', $promo->name . ' - ' . config('app.name'))

@section('main_content')
    @include('layout.includes.breadcrumb')

    <div class="container">

        <h2 class="mb-3">{{ $promo->name }}</h2>

        @php
            $started_at = \Carbon\Carbon::parse($promo->started_at);
            $until = \Carbon\Carbon::parse($promo->until);
        @endphp
        @if($until->isPast())
            <p class="promo_inactive_badge">
                Акция завершена
            </p>
        @else
            <p class="text-secondary">
                @if($started_at->year === $until->year)
                    Акция действует с {{ $started_at->isoFormat('D MMMM') }} по {{ $until->isoFormat('D MMMM YYYY') }} года.
                @else
                    Акция действует с {{ $started_at->isoFormat('D MMMM YYYY') }} года по {{ $until->isoFormat('D MMMM YYYY') }} года.
                @endif
            </p>
        @endif


        <p class="mb-45">
            {{ $promo->description }}
        </p>

        <img src="{{ asset('storage/images/promos/' . $promo->id . '/' . $promo->image) }}" class="mb-5">

        <div class="container mb-5 block_container">
            @if($products->isNotEmpty())
                <h3 class="mb-4">Товары, участвующие в акции:</h3>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                    @foreach($products as $item)
                        <div class="col px-0 pb-1">
                            <x-product-card type="promo" :product="$item" />
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
