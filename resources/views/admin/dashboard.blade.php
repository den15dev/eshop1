@extends('admin.layout')

@section('page_title', 'Статистика - Администрирование')

@section('main_content')

    <h3 class="mb-3">Статистика</h3>

    <div class="d-flex flex-column flex-sm-row mb-3">
        <select class="form-select w-auto mb-2 mb-sm-0 me-sm-2" aria-label="Выбрать год" id="year_select">
            @foreach($years as $year)
                <option value="{{ $year }}"{{ $year === $current_year ? ' selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>

        <select class="form-select w-auto mb-2 mb-sm-0 me-sm-2" aria-label="Выбрать месяц" id="month_select">
            <option value="0">За весь год</option>
            @foreach($months as $month)
                <option value="{{ $month[0] }}"{{ $month[0] === $current_month ? ' selected' : '' }}>{{ $month[1] }}</option>
            @endforeach
        </select>
    </div>

    <div class="row" id="dashboard">
        @include('admin.includes.dashboard')
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/dashboard.js') }}"></script>
@endpush
