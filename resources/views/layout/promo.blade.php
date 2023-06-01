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

        <img src="{{ asset('storage/images/promos/' . $promo->id . '/' . $promo->image) }}" class="mb-45">

        <h3 class="mb-3">Товары, участвующие в акции:</h3>
    </div>
@endsection
