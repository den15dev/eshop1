@extends('admin.layout')

@section('page_title', 'Магазины - Администрирование')

@section('main_content')

    <h2 class="mb-4">Магазины</h2>

    <div class="mb-4">
        <div class="adm_add_btn_cont">
            <a href="{{ route('admin.' . $table_name . '.create') }}" class="btn2 btn2-red mb-4 adm_add_btn">
                <span class="bi-plus"></span>
                Добавить магазин
            </a>
        </div>

        <div>
            @php
                $is_active_col = false;
                foreach ($columns as $col) {
                    if ($col['column'] === 'is_active') $is_active_col = true;
                }
            @endphp
            @if($is_active_col)
                <div class="mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="show_active" value="" id="chb_active" checked>
                        <label class="form-check-label" for="chb_active">
                            Активные
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="show_inactive" value="" id="chb_inactive" checked>
                        <label class="form-check-label" for="chb_inactive">
                            Не активные
                        </label>
                    </div>
                </div>
            @endif

            <div class="adm_search_input_cont">
                <input class="search_input" name="search" placeholder="Поиск" autocomplete="off" id="search_input">
                <span class="clear_btn bi-x-lg" id="clear_btn"></span>
            </div>
        </div>
    </div>


    <div class="overflow-auto" id="index_table_cont">

        @include('admin.includes.index-table')

    </div>

@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/search.js') }}"></script>
@endpush
