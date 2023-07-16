@extends('admin.layout')

@section('page_title', $shop->name . ' - Редактирование')

@section('main_content')
    <h3 class="mb-3">{{ $shop->name }}</h3>

    <div class="adm_form_cont">
        <form class="mb-45" method="POST" action="{{ route('admin.shops.update', $shop->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.switch name="is_active_ui" label="Активно" :value="old('is_active', $shop->is_active)" />
            <input type="hidden" name="is_active" value="{{ old('is_active', $shop->is_active) }}" id="is_active_input" />

            <div class="row adm_field_cont">
                <x-admin.input layout="column" name="name" label="Название" :value="$shop->name" />
                <x-admin.select layout="column"
                                name="sort"
                                label="Порядок в списке"
                                :collection="$shops_order"
                                value="sort"
                                option="sort"
                                :selected="old('sort', $shop->sort)"
                                :nullable="false" />
                <input type="hidden" name="sort_old" value="{{ $shop->sort }}" />
            </div>

            <x-admin.input name="address" label="Адрес" :value="$shop->address" />

            @php
                $location_note = 'В формате [широта, долгота], например: [55.82362, 37.49649]. Можно определить <a href="https://yandex.ru/map-constructor/location-tool/">здесь</a>.';
            @endphp
            <x-admin.input name="location" label="Координаты точки на карте" :value="$shop->location" :note="$location_note" />

            @php
                $hours_note = 'Каждый день недели должен быть на отдельной строке. Часы пишутся после двоеточия и должны разделяться между собой дефисом, например: Пн: 9-20. Допустимы только целые числа, без минут. Если выходной, оставляем пустое место.';
            @endphp
            <x-admin.textarea name="opening_hours" label="Часы работы" :value="$hours_list" :note="$hours_note" />

            <x-admin.textarea name="info" label="Информация" :value="$shop->info" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-5" method="POST" action="{{ route('admin.shops.destroy', $shop->id) }}" onsubmit="return confirmDeleting(this, 'удалить магазин {{ $shop->name }}?')" novalidate>
            @method('DELETE')
            @csrf

            <button type="submit" class="btn2 btn2-red px-4 mb-3" style="width: fit-content;">Удалить магазин</button>
            <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> Если в магазине уже были сделаны заказы, то удалить его не получится. Вместо этого сделайте магазин неактивным.</div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/shop.js') }}"></script>
@endpush
