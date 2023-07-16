@extends('admin.layout')

@section('page_title', $category->name . ' - Редактирование')

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
        <form class="mb-45" method="POST" action="{{ route('admin.categories.update', $category->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.input name="name" label="Название" :value="$category->name" />

            <x-admin.input name="slug" label="Slug" :value="$category->slug" note="Только латинские буквы, цифры и дефис." />
            <input type="hidden" name="slug_old" value="{{ $category->slug }}" />

            <div class="row adm_field_cont">
                <x-admin.select layout="column"
                                name="parent_id"
                                label="Родительская категория"
                                :collection="$excluding_branch"
                                value="id"
                                option="name"
                                :selected="old('parent_id', $category->parent_id)"
                                novalue="0" />
                <x-admin.select layout="column"
                                name="sort"
                                label="Порядок в списке"
                                :collection="$siblings"
                                value="sort"
                                option="sort"
                                :selected="old('sort', $category->sort)"
                                :nullable="false" />
                <input type="hidden" name="parent_id_old" value="{{ $category->parent_id }}" />
                <input type="hidden" name="sort_old" value="{{ $category->sort }}" />
                <script>
                    const creating_new_category = false;
                    const old_parent_id = {{ $category->parent_id }};
                    const old_sort = {{ $category->sort }};
                </script>
            </div>

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>

        @unless($children->count())
            <form class="mb-45" method="POST" action="{{ route('admin.categories.update', $category->id) }}" novalidate>
                @method('PUT')
                @csrf
                @php
                    $specs_note = '<span class="fw-semibold text-color-main">Внимание!</span> Каждая характеристика должна быть на отдельной строке. ' .
                    'У имеющихся характеристик цифры слева (идентификаторы) изменять нельзя. При удалении существующей характеристики, её значение будет удалено у всех товаров данной категории.<br>' .
                    'Звёздочка в начале строки означает, что эта характеристика будет использоваться в фильтрах в каталоге, — её можно удалять или добавлять. ' .
                    'Единицы указываются в конце строки и заключаются в символы &lt; и &gt;. Характеристики можно менять местами и добавлять новые куда угодно — порядок учитывается.';
                @endphp
                <x-admin.textarea name="specs" label="Характеристики" :value="$spec_list" :note="$specs_note" />

                <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
            </form>
        @endunless


        <form class="mb-5" method="POST" enctype="multipart/form-data" action="{{ route('admin.categories.update', $category->id) }}" novalidate>
            @method('PUT')
            @csrf
            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-2">Только *.jpg, спрайт, 484х242 px</div>
            @php
                $image_path = 'storage/images/categories/' . $category->slug . '.jpg';
            @endphp
            @if(file_exists($image_path))
                <img class="mb-3" src="{{ asset($image_path) }}" alt="" />
            @endif

            <div>
                <input type="file" name="image" class="form-control @if ($errors->get('image')) is-invalid @endif" accept=".jpg">
                @if ($errors->get('image'))
                    <div class="invalid-feedback">
                        {{ $errors->get('image')[0] }}
                    </div>
                @endif
            </div>
            <input type="hidden" name="image_form" value="image" />
            <input type="hidden" name="slug" value="{{ $category->slug }}" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-5" method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirmDeleting(this, 'удалить категорию {{ $category->name }}?')" novalidate>
            @method('DELETE')
            @csrf

            @if($children->count() || $category->products_self)
                <div class="btn2 btn2-inactive px-4 mb-3">Удалить категорию</div>
                <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> Удалить можно только пустую категорию. Сначала удалите из категории все товары и дочерние категории.</div>
            @else
                <button type="submit" class="btn2 btn2-red px-4 mb-3" style="width: fit-content;">Удалить категорию</button>
                <div class="small grey_text fst-italic mb-2"><span class="fw-semibold text-color-main">Внимание!</span> Вместе с категорией будут безвозвратно удалены её характеристики и изображение.</div>
            @endif
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/category.js') }}"></script>
@endpush
