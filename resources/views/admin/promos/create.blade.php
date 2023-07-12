@extends('admin.layout')

@section('page_title', 'Новая промо-акция | Администрирование')

@section('main_content')
    <h3 class="mb-4">Новая промо-акция</h3>

    <div class="adm_form_cont mb-5">
        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.promos.store') }}" novalidate>
            @csrf
            <x-admin.input name="name" label="Название" :value="''" />

            <div class="row adm_field_cont">
                <x-admin.input layout="column" name="started_at" label="Дата начала" :value="now()->isoFormat('DD.MM.YYYY')" />
                <x-admin.input layout="column" name="until" label="Дата окончания" :value="''" />
            </div>

            <x-admin.textarea name="description" label="Описание" :value="''" />


            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-3">Только *.jpg, 1296 х 500 px.</div>

            <div class="mb-3">
                <input type="file" name="image" class="form-control @if ($errors->get('image')) is-invalid @endif" accept=".jpg">
                @if ($errors->get('image'))
                    <div class="invalid-feedback">
                        {{ $errors->get('image')[0] }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="image_form" value="image" />


            <x-admin.input name="add_products" label="Добавить товары к акции" :value="''" note="Введите через запятую и тире id товаров, которые вы хотите добавить к акции.<br>Например: 14,38,41-47,62" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Создать</button>
        </form>
    </div>
@endsection
