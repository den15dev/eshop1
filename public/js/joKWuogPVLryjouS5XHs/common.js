function getCookieValue(a, b, c) {
    b = '; ' + document.cookie;
    c = b.split('; ' + a + '=');
    return !!(c.length - 1) ? c.pop().split(';').shift() : '';
}



/* ----------- Modal window ------------- */

/**
 * Shows a message window.
 *
 * @param data - {
 *     'type' - one of 'note', or 'confirm';
 *     'icon' - one of 'info', 'question', or 'warning';
 *     'message' - text or html message;
 *     'ok' - a callback for an 'ok' button;
 *     'okText' - text for 'ok' button (default is 'ok');
 *     'cancelText' - text for 'Cancel' button (default is 'Cancel');
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
    const questionIcon = document.getElementById('cm_icon_question');

    textCont.innerHTML = data.message;

    closeBtn.onclick = function () { message.style.display = 'none'; }

    if (data.type === 'confirm') {
        okBtn.onclick = function () {
            message.style.display = 'none';
            data.ok();
        }
        cancelBtn.innerText = 'Отмена';
        if (data.cancelText !== undefined) {
            cancelBtn.innerText = data.cancelText;
        }
        cancelBtn.onclick = function () { message.style.display = 'none'; }

    } else {
        okBtn.onclick = function () { message.style.display = 'none'; }
        cancelBtn.style.display = 'none';
    }

    if (data.icon === 'question') {
        infoIcon.style.display = 'none';
        questionIcon.style.display = 'block';
        warningIcon.style.display = 'none';

    } else if (data.icon === 'warning') {
        infoIcon.style.display = 'none';
        questionIcon.style.display = 'none';
        warningIcon.style.display = 'block';

    } else {
        infoIcon.style.display = 'block';
        questionIcon.style.display = 'none';
        warningIcon.style.display = 'none';
    }

    okBtn.innerText = 'Ok';
    if (data.okText !== undefined) {
        okBtn.innerText = data.okText;
    }

    if (data.type === 'confirm' && data.icon === 'warning') {
        okBtn.classList.remove("btn2-primary");
        okBtn.classList.add("btn2-red");
    } else if (okBtn.classList.contains("btn2-red")) {
        okBtn.classList.remove("btn2-red");
        okBtn.classList.add("btn2-primary");
    }

    message.style.display = 'block';
}



/* -------------------- Adjust height of all textareas ----------------------- */

let txt_area_arr = document.getElementsByTagName('textarea');

function adjustTextAreas() {
    for (let i = 0; i < txt_area_arr.length; i++) {
        let txtarea = txt_area_arr[i];

        txtarea.style.overflow = 'hidden';
        txtarea.style.height = '84px'; // Minimum 3 lines
        txtarea.style.height = txtarea.scrollHeight + 'px';

        txtarea.addEventListener('keyup', function () {
            this.style.overflow = 'hidden';
            this.style.height = '84px'; // Minimum 3 lines
            this.style.height = this.scrollHeight + 'px';
        }, false);
    }
}

adjustTextAreas();





/* -------------------- Reduce pagination font size for mobiles ----------------------- */

let xsMedia = window.matchMedia('(min-width: 425px)');

function fixPaginationSize() {
    const paginationCont = document.querySelector('.pagination');
    if (paginationCont) {
        if (xsMedia.matches) {
            paginationCont.className = 'pagination';
        } else {
            paginationCont.className = 'pagination pagination-sm';
        }
    }
}
fixPaginationSize();





/* -------------------- Confirm deleting ----------------------- */

function confirmDeleting(form, message) {
    showMessage({
        'type': 'confirm',
        'icon': 'warning',
        'message': 'Вы действительно хотите ' + message,
        'ok': function () {
            form.submit();
        },
        'okText': 'Удалить',
    });

    return false;
}
