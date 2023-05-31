@extends('layout.layout')

@section('main_content')
    <div class="container">
        <x-order-block :order="$order" type="new"/>
    </div>
@endsection
