@extends('admin.layout')

@section('page_title', 'Пользователь ' . $user_id . ' | Администрирование')

@section('main_content')

    Редактирование пользователя {{ $user_id }}

@endsection
