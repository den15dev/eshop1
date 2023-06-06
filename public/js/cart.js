function removeFromCart(product_id) {
    $.ajax({
        url: '/cart/remove',
        method: 'post',
        dataType: 'text',
        data: {product_id: product_id},
        success: function(){
            location.replace(location.href);
        },
        error: function () {
            showMessage({
                'type': 'warning',
                'message': '<b>Ошибка!</b><br>Не удалось удалить товар из корзины.<br>Пожалуйста, попробуйте ещё раз позднее.',
            });
        }
    });
}


function clearCart() {
    showMessage({
        'type': 'confirm',
        'message': 'Вы действительно хотите очистить корзину?',
        'ok': function () {
            $.ajax({
                url: '/cart/clear',
                method: 'post',
                dataType: 'text',
                data: {action: 'clear'},
                success: function(){
                    location.replace(location.href);
                },
                error: function () {
                    showMessage({
                        'type': 'warning',
                        'message': '<b>Ошибка!</b><br>Не удалось очистить корзину.<br>Пожалуйста, попробуйте ещё раз позднее.',
                    });
                }
            });
        },
        'okText': 'Очистить',
    });
}


/* --------------- Tabs ------------------ */

let tabCont = document.getElementById('delivery_tab_cont');
let tabBtnArr = Array.from(tabCont.getElementsByClassName('nav-link'));
const deliveryTypeInput = document.getElementById('delivery_type');

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
            deliveryTypeInput.value = btnId;
            switchPaymentMethods(btnId);
        }
    };
});

function switchPaymentMethods(tabId) {
    let card_cont = document.getElementById('pay_method_card_cont');
    let cash_cont = document.getElementById('pay_method_cash_cont');
    let shop_cont = document.getElementById('pay_method_shop_cont');

    if (tabId === 'delivery') {
        shop_cont.style.display = 'none';
        card_cont.style.display = 'block';
        cash_cont.style.display = 'block';
    } else {
        shop_cont.style.display = 'block';
        card_cont.style.display = 'none';
        cash_cont.style.display = 'none';
    }

    document.getElementById('pay_method_online').checked = true;
}


/* --------------- Validate form ------------------ */

function addErrorMessage(input, message) {
    const message_cont = document.createElement('div');
    message_cont.id = input.id + 'Feedback';
    message_cont.className = 'invalid-feedback mb-25';
    message_cont.appendChild(document.createTextNode(message));
    input.className = 'form-control is-invalid';

    input.parentNode.insertBefore(message_cont, input.nextSibling);
}

function removeErrorMessage(input) {
    const message_cont = document.getElementById(input.id + 'Feedback');
    if (message_cont) {
        input.className = 'form-control mb-4';
        message_cont.remove();
    }
}

function validateName(nameInput) {
    removeErrorMessage(nameInput);
    let message = '';
    if (nameInput.value.length < 2) {
        message = 'Пожалуйста, укажите ваше имя.';
    } else if (nameInput.value.length > 100) {
        message = 'Пожалуйста, укажите более короткое имя.';
    } else {
        return true;
    }
    addErrorMessage(nameInput, message);
    return false;
}

function validatePhone(phoneInput) {
    removeErrorMessage(phoneInput);
    let message = 'Указан некорректный номер телефона.';
    if (phoneInput.value) {
        const phone_num_pattern = /^\+?[0-9]{0,3}[\s-]{0,2}\(?[0-9]{3}\)?[\s-]{0,2}[0-9]{3}[\s-]?[0-9]{2}[\s-]?[0-9]{2}$/;
        if (phoneInput.value.match(phone_num_pattern)) {
            return true;
        }
    } else {
        message = 'Пожалуйста, укажите номер телефона.';
    }

    addErrorMessage(phoneInput, message);
    return false;
}

function validateShippingAddress(addrInput) {
    const devTypeInput = document.getElementById('delivery_type');
    removeErrorMessage(addrInput);
    if (devTypeInput.value === 'delivery' && addrInput.value.length < 7) {
        addErrorMessage(addrInput, 'Пожалуйста, укажите полный адрес доставки.');
        return false;
    }
    return true;
}

function validateOrderForm() {
    let validated = true;
    if (!validateName(document.getElementById('nameInput'))) validated = false;
    if (!validatePhone(document.getElementById('phoneInput'))) validated = false;
    if (!validateShippingAddress(document.getElementById('delAddrInput'))) validated = false;
    return validated;
}
