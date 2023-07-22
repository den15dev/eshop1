@extends('admin.layout')

@section('page_title', 'Журнал - Администрирование')

@section('main_content')

    <h3 class="mb-2">Журнал</h3>

    <div class="mb-4 small lightgrey_text">Обновлено: <span id="refresh_time">{{ now()->format('H:i:s') }}</span></div>

    @foreach($logs as $day_log)
    <div class="mb-45"{!! $loop->index === 0 ? ' data-date="' . $day_log[0] . '" id="today_cont"' : '' !!}>
        @include('admin.includes.log-day-block')
    </div>
    @endforeach
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/log.js') }}"></script>
@endpush
