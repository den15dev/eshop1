@extends('admin.layout')

@section('page_title', 'Редактирование - ' . $product->name)

@section('main_content')

    <h3 class="mb-3">{{ $product->name }}</h3>

    <div class="mb-3">id: {{ $product->id }}</div>

@endsection
