@extends('layout.layout')

@section('page_title', $category->name . ' - ' . config('app.name'))

@section('main_content')
    @include('layout.includes.breadcrumb')

    <div class="container mb-5 pb-4 block_container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-5">
        @foreach($children as $category)
        <x-category-card :category="$category" />
        @endforeach
        </div>
    </div>
@endsection
