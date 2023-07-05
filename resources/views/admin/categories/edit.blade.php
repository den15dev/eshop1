@extends('admin.layout')

@section('page_title', 'Редактирование - ' . $category->name)

@section('main_content')

    <h3 class="mb-3">{{ $category->name }}</h3>

    <div class="adm_add_btn_cont my-3 my-md-0">
        <a href="{{ route('admin.categories.create', ['parent' => $category->id]) }}" class="btn2 btn2-primary adm_add_btn">
            <span class="bi-plus"></span>
            Добавить дочернюю категорию
        </a>
    </div>

    <div class="mb-3">
        @if($children->count())
            <span class="grey_text">Дочерние категории:</span>
            <ul class="list-unstyled ps-3">
                @foreach($children as $child_cat)
                <li><a href="{{ route('admin.categories.edit', $child_cat->id) }}" class="blue_link">{{ $child_cat->name }}</a>{!! $child_cat->products_total ? ' <span class="lightgrey_text small">' . $child_cat->products_total . '</span>' : '' !!}</li>
                @endforeach
            </ul>
        @else
            <span class="grey_text">Нет дочерних категорий.</span>
        @endif
    </div>

    <div class="mb-3 grey_text">
        @if($category->products_self)
            <div>Товаров в этой категории: <span class="text-color-main">{{ $category->products_self }}</span></div>
        @else
            <div>В этой категории нет товаров.</div>
        @endif

        @if($children->count() && $category->products_total)
            <div>Товаров во всех дочерних категориях, включая эту: <span class="text-color-main">{{ $category->products_total }}</span></div>
        @endif
    </div>

    @if($children->count() && $category->products_self)
        <div class="small grey_text fst-italic mb-3">
            <b class="text-color-main">Внимание!</b> Категории, имеющие дочерние категории, не могут иметь товары. Если в категории одновременно имеются товары и дочерние категории, то данные товары в каталоге показаны не будут.
        </div>
    @endif


    <div class="adm_form_cont">
        <form class="mb-5" method="POST" action="{{ route('admin.categories.update', $category->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.input name="name" label="Название" :value="$category->name" />

            <x-admin.input name="slug" label="Slug (только латинские буквы, цифры и дефис)" :value="$category->slug" />

            <div class="row adm_field_cont">
                <x-admin.select layout="column"
                                name="parent_id"
                                label="Родительская категория"
                                :collection="$excluding_branch"
                                value="id"
                                option="name"
                                :selected="$category->parent_id" />
                <x-admin.select layout="column"
                                name="sort"
                                label="Порядок в списке"
                                :collection="$siblings"
                                value="sort"
                                option="sort"
                                :selected="$category->sort"
                                :nullable="false" />
            </div>

            @unless($children->count())
                @php
                    $specs_note = 'Каждая характеристика должна быть на отдельной строке. Звёздочка в начале строки ' .
                    'означает, что эта характеристика будет использоваться в фильтрах в каталоге. Единицы указываются в конце строки и заключаются в символы &lt; и &gt;.';
                @endphp
                <x-admin.textarea name="specs" label="Характеристики" :value="$spec_list" :note="$specs_note" />
            @endunless

            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-2">Спрайт, 484х242 px</div>
            @php
                $image_path = 'storage/images/categories/' . $category->slug . '.jpg';
            @endphp
            @if(file_exists($image_path))
                <img src="{{ asset($image_path) }}" alt="" />
            @endif
            <input class="mt-3" name="image" type="file" accept=".jpg">

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-5" method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirmDeleting(this, 'удалить категорию {{ $category->name }}?')" novalidate>
            @method('DELETE')
            @csrf

            @if($children->count() || $category->products_self)
                <div class="btn2 btn2-inactive px-4">Удалить категорию</div>
                <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> Удалить можно только пустую категорию. Сначала удалите из категории все товары и дочерние категории.</div>
            @else
                <button type="submit" class="btn2 btn2-red px-4" style="width: fit-content;">Удалить категорию</button>
                <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> Вместе с категорией будут безвозвратно удалены характеристики и изображение.</div>
            @endif
        </form>
    </div>
@endsection
