@extends('layout.layout')

@section('page_title', 'Заказ №' . $order->id . ' - ' . config('app.name'))

@section('main_content')
    <div class="container">
        <x-order-block :order="$order" type="new"/>
    </div>
@endsection
