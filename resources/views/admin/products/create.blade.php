@extends('admin.layout')

@section('page_title', 'Новый товар | Администрирование')

@section('main_content')

    <h3 class="mb-4">Новый товар</h3>

    <div class="adm_form_cont mb-5">
        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.store') }}" novalidate>
            @csrf

            <x-admin.switch name="is_active_ui" label="Активно (товар в продаже)" :value="old('is_active', 0)" />
            <input type="hidden" name="is_active" value="{{ old('is_active', 0) }}" id="is_active_input" />

            <x-admin.input name="name" label="Наименование" :value="''" />
            <x-admin.textarea name="short_descr" label="Краткое описание" :value="''" />

            <div class="row adm_field_cont">
                <x-admin.select layout="column"
                                name="brand_id"
                                label="Бренд"
                                :collection="$brands"
                                value="id"
                                option="name"
                                :selected="old('brand_id', $brands[0]->id)"
                                :nullable="false" />
                <x-admin.input layout="column" name="sku" label="Код производителя" :value="''" />
            </div>

            <div class="row adm_field_cont">
                <x-admin.input layout="column" name="price" label="Цена" :value="0" />
                <x-admin.input layout="column" name="discount_prc" label="Скидка, %" :value="0" />
                <x-admin.input layout="column" name="final_price_pretty" label="Итоговая цена" :value="0" :readonly="true" />
                <input type="hidden" name="final_price" id="final_price_input" value="{{ old('final_price', 0) }}" />
            </div>

            <x-admin.textarea name="description" label="Полное описание" :value="''" />

            <x-admin.select name="promo_id"
                            label="Участвует в акции"
                            :collection="$promos"
                            value="id"
                            option="name"
                            :selected="old('promo_id')" />


            {{-- ----------------- Images ----------------- --}}

            <div class="my-4">
                <div class="grey_text mb-1">Изображения:</div>
                <div class="small grey_text fst-italic mb-25">Изображения будут преобразованы в квадрат, образовавшиеся пустые области будут залиты белым цветом. Минимальное разрешение по любой из сторон 1400 px, максимальное — 5000 px.</div>

                @if ($errors->get('image_files.*'))
                    <div class="alert alert-danger py-3" role="alert">
                        <ul class="list-unstyled mb-0">
                        @foreach($errors->get('image_files.*') as $message)
                            <li>{{ $message[0] }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-2">
                    <input name="image_files[]" type="file" accept=".jpg,.jpeg">
                </div>

                <div class="btn2 btn2-secondary" style="padding: 4px 14px 4px 8px; margin-top: 12px" onclick="addImageInput(this)"><span class="bi-plus me-1"></span>Добавить</div>
                <input type="hidden" name="images_num" value="" id="images_num">
            </div>


            {{-- ----------------- Specifications ----------------- --}}

            <x-admin.select name="category_id"
                            label="Категория"
                            :collection="$categories"
                            value="id"
                            option="name"
                            :selected="old('category_id', $categories[0]->id)"
                            :nullable="false" />
            <script>const product_id = null;</script>

            <div class="adm_field_cont" style="margin-top: -9px">
                <a href="{{ route('admin.categories.edit', $categories[0]->id) }}" class="blue_link" id="category_edit_link">Перейти к настройкам категории</a>
            </div>

            @php
                $bold_open = '<span class="fw-semibold text-color-main">';
                $bold_close = '</span>';

                $specs_note = 'Каждая характеристика должна быть на отдельной строке и разделяться от значения двоеточием. ' .
                $bold_open . 'Изменять характеристики слева от двоеточия нельзя.' . $bold_close . ' Это нужно делать ' .
                'в настройках категории. Справа от двоеточия можно оставлять пустое место — такая характеристика показана не будет.<br>' .
                'Звёздочка в начале строки означает, что эта характеристика будет использоваться в фильтрах в каталоге, ' .
                $bold_open . 'не оставляйте такие характеристики пустыми' . $bold_close . '.';
            @endphp
            <x-admin.textarea name="specs" label="Характеристики" :value="$spec_list" :note="$specs_note" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Создать</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/product.js') }}"></script>
@endpush
