@extends('layout.layout')

@section('main_content')
    <div class="container">

        <form method="POST" class="login_form mx-auto" action="{{ route('login') }}" novalidate>
            @csrf
            <div class="mb-4">
                <h2>Вход</h2>
            </div>


            <div class="mb-3">
                <label for="email" class="form-label">Адрес электронной почты:</label>
                <input type="email" name="email" class="form-control @if ($errors->get('email')) is-invalid @endif" id="email" value="{{ old('email') }}" required autofocus autocomplete="username">

                @if ($errors->get('email'))
                    <div id="emailInputFeedback" class="invalid-feedback">
                        {{ $errors->get('email')[0] }}
                    </div>
                @endif
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Пароль:</label>
                <input type="password" name="password" class="form-control @if ($errors->get('password')) is-invalid @endif" id="password" required autocomplete="current-password">

                @if ($errors->get('password'))
                    <div id="passwordInputFeedback" class="invalid-feedback">
                        {{ $errors->get('password')[0] }}
                    </div>
                @endif
            </div>

            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember_me">
                <label class="form-check-label" for="remember_me">Запомнить меня</label>
            </div>

            @if($guest_settings)
                <x-move-guest-settings :settings="$guest_settings" />
            @endif

            <button type="submit" class="btn2 btn2-primary login_btn w-100 mt-3 mb-3">Войти</button>

            <a href="{{ route('password.request') }}" class="blue_link">Забыли пароль?</a>
        </form>

    </div>
@endsection
