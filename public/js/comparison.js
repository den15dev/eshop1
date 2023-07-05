function removeFromComparison(product_id) {
    $.ajax({
        url: '/comparison/remove',
        method: 'post',
        dataType: 'text',
        data: {product_id: product_id},
        success: function(){
            location.replace(location.href);
        },
        error: function () {
            showMessage({
                'type': 'note',
                'icon': 'warning',
                'message': '<b>Ошибка!</b><br>Не удалось удалить товар из списка.<br>Пожалуйста, попробуйте ещё раз позднее.',
            });
        }
    });
}


function clearComparisonList() {
    showMessage({
        'type': 'confirm',
        'icon': 'question',
        'message': 'Вы действительно хотите очистить список сравнения?',
        'ok': function () {
            $.ajax({
                url: '/comparison/clear',
                method: 'post',
                dataType: 'text',
                data: {action: 'clear'},
                success: function(){
                    location.replace(location.href);
                },
                error: function () {
                    showMessage({
                        'type': 'note',
                        'icon': 'warning',
                        'message': '<b>Ошибка!</b><br>Не удалось очистить список.<br>Пожалуйста, попробуйте ещё раз позднее.',
                    });
                }
            });
        },
        'okText': 'Очистить',
    });
}
