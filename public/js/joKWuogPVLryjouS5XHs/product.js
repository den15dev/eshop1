/* ----------------- Is_active switch ------------------ */

$('#is_active_ui_switch').on('change', function() {
    const is_active_input = $('#is_active_input');
    $(this).is(':checked') ? is_active_input.val(1) : is_active_input.val(0);
});


/* ----------------- Final price calculation ------------------ */

const price_input = document.getElementById('price_input');
const discount_perc_input = document.getElementById('discount_prc_input');
const final_price_input = document.getElementById('final_price_input');
const final_price_pretty_input = document.getElementById('final_price_pretty_input');

function calculatePrice() {
    let final_price = '-';
    let final_price_pretty = '-';

    if (price_input.value !== '') {
        let price = parseFloat(price_input.value).toFixed(2);
        let discount_prc = parseInt(discount_perc_input.value, 10) || 0;

        if (price > 0) {
            final_price = (price * (100 - discount_prc)/100).toFixed(2);

            final_price_pretty = final_price;
            if (final_price_pretty.match(/\.0+$/)) {
                final_price_pretty = final_price_pretty.split('.')[0];
            }
            final_price_pretty = final_price_pretty.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1 ') + ' ₽';
        }
    }

    final_price_input.value = final_price;
    final_price_pretty_input.value = final_price_pretty;
}

discount_perc_input.oninput = calculatePrice;
price_input.oninput = calculatePrice;





/* -------------------- Images ----------------------- */

const img_cont = document.getElementById('item_edit_img_cont');
const imgSubmitBtn = document.getElementById('img_submit_btn');
const imgInactiveBtn = document.getElementById('img_inactive_btn');
const selectImgInput = document.getElementById('img_select_input');
const imageForm = document.getElementById('image_form');
const loaderCont = document.getElementById('loader_cont');

function makeBtnActive() {
    imgInactiveBtn.style.display = 'none';
    imgSubmitBtn.style.display = 'block';
}


function moveImage(btnElem, destination) {
    let curBlock = btnElem.parentNode.parentNode;

    if (destination === 'up') {
        let prevBlock = curBlock.previousElementSibling;
        img_cont.insertBefore(curBlock, prevBlock);

    } else if (destination === 'down') {
        let nextBlock = curBlock.nextElementSibling;
        img_cont.insertBefore(nextBlock, curBlock);

    } else if (destination === 'top') {
        let firstBlock = img_cont.getElementsByClassName('adm_img_block')[0];
        img_cont.insertBefore(curBlock, firstBlock);

    } else if (destination === 'bottom') {
        let blockArr = img_cont.getElementsByClassName('adm_img_block');
        let blockNum = blockArr.length;
        let lastBlock = blockArr[blockNum-1];
        lastBlock.after(curBlock);
    }

    rebuildButtons();
    makeBtnActive();
}


function deleteImage(btnElem) {
    let curBlock = btnElem.parentNode.parentNode;
    curBlock.remove();
    rebuildButtons();
    makeBtnActive();
}


function rebuildButtons() {
    let blockArr = img_cont.getElementsByClassName('adm_img_block');
    let blockNum = blockArr.length;
    let imgOrderArr = [];

    for (let i=0; i<blockNum; i++) {
        let btnCont = blockArr[i].getElementsByClassName('adm_img_b_btns')[0];
        let upBtn = btnCont.getElementsByTagName('div')[0];
        let downBtn = btnCont.getElementsByTagName('div')[1];
        let topBtn = btnCont.getElementsByTagName('div')[2];
        let bottomBtn = btnCont.getElementsByTagName('div')[3];

        upBtn.className = 'adm_img_ctrl-btn';
        downBtn.className = 'adm_img_ctrl-btn';
        topBtn.className = 'adm_img_ctrl-btn';
        bottomBtn.className = 'adm_img_ctrl-btn';

        upBtn.setAttribute('title', 'Поднять выше');
        downBtn.setAttribute('title', 'Опустить ниже');
        topBtn.setAttribute('title', 'Поднять наверх');
        bottomBtn.setAttribute('title', 'Опустить вниз');

        upBtn.setAttribute('onclick', 'moveImage(this, \'up\')');
        downBtn.setAttribute('onclick', 'moveImage(this, \'down\')');
        topBtn.setAttribute('onclick', 'moveImage(this, \'top\')');
        bottomBtn.setAttribute('onclick', 'moveImage(this, \'bottom\')');

        // Insert number
        blockArr[i].getElementsByClassName('adm_img_b_num')[0].innerHTML = (i+1).toString();

        if (i === 0) {
            upBtn.className = 'adm_img_ctrl-btn_disabled';
            upBtn.removeAttribute('title');
            upBtn.removeAttribute('onclick');
            topBtn.className = 'adm_img_ctrl-btn_disabled';
            topBtn.removeAttribute('title');
            topBtn.removeAttribute('onclick');
        }

        if (i === blockNum-1) {
            downBtn.className = 'adm_img_ctrl-btn_disabled';
            downBtn.removeAttribute('title');
            downBtn.removeAttribute('onclick');
            bottomBtn.className = 'adm_img_ctrl-btn_disabled';
            bottomBtn.removeAttribute('title');
            bottomBtn.removeAttribute('onclick');
        }

        let file_name = blockArr[i].getElementsByTagName('img')[0].getAttribute('data-id');
        imgOrderArr.push(file_name);
    }

    const imagesInput = document.getElementById('images_input');
    imagesInput.value = imgOrderArr.length ? JSON.stringify(imgOrderArr) : '';
}

if (selectImgInput) selectImgInput.onchange = makeBtnActive;

if (imageForm) {
    imageForm.onsubmit = function () {
        loaderCont.style.display = 'block';
    }
}

/* -------------------- Add image input ----------------------- */

function addImageInput(btn) {
    const lastDiv = btn.previousElementSibling;
    const newDiv = lastDiv.cloneNode(true);
    lastDiv.after(newDiv);
}





/* -------------------- Specifications ----------------------- */

const categorySelect = document.getElementById('category_id_select');
const specsTextArea = document.getElementById('specs_textarea');
const categoryEditLink = document.getElementById('category_edit_link');
const currentCategoryId = categorySelect.value;
let currentSpecs = specsTextArea.value;

function updateSpecs() {
    const category_id = categorySelect.value;

    let data = {
        service: 'product',
        action: 'get_product_spec_list',
        category_id: category_id
    };

    if (product_id) data.product_id = product_id;

    if (category_id) {
        if (category_id === currentCategoryId) {
            // Return saved specs
            specsTextArea.value = currentSpecs;
            adjustTextAreas();
        } else {
            $.ajax({
                url: '/admin/ajax',
                method: 'get',
                dataType: 'text',
                data: data,
                success: function (data) {
                    specsTextArea.value = data;
                    adjustTextAreas();
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

        categoryEditLink.href = '/admin/categories/' + category_id + '/edit';
    }
}

categorySelect.onchange = updateSpecs;
specsTextArea.onblur = function () {
    currentSpecs = specsTextArea.value;
}
