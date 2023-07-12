@extends('admin.layout')

@section('page_title', $promo->name . ' - Редактирование')

@section('main_content')

    <h3 class="mb-3"><a href="{{ route('promo', $promo->slug . '-' . $promo->id) }}" class="dark_link">{{ $promo->name }}</a></h3>

    @php
        $started_at = \Carbon\Carbon::parse($promo->started_at);
        $until = \Carbon\Carbon::parse($promo->until);
    @endphp
    @if($until->isPast())
        <div class="promo_inactive_badge small mb-3">Акция закончилась {{ $until->diffForHumans() }}</div>
    @elseif($started_at->isFuture())
        <div class="promo_inactive_badge small mb-3">Акция начнётся через {{ trans_choice(':count день|:count дня|:count дней', $started_at->diffInDays()) }}</div>
    @else
        <div class="promo_active_badge small mb-3">Действующая акция</div>
    @endif

    <div class="adm_form_cont mb-5">
        <form class="mb-45" method="POST" action="{{ route('admin.promos.update', $promo->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.input name="name" label="Название" :value="$promo->name" />

            <div class="row adm_field_cont">
                <x-admin.input layout="column" name="started_at" label="Дата начала" :value="$started_at->isoFormat('DD.MM.YYYY')" />
                <x-admin.input layout="column" name="until" label="Дата окончания" :value="$until->isoFormat('DD.MM.YYYY')" />
            </div>

            <x-admin.textarea name="description" label="Описание" :value="$promo->description" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-45" method="POST" enctype="multipart/form-data" action="{{ route('admin.promos.update', $promo->id) }}" novalidate>
            @method('PUT')
            @csrf
            <div class="grey_text mb-1">Изображение:</div>
            <div class="small grey_text fst-italic mb-3">Только *.jpg, 1296 х 500 px.</div>

            @if(!empty($promo->image))
            <div>
                <img class="mb-3 w-100" src="{{ asset('storage/images/promos/' . $promo->id . '/' . $promo->image) }}" alt="" />
            </div>
            <input type="hidden" name="old_image" value="{{ $promo->image }}" />
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

            <button type="submit" class="btn2 btn2-primary submit_btn">Сохранить</button>
        </form>


        <form class="mb-45" method="POST" action="{{ route('admin.promos.update', $promo->id) }}" novalidate>
            @method('PUT')
            @csrf
            <x-admin.input name="add_products" label="Добавить товары к акции" :value="''" note="Введите через запятую и тире id товаров, которые вы хотите добавить к акции.<br>Например: 14,38,41-47,62" />

            <button type="submit" class="btn2 btn2-primary submit_btn">Добавить</button>
        </form>

        <div id="products_table_cont">
            @include('admin.promos.product-table')
        </div>

        <form class="mb-5" method="POST" action="{{ route('admin.promos.destroy', $promo->id) }}" onsubmit="return confirmDeleting(this, 'удалить акцию {{ $promo->name }}?')" novalidate>
            @method('DELETE')
            @csrf
            <button type="submit" class="btn2 btn2-red px-4" style="width: fit-content;">Удалить акцию</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/promo.js') }}"></script>
@endpush
