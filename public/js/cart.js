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
