@extends('layout.layout')

@section('page_title', $brand->name . ' - ' . config('app.name'))

@section('main_content')
    <div class="container pt-3">

        <div class="brand_head_cont mb-5">
            <div class="brand_logo mb-4">
                <img src="{{ get_any_image('storage/images/brands/' . $brand->slug) }}" alt="{{ $brand->name }}">
            </div>

            {!! to_paragraphs($brand->description) !!}
        </div>

        @if($categories->count())
            <h3 class="mb-3">Товары {{ $brand->name }} в категориях:</h3>

            <div class="container mb-5 pb-4 block_container">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
                    @foreach($categories as $category)
                        <x-category-card :category="$category" :brand="$brand" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
