@extends('layout.layout')

@section('main_content')
    <div class="container">
        <div class="login_cont mx-auto">
            <div class="mb-3 grey_text">
                Пожалуйста, укажите адрес своей электронной почты и мы отправим Вам ссылку для сброса пароля.
            </div>

            <form method="POST" action="{{ route('password.email') }}" novalidate>
                @csrf
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
    </div>
@endsection
