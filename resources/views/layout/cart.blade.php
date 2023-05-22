@extends('layout.layout')

@section('main_content')
    <div class="container">
        <h2 class="mb-2">Корзина</h2>

        <div class="d-flex justify-content-end mb-3">
            <a href="" class="d-block blue_link me-4">Получить ссылку</a>
            <a href="" class="d-block blue_link">Очистить корзину</a>
        </div>

        <div class="border-bottom"></div>


        <div class="cart_block border-bottom">
            <div class="cart_order">1</div>
            <a href="" class="cart_img">
                <img src="resources/catalog/1/1_001_242x242.jpg" alt="Процессор AMD Ryzen 9 5900X BOX">
            </a>
            <div class="cart_descr">
                <a class="d-block mb-2 cat_block_title" href="">
                    <span class="fw-semibold">Видеокарта MSI GeForce RTX 3070 GAMING Z TRIO (LHR)</span><br>
                    <span class="small">[PCI-E 4.0, 8 ГБ GDDR6, 256 бит, DisplayPort x3, HDMI, GPU 1500 МГц]</span>
                </a>
                <span class="d-block small mb-2">Код товара: 2369111</span>
                <span class="d-block text-dark fs-5">34 500 ₽</span>
            </div>
            <div class="cart_qty_price">
                <div class="cart_qty_cont">
                    <button class="item-decrease-btn" onclick="qtyUpdate(this, false, 34500, 5)">-</button>
                    <input type="text" class="item-qty-input" value="1">
                    <button class="item-increase-btn" onclick="qtyUpdate(this, true, 34500, 5)">+</button>
                </div>
                <span class="d-block text-dark fw-bold cart_price">
                <span>34 500</span> ₽
            </span>
            </div>
            <div class="cart_btns">
                <a href="" class="cart_btn_link" title="Удалить из корзины"><span class="bi-x-lg fs-5"></span></a>
            </div>
        </div>


        <div class="cart_block border-bottom">
            <div class="cart_order">2</div>
            <a href="" class="cart_img">
                <img src="resources/catalog/1/1_005_242x242.jpg" alt="Видеокарта MSI GeForce RTX 3070 GAMING Z TRIO (LHR)">
            </a>
            <div class="cart_descr">
                <a class="d-block mb-2 cat_block_title" href="">
                    <span class="fw-semibold">Видеокарта MSI GeForce RTX 3070 GAMING Z TRIO (LHR)</span><br>
                    <span class="small">[PCI-E 4.0, 8 ГБ GDDR6, 256 бит, DisplayPort x3, HDMI, GPU 1500 МГц]</span>
                </a>
                <span class="d-block small mb-2">Код товара: 2369111</span>
                <span class="d-block text-dark fs-5">490 ₽</span>
            </div>
            <div class="cart_qty_price">
                <div class="cart_qty_cont">
                    <button class="item-decrease-btn" onclick="qtyUpdate(this, false, 490, 12)">-</button>
                    <input type="text" class="item-qty-input" value="1">
                    <button class="item-increase-btn" onclick="qtyUpdate(this, true, 490, 12)">+</button>
                </div>
                <span class="d-block text-dark fw-bold cart_price">
                <span>490</span> ₽
            </span>
            </div>
            <div class="cart_btns">
                <a href="" class="cart_btn_link" title="Удалить из корзины"><span class="bi-x-lg fs-5"></span></a>
            </div>
        </div>


        <div class="cart_block">
            <div class="cart_descr"></div>
            <div class="cart_total_cont">
                <span class="cart_total_title">Общая стоимость:</span>
                <span class="fw-bold cart_total_price">
                <span id="cart_total_price">36 500</span> ₽
            </span>
            </div>
        </div>

        <script>
            function addSpaces(num, delimiter) {
                let decPart = '';
                let decMark = '';
                let isInteger = true;
                if (num%1 > 0.001) { isInteger = false; }

                let coupleArr = [];
                if (isInteger) {
                    coupleArr = num.toString().split('.');
                } else {
                    coupleArr = num.toFixed(2).toString().split('.');
                }

                if (coupleArr.length > 1) {
                    decPart = coupleArr[1];
                    decMark = delimiter;
                }
                return coupleArr[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1 ') + decMark + decPart;
            }


            function updateCart(prodId, newNum) {
                console.log('Updating ' + prodId + ' quantity to ' + newNum);

                // If cart updated successfully
                return true;
            }


            function getTotalPrice() {
                let cartBlockArr = Array.from(document.getElementsByClassName('cart_block'));
                let totalPrice = 0;
                [...cartBlockArr].forEach(function(blockElem) {
                    if (blockElem.getElementsByClassName('cart_price').length > 0) {
                        let prodSum = parseInt(blockElem.getElementsByClassName('cart_price')[0].getElementsByTagName('span')[0].innerText.replace(' ', ''), 10);
                        totalPrice += prodSum;
                    }
                });
                return totalPrice;
            }


            function qtyUpdate(btnElem, action, price, prodId) {
                let curProdSumElem = btnElem.parentNode.parentNode.getElementsByTagName('span')[0].getElementsByTagName('span')[0];
                let qtyInput = btnElem.parentNode.getElementsByClassName('item-qty-input')[0];
                let totalSumElem = document.getElementById('cart_total_price');
                let curNum = parseInt(qtyInput.value, 10);
                let isQtyChanged = true;

                if (action === true) {
                    curNum++;
                } else {
                    if (curNum > 1) { curNum--; }
                    else { isQtyChanged = false; }
                }

                if (isQtyChanged) {
                    if (updateCart(prodId, curNum)) {
                        qtyInput.value = curNum;
                        curProdSumElem.innerText = addSpaces(price*curNum, ',');
                        totalSumElem.innerText = addSpaces(getTotalPrice(), ',');
                    }
                }
            }
        </script>



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
    </div>
@endsection
