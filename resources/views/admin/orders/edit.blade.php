@extends('admin.layout')

@section('page_title', 'Заказ №' . $order_id . ' | Администрирование')

@section('main_content')

    Просмотр заказа №{{ $order_id }}

@endsection
