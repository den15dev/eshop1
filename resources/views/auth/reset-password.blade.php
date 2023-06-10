@extends('layout.layout')

@section('main_content')
    <div class="container">
        <div class="login_cont mx-auto">
            <form method="POST" action="{{ route('password.store') }}" novalidate>
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="mb-4">
                    <h2>Сброс пароля</h2>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Адрес электронной почты:</label>
                    <input type="email" name="email" class="form-control @if ($errors->get('email')) is-invalid @endif" id="email" value="{{ old('email', $request->email) }}" required autocomplete="username">
                    @if ($errors->get('email'))
                        <div class="invalid-feedback">{{ $errors->get('email')[0] }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Новый пароль:</label>
                    <input type="password" name="password" class="form-control @if ($errors->get('password')) is-invalid @endif" id="password" required autofocus autocomplete="new-password">
                    @if ($errors->get('password'))
                        <div class="invalid-feedback">{{ $errors->get('password')[0] }}</div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля:</label>
                    <input type="password" name="password_confirmation" class="form-control @if ($errors->get('password_confirmation')) is-invalid @endif" id="password_confirmation" required autocomplete="new-password">
                    @if ($errors->get('password_confirmation'))
                        <div class="invalid-feedback">{{ $errors->get('password_confirmation')[0] }}</div>
                    @endif
                </div>

                <button type="submit" class="btn2 btn2-primary login_btn w-100 mt-3 mb-3">{{ __('Reset Password') }}</button>
            </form>
        </div>
    </div>
@endsection
