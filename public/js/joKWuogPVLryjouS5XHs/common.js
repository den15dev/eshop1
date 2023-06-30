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



/* -------------------- Adjust height of all textareas ----------------------- */

let txt_area_arr = document.getElementsByTagName('textarea');

function adjustTextAreas() {
    for (let i = 0; i < txt_area_arr.length; i++) {
        let txtarea = txt_area_arr[i];

        txtarea.style.overflow = 'hidden';
        txtarea.style.height = '0';
        txtarea.style.height = txtarea.scrollHeight + 'px';

        txtarea.addEventListener('keyup', function () {
            this.style.overflow = 'hidden';
            this.style.height = '0';
            this.style.height = this.scrollHeight + 'px';
        }, false);
    }
}

adjustTextAreas();




/* ----------------- Category tree ------------------- */

$('.dd-menu-btn, .sub-menu-btn')
    .on('mouseover', function () {
        $(this).find('.cat_add_btn').show();
    })
    .on('mouseout', function () {
        $(this).find('.cat_add_btn').hide();
    });

$('.cat_add_btn').on('click', function (event) {
    event.preventDefault();
    alert('Hello!');
});




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





/* -------------------- Select brand ----------------------- */

let brandHtml = '<div class="blue_link" data-brandid="1">Asus</div>\n' +
    '<div class="blue_link" data-brandid="2">Intel</div>\n' +
    '<div class="blue_link" data-brandid="3">AMD</div>\n' +
    '<div class="blue_link" data-brandid="4">Noctua</div>\n' +
    '<div class="blue_link" data-brandid="5">DeepCool</div>\n' +
    '<div class="blue_link" data-brandid="6">Logitech</div>\n' +
    '<div class="blue_link" data-brandid="7">Arctic</div>\n' +
    '<div class="blue_link" data-brandid="8">MSI</div>\n' +
    '<div class="blue_link" data-brandid="9">Apple</div>\n' +
    '<div class="blue_link" data-brandid="10">Samsung</div>\n' +
    '<div class="blue_link" data-brandid="11">WD</div>\n' +
    '<div class="blue_link" data-brandid="12">Seagate</div>\n' +
    '<div class="blue_link" data-brandid="13">Crucial</div>\n' +
    '<div class="blue_link" data-brandid="14">Seasonic</div>\n' +
    '<div class="blue_link" data-brandid="15">Super Flower</div>';


function selectBrand() {
    brandIdInput.value = this.getAttribute('data-brandid');
    brandNameCont.innerHTML = this.innerHTML;
    hideConfirmMessage();
}


let bfilterInputTimeOut2;
function filterOnInput2() {
    clearTimeout(bfilterInputTimeOut2);

    let str = this.value;
    if (str.length > 0) {
        let brandListCont = document.getElementById('brandlist_cont');
        let origListArr = Array.from(brandListCont.getElementsByTagName('div'));
        bfilterInputTimeOut2 = setTimeout(function () {

            brandListCont.innerHTML = '';

            [...origListArr].forEach(function(elem) {
                let regex = new RegExp('^' + str, 'i');
                if (elem.innerHTML.match(regex)) {
                    brandListCont.appendChild(elem);
                }
            });

        }, 300);
    } else {
        brandListCont.innerHTML = origListStr;
    }
}


function showBrandWin() {
    let mainCont = document.createElement('div');
    mainCont.setAttribute('id', 'message_cont');

    let messbg = document.createElement('div');
    messbg.className = 'message_bg';
    mainCont.appendChild(messbg);

    let messwin = document.createElement('div');
    messwin.className = 'win_big';


    // Close button
    let closeBtn = document.createElement('div');
    closeBtn.className = 'message_close';
    closeBtn.setAttribute('title', 'Закрыть');
    closeBtn.setAttribute('onclick', 'hideConfirmMessage()');
    let crossIcon = document.createElement('span');
    crossIcon.className = 'bi-x-lg';
    closeBtn.appendChild(crossIcon);
    messwin.appendChild(closeBtn);


    // Input
    let inpCont = document.createElement('div');
    inpCont.className = 'adm_form_cont mb-4';
    let span1 = document.createElement('span');
    span1.className = 'd-block mb-2';
    span1.appendChild(document.createTextNode('Начните вводить название бренда:'));
    inpCont.appendChild(span1);
    let brandNameInp = document.createElement('input');
    brandNameInp.className = 'form-control mb-2';
    brandNameInp.setAttribute('type', 'text');
    brandNameInp.setAttribute('id', 'brandNameInput');
    inpCont.appendChild(brandNameInp);
    let span2 = document.createElement('span');
    span2.className = 'd-block small grey_text fst-italic mb-2';
    span2.appendChild(document.createTextNode('Если нужный бренд отсутствует в списке, сначала создайте новый бренд в разделе '));
    let brandsLink = document.createElement('a');
    brandsLink.setAttribute('href', '');
    brandsLink.appendChild(document.createTextNode('Бренды'));
    span2.appendChild(brandsLink);
    inpCont.appendChild(span2);
    messwin.appendChild(inpCont);

    brandNameInp.oninput = filterOnInput2;


    // Brand list
    let brandListCont1 = document.createElement('div');
    brandListCont1.className = 'brandlist_maxheight';
    let brandListCont2 = document.createElement('div');
    brandListCont2.className = 'adm_brandlist_cont';
    brandListCont2.setAttribute('id', 'brandlist_cont');
    brandListCont1.appendChild(brandListCont2);
    messwin.appendChild(brandListCont1);

    brandListCont2.innerHTML = brandHtml;

    let brandDivArr = brandListCont2.getElementsByTagName('div');
    [...brandDivArr].forEach(function(elem) {
        elem.onclick = selectBrand;
    });


    // Buttons
    let btnCont = document.createElement('div');
    btnCont.className = 'message_btns_cont';

    let cancelBtn = document.createElement('div');
    cancelBtn.className = 'btn2 btn2-secondary message_main_btn';
    cancelBtn.appendChild(document.createTextNode('Закрыть'));
    cancelBtn.setAttribute('onclick', 'hideConfirmMessage()');
    btnCont.appendChild(cancelBtn);

    messwin.appendChild(btnCont);
    mainCont.appendChild(messwin);
    document.body.appendChild(mainCont);
}
