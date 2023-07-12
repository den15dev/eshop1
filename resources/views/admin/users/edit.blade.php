@extends('admin.layout')

@section('page_title', $user->name . ' - Администрирование')

@section('main_content')

    <h3 class="mb-3">{{ $user->name }}</h3>


@endsection
