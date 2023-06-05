function getCookieValue(a, b, c) {
    b = '; ' + document.cookie;
    c = b.split('; ' + a + '=');
    return !!(c.length - 1) ? c.pop().split(';').shift() : '';
}

/**
 * Shows a message window.
 *
 * @param data - {
 *     'type' - one of 'info', 'confirm', or 'warning';
 *     'message' - text or html message;
 *     'ok' - a callback for an 'ok' button;
 *     'okText' - text for 'ok' button (default is 'ok');
 * }
 */
function showMessage(data) {
    const message = document.getElementById('client_message');
    const textCont = document.getElementById('cm_content');
    const okBtn = document.getElementById('cm_ok_btn');
    const closeBtn = document.getElementById('cm_close_btn');
    const cancelBtn = document.getElementById('cm_cancel_btn');

    const infoIcon = document.getElementById('cm_icon_info');
    const warningIcon = document.getElementById('cm_icon_warning');
    const confirmIcon = document.getElementById('cm_icon_confirm');

    textCont.innerHTML = data.message;

    closeBtn.onclick = function () { message.style.display = 'none'; }

    if (data.type === 'info') {

        okBtn.onclick = function () { message.style.display = 'none'; }
        cancelBtn.style.display = 'none';
        infoIcon.style.display = 'block';
        confirmIcon.style.display = 'none';
        warningIcon.style.display = 'none';

    } else if (data.type === 'confirm') {

        okBtn.onclick = function () {
            message.style.display = 'none';
            data.ok();
        }
        cancelBtn.onclick = function () { message.style.display = 'none'; }
        infoIcon.style.display = 'none';
        confirmIcon.style.display = 'block';
        warningIcon.style.display = 'none';

    } else if (data.type === 'warning') {

        okBtn.onclick = function () { message.style.display = 'none'; }
        cancelBtn.style.display = 'none';
        infoIcon.style.display = 'none';
        confirmIcon.style.display = 'none';
        warningIcon.style.display = 'block';

    }

    okBtn.innerText = 'Ok';
    if (data.okText !== undefined) {
        okBtn.innerText = data.okText;
    }

    message.style.display = 'block';
}



/* ----------- Listen for Comparison event if a product from another category added ------------- */

Livewire.on('comparisonCatChangeRequest', productData => {
    showMessage({
        'type': 'confirm',
        'message': 'В списке сравнения находятся товары другой категории. Создать список заново?',
        'ok': function () {
            document.cookie = 'compare=' + encodeURIComponent(JSON.stringify([productData[1], [productData[0]]])) + '; path=/;  max-age=2592000';
            window.location.reload();
        },
        'okText': 'Создать',
    });
});

Livewire.on('reloadPageByJS', () => {
    window.location.reload();
});
