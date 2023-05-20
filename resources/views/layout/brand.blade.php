@extends('layout.layout')

@section('main_content')
    <div class="container pt-3">

        <div class="brand_head_cont mb-5">
            <div class="brand_logo mb-4">
                <img src="{{ get_any_image('storage/images/brands/' . $brand->slug) }}" alt="{{ $brand->name }}">
            </div>

            {!! to_paragraphs($brand->description) !!}
        </div>

        <h3 class="mb-4">Товары {{ $brand->name }} в категориях:</h3>

    </div>
@endsection
