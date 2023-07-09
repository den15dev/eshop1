@extends('admin.layout')

@section('page_title', $brand->name . ' - редактирование')

@section('main_content')

    <h3 class="mb-3"><a href="{{ route('brand', $brand->slug) }}" class="dark_link">{{ $brand->name }}</a></h3>

    <div class="adm_form_cont">
        <form class="mb-45" method="POST" action="{{ route('admin.brands.update', $brand->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.input name="name" label="Название" :value="$brand->name" />

            <x-admin.input name="slug" label="Slug" :value="$brand->slug" note="Только латинские буквы, цифры и дефис." />
            <input type="hidden" name="slug_old" value="{{ $brand->slug }}" />

            <x-admin.textarea name="description" label="Описание" :value="$brand->description" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-5" method="POST" enctype="multipart/form-data" action="{{ route('admin.brands.update', $brand->id) }}" novalidate>
            @method('PUT')
            @csrf
            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-3">Лучше загружать *.svg. Также можно *.jpg, или *.png — минимум 260 px по ширине.</div>
            @php
                $image_path = getImageByNameBase('storage/images/brands/' . $brand->slug);
            @endphp
            @if(!empty($image_path))
                <div style="width: 260px">
                    <img class="mb-3 w-100" src="{{ $image_path }}" alt="" />
                </div>
            @endif

            <div>
                <input type="file" name="image" class="form-control @if ($errors->get('image')) is-invalid @endif" accept=".jpg,.png,.svg">
                @if ($errors->get('image'))
                    <div class="invalid-feedback">
                        {{ $errors->get('image')[0] }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="image_form" value="image" />
            <input type="hidden" name="slug" value="{{ $brand->slug }}" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-5" method="POST" action="{{ route('admin.brands.destroy', $brand->id) }}" onsubmit="return confirmDeleting(this, 'удалить бренд {{ $brand->name }}?')" novalidate>
            @method('DELETE')
            @csrf

            <button type="submit" class="btn2 btn2-red px-4" style="width: fit-content;">Удалить бренд</button>
            <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> При удалении бренда у всех его товаров бренд будет неопределён.</div>
        </form>
    </div>
@endsection
