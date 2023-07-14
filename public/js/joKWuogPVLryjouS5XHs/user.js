/* -------------------- Confirm admin promotion ----------------------- */

function confirmAdminPromotion(form, message) {
    showMessage({
        'type': 'confirm',
        'icon': 'question',
        'message': 'Вы действительно хотите ' + message,
        'ok': function () {
            form.submit();
        },
        'okText': 'Да',
    });

    return false;
}



/* ----------------- Is_active switch ------------------ */

const isActiveSwitch = document.getElementById('is_active_ui_switch');

if (isActiveSwitch) {
    isActiveSwitch.onchange = function (event) {
        const is_active = event.target.checked ? 1 : 0;
        const status = event.target.checked ? 'активен' : 'неактивен';

        $.ajax({
            url: '/admin/ajax',
            method: 'post',
            dataType: 'text',
            data: {
                _token: csrf_token,
                service: 'user',
                action: 'toggle_is_active',
                user_id: user_id,
                is_active: is_active
            },
            success: function () {
                showMessage({
                    'type': 'note',
                    'icon': 'info',
                    'message': 'Пользователь ' + user_id + ' теперь ' + status + '.',
                });
            },
            error: function (jqXHR) {
                showMessage({
                    'type': 'note',
                    'icon': 'warning',
                    'message': 'Ошибка:<br>' + jqXHR.status + ' (' + jqXHR.statusText + ')',
                });
            }
        });
    }
}
