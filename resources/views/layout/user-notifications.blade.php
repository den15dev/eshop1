@extends('layout.layout')

@section('page_title', 'Уведомления - ' . config('app.name'))

@section('main_content')
    <div class="container">

        @if($notifications->count())
            <h2 class="mb-4">Уведомления</h2>

            <livewire:unread-notification-head :user_id="$user_id" :num="$unread_num" :report="$unread_report" />

            @foreach($notifications as $notification)
                <x-user-notification :notification="$notification" />
            @endforeach

            @push('scripts')
                <script src="{{ asset('js/user-notifications.js') }}"></script>
            @endpush
        @else
            <div class="text-center fs-2 lightgrey_text" style="padding: 120px 0">
                Уведомлений пока нет
            </div>
        @endif

    </div>
@endsection
