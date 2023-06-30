@extends('layout.layout')

@section('page_title', $promo->name . ' - ' . config('app.name'))

@section('main_content')
    @include('layout.includes.breadcrumb')

    <div class="container">

        <h2 class="mb-3">{{ $promo->name }}</h2>

        <p class="text-secondary">
            Акция действует до конца суток {{ \Carbon\Carbon::parse($promo->until)->isoFormat('D MMMM YYYY') }} года.
        </p>

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
