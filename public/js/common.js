function getCookieValue(a, b, c) {
    b = '; ' + document.cookie;
    c = b.split('; ' + a + '=');
    return !!(c.length - 1) ? c.pop().split(';').shift() : '';
}


/* ----------- Catalog Dropdown Menu 2 ------------- */

$('#accordion_dropdown').click(function(e){
    e.stopPropagation();
});

$('.sub-menu ul').hide();
$('.sub-menu-btn').click(function () {
    $(this).parent('.sub-menu').children('ul').slideToggle(100);
    $(this).toggleClass('subm-btn-active');
    $(this).find('.right').toggleClass('bi-chevron-right bi-chevron-down');
});



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
