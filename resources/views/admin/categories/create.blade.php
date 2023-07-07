@extends('admin.layout')

@section('page_title', 'Новая категория | Администрирование')

@section('main_content')
    <h3 class="mb-4">Новая категория</h3>

    <div class="adm_form_cont mb-5">
        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.store') }}" novalidate>
            @csrf
            <x-admin.input name="name" label="Название" :value="''" />

            <x-admin.input name="slug" label="Slug" :value="''" note="Только латинские буквы, цифры и дефис." />

            <div class="row adm_field_cont">
                <x-admin.select layout="column"
                                name="parent_id"
                                label="Родительская категория"
                                :collection="$categories"
                                value="id"
                                option="name"
                                :selected="old('parent_id', $parent_id)"
                                novalue="0" />
                <x-admin.select layout="column"
                                name="sort"
                                label="Порядок в списке"
                                :collection="$root_sort"
                                value="sort"
                                option="sort"
                                :selected="old('sort', 1)"
                                :nullable="false" />
                <script>
                    const creating_new_category = true;
                    const old_parent_id = 0;
                    const old_sort = 1;
                </script>
            </div>

            @php
                $specs_note = '<span class="fw-semibold text-color-main">Внимание!</span> Каждая характеристика должна быть на отдельной строке. ' .
                'Если нужно, чтобы характеристика использовалась в фильтрах в каталоге, в начале строки поставьте звёздочку. ' .
                'Единицы указываются в конце строки и заключаются в символы &lt; и &gt;.<br>Пример:<br>' .
                '*Какая-то характеристика <ГГц>';
            @endphp
            <x-admin.textarea name="specs" label="Характеристики" :value="''" :note="$specs_note" />

            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-2">Спрайт, 484х242 px</div>
            <div>
                <input type="file" name="image" class="form-control @if ($errors->get('image')) is-invalid @endif" accept=".jpg">
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

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/category.js') }}"></script>
@endpush
