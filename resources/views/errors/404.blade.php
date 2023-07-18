@extends('layout.layout')

@section('page_title', 'Страница не найдена - ' . config('app.name'))

@section('main_content')
    <div class="container">
        <div class="not-found-cont">
            <div class="fs-1 fw-light lightgrey_text">Страница не найдена</div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let mainCont = document.getElementsByTagName('main')[0];
                let notFoundCont = document.querySelector('.not-found-cont');
                notFoundCont.style.marginTop = (mainCont.clientHeight - notFoundCont.clientHeight)/2 + 'px';
            });
        </script>
    </div>
@endsection
