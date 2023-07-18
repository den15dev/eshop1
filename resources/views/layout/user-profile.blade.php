@extends('layout.layout')

@section('page_title', 'Настройки аккаунта - ' . config('app.name'))

@section('main_content')
    <div class="container">

        <h2 class="mb-4">Настройки профиля</h2>

        <div class="row mb-4">
            <form class="col-12 col-lg-5" enctype="multipart/form-data" method="POST" action="{{ route('profile.update') }}">
                @csrf
                <span class="d-block grey_text">Фото</span>
                <span class="d-block small grey_text fst-italic mb-3">Размер файла изображения не должен превышать 5 Мб.<br>Разрешение не должно быть более 5000 px по любой из сторон.</span>
                @if($user->image)
                    <img src="{{ asset('storage/images/users/' . $user->id . '/' . $user->image) }}" class="mb-3" style="max-width: 300px">
                @endif
                <div class="mb-3">
                    <input type="file" class="form-control @if ($errors->get('user_image')) is-invalid @endif" name="user_image" accept=".jpg,.png" aria-label="user image">
                    @if ($errors->get('user_image'))
                        <div class="invalid-feedback">
                            {{ $errors->get('user_image')[0] }}
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn2 btn2-primary user_settings_btn">Сохранить</button>
            </form>
        </div>


        <div class="row">
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
            @endif

            <form class="col-12 col-lg-5 user_settings_form ms-0 me-auto" method="POST" action="{{ route('profile.update') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="nameInput" class="form-label grey_text">Имя:</label>
                    <input type="text" name="name" class="form-control @if ($errors->get('name')) is-invalid @endif" id="nameInput" value="{{ old('name', $user->name) }}">
                    @if ($errors->get('name'))
                        <div class="invalid-feedback">
                            {{ $errors->get('name')[0] }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="emailInput" class="form-label grey_text">Адрес электронной почты:</label>
                    <input type="email" name="email" class="form-control @if ($errors->get('email')) is-invalid @endif" id="emailInput" value="{{ old('email', $user->email) }}">
                    @if ($errors->get('email'))
                        <div class="invalid-feedback">
                            {{ $errors->get('email')[0] }}
                        </div>
                    @endif

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail)
                        @if($user->hasVerifiedEmail())
                            <div class="small text-color-green fst-italic mt-2 mb-2">
                                <span class="bi-check-lg me-1"></span>Адрес подтверждён.
                            </div>
                        @else
                            <div class="small grey_text fst-italic mt-2 mb-2">
                                Адрес не подтверждён! При регистрации на вашу почту была отправлена ссылка для подтверждения, перейдите по ней.
                            </div>
                            <button type="submit" form="send-verification" class="btn2 btn2-secondary">Отправить ссылку ещё раз</button>
                            @if (session('status') === 'verification-link-sent')
                                <div class="mt-2 small text-color-green">
                                    Ссылка отправлена на почту.
                                </div>
                            @endif
                        @endif
                    @endif
                </div>

                <div class="mb-3">
                    <label for="phoneInput" class="form-label grey_text">Номер телефона:</label>
                    <input type="tel" name="phone" class="form-control @if ($errors->get('phone')) is-invalid @endif" id="phoneInput" value="{{ old('phone', $user->phone ?? '') }}">
                    @if ($errors->get('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->get('phone')[0] }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="delAddrInput" class="form-label grey_text">Адрес для доставки:</label>
                    <input type="tel" name="address" class="form-control @if ($errors->get('address')) is-invalid @endif" id="delAddrInput" value="{{ old('address', $user->address ?? '') }}">
                    @if ($errors->get('address'))
                        <div class="invalid-feedback">
                            {{ $errors->get('address')[0] }}
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn2 btn2-primary user_settings_btn">Сохранить</button>
            </form>


            <form class="col-12 col-lg-5 user_settings_form ms-0 me-auto" method="POST" action="{{ route('profile.update') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="currentPasswordInput" class="form-label grey_text">Текущий пароль:</label>
                    <div class="login_pass_cont">
                        <input type="password" name="current_password" class="form-control @if ($errors->get('current_password')) is-invalid @endif" id="currentPasswordInput">
                        @if ($errors->get('current_password'))
                            <div class="invalid-feedback">
                                {{ $errors->get('current_password')[0] }}
                            </div>
                        @else
                            <div class="login_pass_eye" onclick="passEyeToggle(this)">
                                <span class="bi-eye fs-5"></span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <label for="newPasswordInput" class="form-label grey_text">Новый пароль:</label>
                    <input type="password" name="new_password" class="form-control @if ($errors->get('new_password')) is-invalid @endif" id="newPasswordInput">
                    @if ($errors->get('new_password'))
                        <div class="invalid-feedback">
                            {{ $errors->get('new_password')[0] }}
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="newPasswordConfirmInput" class="form-label grey_text">Подтверждение нового пароля:</label>
                    <input type="password" name="new_password_confirmation" class="form-control @if ($errors->get('new_password_confirmation')) is-invalid @endif" id="newPasswordConfirmInput">
                    @if ($errors->get('new_password_confirmation'))
                        <div class="invalid-feedback">
                            {{ $errors->get('new_password_confirmation')[0] }}
                        </div>
                    @endif
                </div>

                <script>
                    let passVisibleState = false;
                    function passEyeToggle(eyeBtn) {
                        const eyeSpan = eyeBtn.getElementsByTagName('span')[0];
                        const currentPassInput = document.getElementById('currentPasswordInput');
                        const passInput = document.getElementById('newPasswordInput');
                        const passConfInput = document.getElementById('newPasswordConfirmInput');
                        if (passVisibleState) {
                            eyeSpan.className = 'bi-eye fs-5';
                            currentPassInput.type = 'password';
                            passInput.type = 'password';
                            passConfInput.type = 'password';
                            passVisibleState = false;
                        } else {
                            eyeSpan.className = 'bi-eye-slash fs-5';
                            currentPassInput.type = 'text';
                            passInput.type = 'text';
                            passConfInput.type = 'text';
                            passVisibleState = true;
                        }
                    }
                </script>
                <button type="submit" class="btn2 btn2-primary user_settings_btn">Сохранить</button>
            </form>
        </div>

    </div>
@endsection
