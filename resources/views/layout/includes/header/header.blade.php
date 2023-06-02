<header class="mb-3 border-bottom">
    <div class="container text-end pe-3 pt-1 pb-1">
        <span class="bi-telephone me-2" style="font-size: 0.9rem;"></span>8-800-755-33-55
    </div>


    <nav class="navbar navbar-expand-lg bg-color-main" id="head_container2">
        <div class="container">
            <a class="navbar-brand mb-2 mb-lg-0 h1 fs-3 text-white" href="{{ route('home') }}">
                <svg class="bi me-1" style="vertical-align: -5px; fill: white;" width="32" height="32" role="img" aria-label="Shop logo"><use xlink:href="#electro-shop-logo"/></svg>
                Электроника
            </a>

            <form class="head_search_cont ms-auto ms-lg-3 ms-xl-5 me-0 me-lg-auto" method="GET" action="{{ route('search') }}">
                <div class="search_results_cont" id="search_result_cont"></div>
                <input class="search_input" name="query" placeholder="Поиск" autocomplete="off" id="search_input">
                <span class="clear_btn bi-x-lg" id="clear_btn"></span>
                <button class="search_btn" type="submit"><span class="bi-search"></span></button>
            </form>

            @include('layout.includes.header.menu_user')
        </div>
    </nav>


    <nav class="container p-2" role="navigation">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            @include('layout.includes.header.menu_left')

            @include('layout.includes.header.menu_right')

        </div>
    </nav>
</header>

