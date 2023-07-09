@extends('admin.layout')

@section('page_title', 'Добавление бренда | Администрирование')

@section('main_content')
    <h3 class="mb-4">Новый бренд</h3>

    <div class="adm_form_cont mb-5">
        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.brands.store') }}" novalidate>
            @csrf
            <x-admin.input name="name" label="Название" :value="''" />

            <x-admin.input name="slug" label="Slug" :value="''" note="Только латинские буквы, цифры и дефис." />

            <x-admin.textarea name="description" label="Описание" :value="''" />

            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-3">Лучше загружать *.svg. Также можно *.jpg, или *.png — минимум 260 px по ширине.</div>
            <div>
                <input type="file" name="image" class="form-control @if ($errors->get('image')) is-invalid @endif" accept=".jpg,.png,.svg">
                @if ($errors->get('image'))
                    <div class="invalid-feedback">
                        {{ $errors->get('image')[0] }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="image_form" value="image" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Создать</button>
        </form>
    </div>
@endsection
