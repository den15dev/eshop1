@extends('layout.layout')

@section('main_content')
    <div class="container">
        <form method="POST" class="login_form mx-auto" action="{{ route('password.email') }}" novalidate>
            @csrf
            <div class="mb-5">
                Забыли ваш пароль? Не проблема. Просто укажите свой адрес email и мы отправим вам ссылку для сброса пароля.
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


            <button type="submit" class="btn2 btn2-primary login_btn w-100 mb-3">Отправить ссылку</button>

        </form>
    </div>
@endsection
