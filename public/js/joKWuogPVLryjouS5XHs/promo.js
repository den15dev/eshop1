const productTableCont = document.getElementById('products_table_cont');

function removeFromPromo(promo_id, product_id, csrf_token) {
    showMessage({
        'type': 'confirm',
        'icon': 'question',
        'message': 'Изъять товар ' + product_id + ' из акции?',
        'ok': function () {
            $.ajax({
                url: '/admin/ajax',
                method: 'post',
                dataType: 'text',
                data: {
                    _token: csrf_token,
                    service: 'promo',
                    action: 'remove_product_from_promo',
                    promo_id: promo_id,
                    product_id: product_id
                },
                success: function(data){
                    productTableCont.innerHTML = data;
                },
                error: function (jqXHR) {
                    showMessage({
                        'type': 'note',
                        'icon': 'warning',
                        'message': 'Ошибка:<br>' + jqXHR.status + ' (' + jqXHR.statusText + ')',
                    });
                }
            });
        },
        'okText': 'Изъять',
    });
}
