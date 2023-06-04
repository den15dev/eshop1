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
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @stack('css')
    @livewireStyles
</head>
<body>

    @include('layout.includes.header.svgs')

    <div class="d-flex flex-column justify-content-between min-vh-100">

        @include('layout.includes.header.header')


        <main class="flex-grow-1">
            @yield('main_content')
        </main>


        @include('layout.includes.footer')

    </div>

    @unless(request()->routeIs('comparison'))
    <livewire:comparison-popup />
    @endunless

    @include('layout.includes.message-client')

    @include('layout.includes.loadtime')

    @livewireScripts
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
    <script src="{{ asset('js/common.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
    @stack('scripts')
</body>
</html>
