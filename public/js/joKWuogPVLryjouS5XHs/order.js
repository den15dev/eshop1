/* -------------------- Confirm changing status ----------------------- */

function confirmChangingStatus(form, message, okText, cancelText = 'Отмена') {
    showMessage({
        'type': 'confirm',
        'icon': 'question',
        'message': message,
        'ok': function () {
            form.submit();
        },
        'okText': okText,
        'cancelText': cancelText,
    });

    return false;
}
