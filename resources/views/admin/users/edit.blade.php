@extends('admin.layout')

@section('page_title', $user->name . ' - Администрирование')

@section('main_content')

    <h3 class="mb-3">{{ $user->name }}</h3>

    <div class="mb-4">
        @unless($user->role === 'boss')
            <x-admin.switch name="is_active_ui" label="Активен" :value="old('is_active', $user->is_active)" note="Неактивные пользователи не могут оставлять отзывы к товарам." />
            <script>
                const csrf_token = '{{ csrf_token() }}';
                const user_id = {{ $user->id }};
            </script>
        @endunless

        @if($user->image)
            <div class="mb-3">
                <img src="{{ asset('storage/images/users/' . $user->id . '/' . $user->image) }}" style="max-width: 300px" alt="">
            </div>
        @endif
        <span class="lightgrey_text">id:</span> {{ $user->id }}<br>
        <span class="lightgrey_text">Имя:</span> {{ $user->name }}<br>
        @php
            $verified = '';
            if ($user->role === 'user') {
                $verified = $user->email_verified_at
                    ? '<span class="fst-italic lightgrey_text">(подтверждён)</span>'
                    : '<span class="fst-italic text-color-red">(не подтверждён)</span>';
            }
        @endphp
        <span class="lightgrey_text">Email:</span> {{ $user->email }} {!! $verified !!}<br>
        <span class="lightgrey_text">Дата регистрации:</span> {{ \Carbon\Carbon::parse($user->created_at)->isoFormat('D MMMM YYYY') }}<br>
        @php
            $not_specified = '<span class="fst-italic lightgrey_text">не указан</span>';
        @endphp
        <span class="lightgrey_text">Телефон:</span> {!! $user->phone ?? $not_specified !!}<br>
        <span class="lightgrey_text">Адрес для доставки:</span>  {!! $user->address ?? $not_specified !!}<br>
        <span class="lightgrey_text">Завершено заказов:</span> {{ $user->orders->where('status', 'completed')->count() }}<br>
        <span class="lightgrey_text">Отменено заказов:</span> {{ $user->orders->where('status', 'cancelled')->count() }}<br>
        <span class="lightgrey_text">Активные заказы:</span> {{ $user->orders->whereNotIn('status', ['cancelled', 'completed'])->count() }}<br>
        <span class="lightgrey_text">Оставлено отзывов:</span> {{ $user->reviews_count }}<br>
        <span class="lightgrey_text">Роль:</span> {!! $user->role === 'user' ? $user->role_str : '<span class="text-color-red">' . $user->role_str . '</span>' !!}<br>
    </div>

    <div class="d-flex flex-row mb-2">
        @if($current_user->isBoss() && $user->role !== 'boss')
            @if($user->role === 'admin')
                <form class="me-2" method="POST" action="{{ route('admin.users.update', $user->id) }}" onsubmit="return confirmAdminPromotion(this, 'сделать {{ $user->name . ' (id: ' . $user->id . ')' }} обычным пользователем?')" novalidate>
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="role" value="user" />
                    <button type="submit" class="btn2 btn2-primary px-4">Сделать пользователем</button>
                </form>
            @else
                <form class="me-2" method="POST" action="{{ route('admin.users.update', $user->id) }}" onsubmit="return confirmAdminPromotion(this, 'сделать пользователя {{ $user->name . ' (id: ' . $user->id . ')' }} администратором?')" novalidate>
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="role" value="admin" />
                    <button type="submit" class="btn2 btn2-primary px-4">Сделать администратором</button>
                </form>
            @endif
        @endif

        @unless($user->role === 'boss')
            <form class="me-2" method="POST" action="{{ route('admin.users.update', $user->id) }}" onsubmit="return confirmDeleting(this, 'удалить аккаунт пользователя {{ $user->name . ' (id: ' . $user->id . ')' }}?')" novalidate>
                @method('DELETE')
                @csrf
                <button type="submit" class="btn2 btn2-red px-4">Удалить аккаунт</button>
            </form>
        @endunless
    </div>

    @unless($user->role === 'boss')
        <div class="small grey_text fst-italic mb-5"><span class="fw-semibold text-color-main">Внимание!</span> При удалении аккаунта пользователя его корзина, избранное и уведомления будут безвозвратно удалены. Его заказы и отзывы к товарам останутся и будут иметь неопределённый id пользователя.</div>
    @endunless
@endsection

@push('scripts')
    <script src="{{ asset('js/joKWuogPVLryjouS5XHs/user.js') }}"></script>
@endpush
