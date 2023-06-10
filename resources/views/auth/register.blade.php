@extends('layout.layout')

@section('main_content')
    <div class="container">
        <div class="login_cont mx-auto">
            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <div class="mb-4">
                    <h2>Регистрация</h2>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Ваше имя:</label>
                    <input type="text" name="name" class="form-control @if ($errors->get('name')) is-invalid @endif" value="{{ old('name') }}" id="name" required autofocus autocomplete="name">

                    @if ($errors->get('name'))
                        <div id="nameInputFeedback" class="invalid-feedback">
                            {{ $errors->get('name')[0] }}
                        </div>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="email" class="form-label">Адрес электронной почты:</label>
                    <input type="email" name="email" class="form-control @if ($errors->get('email')) is-invalid @endif" value="{{ old('email') }}" id="email" required autocomplete="username">


                    @if ($errors->get('email'))
                        <div id="emailInputFeedback" class="invalid-feedback">
                            {{ $errors->get('email')[0] }}
                        </div>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="password" class="form-label">Пароль:</label>
                    <input type="password" name="password" class="form-control @if ($errors->get('password')) is-invalid @endif" id="password">

                    @if ($errors->get('password'))
                        <div id="passwordInputFeedback" class="invalid-feedback">
                            {{ $errors->get('password')[0] }}
                        </div>
                    @endif
                </div>


                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Подтверждение пароля:</label>
                    <input type="password" name="password_confirmation" class="form-control @if ($errors->get('password_confirmation')) is-invalid @endif" id="password_confirmation">

                    @if ($errors->get('password_confirmation'))
                        <div id="password_confirmationInputFeedback" class="invalid-feedback">
                            {{ $errors->get('password_confirmation')[0] }}
                        </div>
                    @endif
                </div>


                @if($guest_settings)
                    <x-move-guest-settings :settings="$guest_settings" />
                @endif

                <button type="submit" class="btn2 btn2-primary login_btn mt-4 w-100">Зарегистрироваться</button>
            </form>
        </div>
    </div>
@endsection
