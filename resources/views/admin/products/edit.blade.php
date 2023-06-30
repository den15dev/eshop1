@extends('admin.layout')

@section('page_title', 'Редактирование - ' . $product->name)

@section('main_content')

    <h3 class="mb-2"><a href="{{ route('product', [$product->category_slug, $product->slug . '-' . $product->id]) }}" class="dark_link">{{ $product->name }}</a></h3>

    <div class="mb-4">Код товара (id): {{ $product->id }}</div>

    <div class="adm_form_cont">
        <form class="mb-45" method="POST" action="{{ route('admin.products.update', $product->id) }}" novalidate>
            @method('PUT')
            @csrf

            <x-admin.switch name="is_active_ui" label="Активно (товар в продаже)" :value="old('is_active', $product->is_active)" />
            <input type="hidden" name="is_active" value="{{ old('is_active', $product->is_active) }}" id="is_active_input" />

            <x-admin.input name="name" label="Наименование" :value="$product->name" />
            <x-admin.textarea name="short_descr" label="Краткое описание" :value="$product->short_descr" />

            <div class="row adm_field_cont">
                <x-admin.select layout="column" name="brand_id" label="Бренд" :data="$brands" :selected="$product->brand_id" />
                <x-admin.input layout="column" name="sku" label="Код производителя" :value="$product->sku" />
            </div>

            <div class="row adm_field_cont">
                <x-admin.input layout="column" name="price" label="Цена" :value="$product->price" />
                <x-admin.input layout="column" name="discount_prc" label="Скидка, %" :value="$product->discount_prc" />
                <x-admin.input layout="column" name="final_price_pretty" label="Итоговая цена" :value="format_price($product->final_price) . ' ₽'" :disabled="true" />
                <input type="hidden" name="final_price" id="final_price_input" value="{{ $product->final_price }}" />
            </div>

            <x-admin.textarea name="description" label="Полное описание" :value="$product->description" />

            <x-admin.select name="promo_id" label="Участвует в акции" :data="$promos" :selected="$product->promo_id" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        {{-- ----------------- Images ----------------- --}}

        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.products.update', $product->id) }}" id="image_form" novalidate>
            @method('PUT')
            @csrf
            <div class="grey_text mb-3">Изображения:</div>

            <div class="adm_img_cont" id="item_edit_img_cont">
                @if($product->images)
                @foreach($product->images as $filename)
                    <x-admin.image-block :loop="$loop" :itemid="$product->id" :filename="$filename" />
                @endforeach
                @endif

                <input class="mb-3 mt-2" name="new_image" type="file" accept=".jpg" id="img_select_input">
                <input type="hidden" name="images" id="images_input" value="{{ $product->images ? json_encode($product->images) : '' }}" />

                <div class="d-flex">
                    <button type="submit" class="btn2 btn2-primary submit_btn" style="display: none; margin-top: 0" id="img_submit_btn">Сохранить</button>
                    <div class="btn2 btn2-inactive submit_btn" style="margin-top: 0" id="img_inactive_btn">Сохранить</div>
                    <div class="img_loader_cont" style="display: none" id="loader_cont"></div>
                </div>
            </div>
        </form>


        {{-- ----------------- Specifications ----------------- --}}

        <form class="mb-45" method="POST" action="{{ route('admin.products.update', $product->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.select name="category_id" label="Категория" :data="$categories" :selected="$product->category_id" :nullable="false" />
            <input type="hidden" name="old_category_id" id="old_category_id_input" value="{{ $product->category_id }}" />
            <script>const product_id = {{ $product->id }};</script>

            <div class="adm_field_cont" style="margin-top: -9px">
                <a href="{{ route('admin.categories.edit', $product->category_id) }}" class="blue_link" id="category_edit_link">Перейти к настройкам категории</a>
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

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>Fancybox.bind("[data-fancybox]", {});</script>
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/product.js') }}"></script>
@endpush
