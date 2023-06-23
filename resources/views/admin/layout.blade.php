<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('page_title', config('app.name'))</title>
    <link rel="icon" type="image/png" href="{{ asset('img/electro_logo_16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('img/electro_logo_32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('img/electro_logo_64.png') }}" sizes="64x64">
    <link rel="apple-touch-icon" href="{{ asset('img/electro_logo_76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('img/electro_logo_120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('img/electro_logo_152.png') }}" sizes="152x152">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iMBQgaznrXNiJxzvihSn.css') }}" rel="stylesheet">
</head>
<body>

<div class="d-flex flex-column justify-content-between min-vh-100">

    @include('admin.includes.header')

    <main class="flex-grow-1">
        <div class="container">
            <div class="row adm_cont">

                @include('admin.includes.menu')

                <div class="col adm_main_cont">

                    @yield('main_content')

                </div>
            </div>
        </div>
    </main>

    @include('admin.includes.footer')

</div>

@include('layout.includes.loadtime')

<script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/joKWuogPVLryjouS5XHs/search.js') }}"></script>
<script src="{{ asset('js/joKWuogPVLryjouS5XHs/common.js') }}"></script>

</body>
</html>
