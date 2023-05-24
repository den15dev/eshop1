@extends('layout.layout')

@section('main_content')
    <div class="container">

        @if($products->count())
            <h2 class="mb-0">Корзина</h2>

            <div class="d-flex justify-content-end mb-3">
                <span class="d-block blue_link" onclick="clearCart()">Очистить корзину</span>
            </div>

            <div class="border-bottom"></div>

            @foreach($products as $product)
            <x-cart-row :product="$product" :index="$loop->index" />
            @endforeach

            <div class="cart_block">
                <div class="cart_descr"></div>
                <livewire:cart-total :cost="$cart_cost" />
            </div>


            <form method="post" class="cart_details_cont">
                <ul class="nav nav-tabs mb-4" id="delivery_tab_cont">
                    <li class="nav-item">
                        <div class="nav-link active" data-pageid="delivery">Доставка</div>
                    </li>
                    <li class="nav-item">
                        <div class="nav-link blue_link" data-pageid="self-delivery">Самовывоз</div>
                    </li>
                </ul>


                <div id="delivery_cont">
                    <label for="nameInput" class="form-label">Имя:</label>
                    <input type="text" name="name" class="form-control mb-4" id="nameInput" value="Александр">

                    <label for="phoneInput" class="form-label">Номер телефона:</label>
                    <input type="tel" name="phone" class="form-control mb-4" id="phoneInput" value="+7 (902) 735-56-24">

                    <!--<input type="tel" name="phone" class="form-control is-invalid" id="phoneInput" value="+7 (902) 735-56-24">
                    <div id="phoneInputFeedback" class="invalid-feedback mb-25">
                        Пожалуйста, укажите правильный номер телефона.
                    </div>-->

                    <label for="delAddrInput" class="form-label">Адрес доставки:</label>
                    <input type="tel" name="delivery_address" class="form-control mb-4" id="delAddrInput" value="Московская область, г. Видное, ул. Красного октября, 45, кв. 125">


                    <span class="d-block mb-2">Способ оплаты:</span>
                    <div class="mb-5" id="pay_method_cont">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pay_method" id="pay_method_online" checked>
                            <label class="form-check-label" for="pay_method_online">
                                Картой онлайн
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pay_method" id="pay_method_card_courier">
                            <label class="form-check-label" for="pay_method_card_courier">
                                Картой курьеру
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="pay_method" id="pay_method_cash_courier">
                            <label class="form-check-label" for="pay_method_cash_courier">
                                Наличными курьеру
                            </label>
                        </div>
                    </div>
                </div>


                <div id="self-delivery_cont" style="display: none">
                    <span class="d-block mb-2">Выберите магазин:</span>
                    <select class="form-select mb-4" aria-label="Выбор магазина">
                        <option selected>г. Москва, пр. Дежнёва, 21, ТЦ «Эго Молл»</option>
                        <option value="1">г. Москва, ул. Декабристов, 12, «ТЦ Форт»</option>
                        <option value="2">г. Москва, просп. Мира, 211, корп. 2, «ТРК Европолис»</option>
                        <option value="3">г. Москва, Алтуфьевское ш., 70, корп. 1, «ТЦ Маркос Молл»</option>
                        <option value="4">г. Москва, Дмитровское ш., 43, корп. 1</option>
                    </select>

                    <label for="sd_nameInput" class="form-label">Имя:</label>
                    <input type="text" name="name" class="form-control mb-4" id="sd_nameInput" value="Александр">

                    <label for="sd_phoneInput" class="form-label">Номер телефона:</label>
                    <input type="tel" name="phone" class="form-control mb-4" id="sd_phoneInput" value="+7 (902) 735-56-24">

                    <!--<input type="tel" name="phone" class="form-control is-invalid" id="sd_phoneInput" value="+7 (902) 735-56-24">
                    <div id="phoneInputFeedback" class="invalid-feedback mb-25">
                        Пожалуйста, укажите правильный номер телефона.
                    </div>-->

                    <span class="d-block mb-2">Способ оплаты:</span>
                    <div class="mb-5" id="sd_pay_method_cont">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sd_pay_method" id="sd_pay_method_online" checked>
                            <label class="form-check-label" for="sd_pay_method_online">
                                Картой онлайн
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sd_pay_method" id="sd_pay_method_shop">
                            <label class="form-check-label" for="sd_pay_method_shop">
                                Картой или наличными в магазине
                            </label>
                        </div>
                    </div>
                </div>

                <script>
                    let tabCont = document.getElementById('delivery_tab_cont');
                    let tabBtnArr = Array.from(tabCont.getElementsByClassName('nav-link'));

                    [...tabBtnArr].forEach(function(tabBtn) {
                        tabBtn.onclick = function() {
                            if (tabBtn.className !== 'nav-link active') {
                                let btnId = tabBtn.getAttribute('data-pageid');
                                let btnPageCont = document.getElementById(btnId + '_cont');

                                [...tabBtnArr].forEach(function(prevActiveBtn) {
                                    if (prevActiveBtn.className === 'nav-link active') {
                                        prevActiveBtn.className = 'nav-link blue_link';
                                        let prevActiveBtnId = prevActiveBtn.getAttribute('data-pageid');
                                        let prevActivePageCont = document.getElementById(prevActiveBtnId + '_cont');
                                        prevActivePageCont.style.display = 'none';
                                    }
                                });

                                tabBtn.className = 'nav-link active';
                                btnPageCont.style.display = 'block';
                            }
                        };
                    });
                </script>

                <button type="submit" class="btn2 btn2-primary cart_order_btn">Оформить заказ</button>
            </form>


        @else

            <div class="text-center fs-2 lightgrey_text" style="padding: 120px 0">
                Корзина пуста
            </div>

            @if($recently_viewed->count())
                <x-carousel title="Недавно просмотренные" section="crs_recently_viewed">
                    @foreach($recently_viewed as $item)
                        <x-product-card type="carousel" :product="$item" />
                    @endforeach
                </x-carousel>
                <script>let carousel_perpage = 5;</script>

                @push('css')
                    <link href="{{ asset('css/splide.min.css') }}" rel="stylesheet">
                @endpush

                @push('scripts')
                    <script src="{{ asset('js/splide.min.js') }}"></script>
                    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
                    <script src="{{ asset('js/recently_viewed.js') }}"></script>
                @endpush
            @endif
        @endif

    </div>
@endsection

@push('scripts')
<script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
<script src="{{ asset('js/cart.js') }}"></script>
@endpush
