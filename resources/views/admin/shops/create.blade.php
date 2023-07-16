@extends('admin.layout')

@section('page_title', 'Новый магазин - Администрирование')

@section('main_content')
    <h3 class="mb-4">Новый магазин</h3>

    <div class="adm_form_cont mb-5">
        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.shops.store') }}" novalidate>
            @csrf
            <x-admin.switch name="is_active_ui" label="Активно" :value="old('is_active', 1)" />
            <input type="hidden" name="is_active" value="{{ old('is_active', 1) }}" id="is_active_input" />

            <div class="row adm_field_cont">
                <x-admin.input layout="column" name="name" label="Название" :value="''" />
                <x-admin.select layout="column"
                                name="sort"
                                label="Порядок в списке"
                                :collection="$shops_order"
                                value="sort"
                                option="sort"
                                :selected="old('sort', 1)"
                                :nullable="false" />
            </div>

            <x-admin.input name="address" label="Адрес" :value="''" />

            @php
                $location_note = 'В формате [широта, долгота], например: [55.82362, 37.49649]. Можно определить <a href="https://yandex.ru/map-constructor/location-tool/">здесь</a>.';
            @endphp
            <x-admin.input name="location" label="Координаты точки на карте" :value="''" :note="$location_note" />

            @php
                $hours_note = 'Каждый день недели должен быть на отдельной строке. Часы пишутся после двоеточия и должны разделяться между собой дефисом, например: Пн: 9-20. Допустимы только целые числа, без минут. Если выходной, оставляем пустое место.';
            @endphp
            <x-admin.textarea name="opening_hours" label="Часы работы" :value="$hours_list" :note="$hours_note" />

            <x-admin.textarea name="info" label="Информация" :value="''" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Создать</button>
        </form>
    </div>
@endsection
