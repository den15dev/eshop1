
/* -------------------- Adjust height of all textareas ----------------------- */

let txt_area_arr = document.getElementsByTagName('textarea');

for (let i=0; i<txt_area_arr.length; i++) {
    let txtarea = txt_area_arr[i];

    txtarea.style.overflow = 'hidden';
    txtarea.style.height = '0';
    txtarea.style.height = txtarea.scrollHeight + 'px';

    txtarea.addEventListener('keyup', function() {
        this.style.overflow = 'hidden';
        this.style.height = '0';
        this.style.height = this.scrollHeight + 'px';
    }, false);
}





/* -------------------- Edit item images ----------------------- */


/*
function addImg() {
    let loaderDiv = document.createElement('div');
    loaderDiv.className = 'adm_img_loader';
    img_cont.appendChild(loaderDiv);

    setTimeout(function() {
        img_cont.removeChild(loaderDiv);

        let newImgBlock = img_cont.children[0].cloneNode(true);
        newImgBlock.getElementsByTagName('img')[0].src = 'resources/catalog/1/1_004_thumbnail.jpg';
        newImgBlock.getElementsByTagName('img')[0].title = '1_004_thumbnail.jpg';
        newImgBlock.style.display = 'flex';
        img_cont.appendChild(newImgBlock);

        rebuildButtons();
    }, 1000);
}
*/


function moveUp(btnElem) {
    let curBlock = btnElem.parentNode.parentNode;
    let prevBlock = curBlock.previousElementSibling;

    img_cont.insertBefore(curBlock, prevBlock);
    rebuildButtons();
}


function moveDown(btnElem) {
    let curBlock = btnElem.parentNode.parentNode;
    let nextBlock = curBlock.nextElementSibling;

    img_cont.insertBefore(nextBlock, curBlock);
    rebuildButtons();
}


function moveTop(btnElem) {
    let curBlock = btnElem.parentNode.parentNode;
    let firstBlock = img_cont.getElementsByClassName('adm_img_block')[0];

    img_cont.insertBefore(curBlock, firstBlock);
    rebuildButtons();
}


function moveBottom(btnElem) {
    let curBlock = btnElem.parentNode.parentNode;
    let blockArr = img_cont.getElementsByClassName('adm_img_block');
    let blockNum = blockArr.length;
    let lastBlock = blockArr[blockNum-1];

    lastBlock.after(curBlock);
    rebuildButtons();
}


function confirmDelImg(btnElem) {
    let curBlock = btnElem.parentNode.parentNode;
    let curImg = curBlock.getElementsByTagName('img')[0];
    let blockId = curImg.getAttribute('data-id');
    let blockTitle = curImg.title;
    showConfirmMessage('Вы действительно хотите удалить "' + blockTitle + '"? Эту операцию нельзя будет отменить.', 'warning', 'ajaxDeleteImg(' + "'" + blockId + "'" + ')');
}


/*
function deleteImg(imgInd) {
    hideConfirmMessage();
    let blockArr = img_cont.getElementsByClassName('adm_img_block');
    let blockNum = blockArr.length;
    blockArr[imgInd].remove();
    rebuildButtons();
}
*/


function ajaxDeleteImg(blockId) {
    hideConfirmMessage();
    let imgContId = img_cont.id;
    console.log('Deleting in ' + imgContId + ":\n" + blockId);
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

        upBtn.setAttribute('onclick', 'moveUp(this)');
        downBtn.setAttribute('onclick', 'moveDown(this)');
        topBtn.setAttribute('onclick', 'moveTop(this)');
        bottomBtn.setAttribute('onclick', 'moveBottom(this)');

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

        // Get block id
        let blockId = blockArr[i].getElementsByTagName('img')[0].getAttribute('data-id');
        imgOrderArr.push([(i+1), blockId]);
    }

    ajaxUpdateOrder(JSON.stringify(imgOrderArr));
}



function ajaxUpdateOrder(orderData) {
    let imgContId = img_cont.id;
    console.log('Updating order for ' + imgContId + "\n" + orderData);
}



function showConfirmMessage(text, icon, onclickAction) {
    let mainCont = document.createElement('div');
    mainCont.setAttribute('id', 'message_cont');

    let messbg = document.createElement('div');
    messbg.className = 'message_bg';
    mainCont.appendChild(messbg);

    let messwin = document.createElement('div');
    messwin.className = 'message_win';

    // Icon image
    let iconcont = document.createElement('div');
    let iconspan = document.createElement('span');
    if (icon === 'info') {
        iconcont.className = 'message_icon message_icon_info';
        iconspan.className = 'bi-info-circle';
    } else if (icon === 'warning') {
        iconcont.className = 'message_icon message_icon_warning';
        iconspan.className = 'bi-exclamation-triangle';
    }
    iconcont.appendChild(iconspan);
    messwin.appendChild(iconcont);

    // Text
    let textP = document.createElement('p');
    textP.appendChild(document.createTextNode(text));
    messwin.appendChild(textP);

    // Buttons
    let btnCont = document.createElement('div');
    btnCont.className = 'message_btns_cont';
    let okBtn = document.createElement('div');
    okBtn.className = 'btn2 btn2-primary message_main_btn';
    okBtn.appendChild(document.createTextNode('OK'));
    okBtn.setAttribute('onclick', onclickAction);
    btnCont.appendChild(okBtn);

    let cancelBtn = document.createElement('div');
    cancelBtn.className = 'btn2 btn2-secondary message_main_btn';
    cancelBtn.appendChild(document.createTextNode('Отмена'));
    cancelBtn.setAttribute('onclick', 'hideConfirmMessage()');
    btnCont.appendChild(cancelBtn);

    messwin.appendChild(btnCont);
    mainCont.appendChild(messwin);
    document.body.appendChild(mainCont);
}

function hideConfirmMessage() {
    document.getElementById('message_cont').remove();
}




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

