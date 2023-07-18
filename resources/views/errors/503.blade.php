<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Магазин электроники</title>
    <link rel="icon" type="image/png" href="{{ asset('img/electro_logo_16.png') }}" sizes="16x16">
    <link rel="icon" type="image/png" href="{{ asset('img/electro_logo_32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('img/electro_logo_64.png') }}" sizes="64x64">
    <link rel="apple-touch-icon" href="{{ asset('img/electro_logo_76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('img/electro_logo_120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('img/electro_logo_152.png') }}" sizes="152x152">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="not-found-cont">
            <div class="fs-1 fw-light lightgrey_text">Сайт временно недоступен</div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let notFoundCont = document.querySelector('.not-found-cont');
                notFoundCont.style.marginTop = (window.innerHeight - notFoundCont.clientHeight)/2 + 'px';
            });
        </script>
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
</body>
</html>
