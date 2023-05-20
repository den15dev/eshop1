<ul class="d-flex flex-row justify-content-end navbar-nav ms-auto ms-lg-4 me-0 mt-2 mt-lg-0" id="usermenu">
    @guest
        <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">
                <span class="bi-lock me-1"></span>
                Вход
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">
                <span class="bi-person-fill me-1"></span>
                Регистрация
            </a>
        </li>
    @elseauth
        @if(Auth::user()->isAdmin())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.home') }}" style="margin-top: -1px">
                    <span class="bi-key me-1"></span>
                    Панель администратора
                </a>
            </li>
        @endif
        <li class="nav-item">
            <div class="user_btn_main_cont ms-1">
                <div class="user_btn_inner_cont" id="user_btn">
                    <span class="user_btn_name_cont">{{ Auth::user()->name }}</span>
                    <img class="user_btn_img" src="{{ asset('storage/images/users/' . (Auth::user()->image ?? 'menu_user_icon.png')) }}">
                    <div class="user_notify_dot dot_avatar_pos"></div>
                </div>
                <div class="user_btn_menu_cont bg-color-main" id="user_btn_menu">
                    <ul>
                        <li>
                            <a href="">
                                <span class="bi-gear me-1"></span>
                                Настройки
                            </a>
                        </li>
                        <li>
                            <a href="">
                            <span class="bi-bell me-1 count_label_cont">
                                <div class="user_notify_dot dot_icon_pos"></div>
                            </span>
                                Уведомления
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    <span class="bi-box-arrow-right me-1"></span>
                                    Выход
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
                <script>
                    let userBtn = document.getElementById('user_btn');
                    let userBtnMenu = document.getElementById('user_btn_menu');
                    let isUserMenuOpened = false;
                    userBtn.onclick = function() {
                        if (isUserMenuOpened) {
                            userBtnMenu.style.display = 'none';
                            isUserMenuOpened = false;
                        } else {
                            userBtnMenu.style.display = 'block';
                            isUserMenuOpened = true;
                        }
                    }
                    document.addEventListener('mouseup', function(e) {
                        if (isUserMenuOpened && !userBtn.contains(e.target)) {
                            userBtnMenu.style.display = 'none';
                            isUserMenuOpened = false;
                        }
                    });
                </script>
            </div>
        </li>
    @endguest
</ul>
