
/* ------------------ SEARCH -------------------- */

// Look for this html in brand.html
// Delete this
let searchStr = '<div class="search_results_cont_inner scrollbar-thin">\n' +
'    <div class="search_result_main_title">\n' +
'        <span class="fw-semibold">Бренды</span>\n' +
'        <span class="grey_text">(1)</span>\n' +
'    </div>\n' +
'\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        Asus\n' +
'    </a>\n' +
'\n' +
'    <div class="my-1"></div>\n' +
'\n' +
'    <div class="search_result_main_title">\n' +
'        <a href="" class="black_link">\n' +
'            <span class="fw-semibold">Товары</span>\n' +
'            <span class="grey_text">(385)</span>\n' +
'        </a>\n' +
'    </div>\n' +
'\n' +
'    <a href="product/2" class="search_result_block black_link">\n' +
'        <img src="resources/catalog/1/1_001_thumbnail.jpg">\n' +
'        <div class="search_result_block_title">\n' +
'            Процессор AMD Ryzen 9 5900X BOX\n' +
'        </div>\n' +
'        <div class="fw-bold">\n' +
'            34 500 ₽\n' +
'        </div>\n' +
'    </a>\n' +
'\n' +
'    <a href="product/3" class="search_result_block black_link">\n' +
'        <img src="resources/catalog/1/1_005_thumbnail.jpg">\n' +
'        <div class="search_result_block_title">\n' +
'            Видеокарта MSI GeForce RTX 3070 GAMING Z TRIO (LHR)\n' +
'        </div>\n' +
'        <div class="fw-bold">\n' +
'            34 500 ₽\n' +
'        </div>\n' +
'    </a>\n' +
'\n' +
'    <a href="" class="search_result_block black_link">\n' +
'        <img src="resources/catalog/1/1_001_thumbnail.jpg">\n' +
'        <div class="search_result_block_title">\n' +
'            Процессор AMD Ryzen 9 5900X BOX Процессор AMD Ryzen 9 5900X BOX\n' +
'        </div>\n' +
'        <div class="fw-bold">\n' +
'            34 500 ₽\n' +
'        </div>\n' +
'    </a>\n' +
'\n' +
'    <a href="" class="search_result_block black_link">\n' +
'        <img src="resources/catalog/1/1_001_thumbnail.jpg">\n' +
'        <div class="search_result_block_title">\n' +
'            Процессор AMD Ryzen 9 5900X BOX\n' +
'        </div>\n' +
'        <div class="fw-bold">\n' +
'            34 500 ₽\n' +
'        </div>\n' +
'    </a>\n' +
'\n' +
'    <a href="" class="search_result_block black_link">\n' +
'        <img src="resources/catalog/1/1_005_thumbnail.jpg">\n' +
'        <div class="search_result_block_title">\n' +
'            Видеокарта MSI GeForce RTX 3070 GAMING Z TRIO (LHR)\n' +
'        </div>\n' +
'        <div class="fw-bold">\n' +
'            34 500 ₽\n' +
'        </div>\n' +
'    </a>\n' +
'\n' +
'    <a href="" class="search_result_block black_link">\n' +
'        <img src="resources/catalog/1/1_001_thumbnail.jpg">\n' +
'        <div class="search_result_block_title">\n' +
'            Процессор AMD Ryzen 9 5900X BOX Процессор AMD Ryzen 9 5900X BOX\n' +
'        </div>\n' +
'        <div class="fw-bold">\n' +
'            34 500 ₽\n' +
'        </div>\n' +
'    </a>\n' +
'</div>';



// Look for this html in admin_users.html
// Delete this
let searchUserStr = '<div class="search_results_cont_inner scrollbar-thin">\n' +
'    <div class="search_result_resnum">\n' +
'        <span class="grey_text small">Найдено: 325,</span>\n' +
'        <a href="orders/results" class="blue_link small">показать все</a>\n' +
'    </div>\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        Александр, <span class="grey_text">dendangler@gmail.com</span>, id: 3452\n' +
'    </a>\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        Паша, <span class="grey_text">medioniz@yandex.com</span>, id: 34\n' +
'    </a>\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        Николай Иванович, <span class="grey_text">oksaletta@hotmail.com</span>, id: 345\n' +
'    </a>\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        Batman1, <span class="grey_text">batman2023@gmail.com</span>, id: 145\n' +
'    </a>\n' +
'</div>';



// Look for this html in admin_orders.html
// Delete this
let searchOrderStr = '<div class="search_results_cont_inner scrollbar-thin">\n' +
'    <div class="search_result_resnum">\n' +
'        <span class="grey_text small">Найдено: 325,</span>\n' +
'        <a href="orders/results" class="blue_link small">показать все</a>\n' +
'    </div>\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        345, <span class="fw-semibold text-color-red">новый</span>, <span class="grey_text">28645 руб</span>\n' +
'    </a>\n' +
'    <a href="" class="search_result_brand_block black_link">\n' +
'        1282, <span class="fw-semibold text-color-green">в работе</span>, <span class="grey_text">834 руб</span>\n' +
'    </a>\n' +
'    <a href="orders/392" class="search_result_brand_block black_link">\n' +
'        392, <span class="grey_text">завершён</span>, <span class="grey_text">12450 руб</span>\n' +
'    </a>\n' +
'    <a href="orders/408" class="search_result_brand_block black_link">\n' +
'        408, <span class="grey_text">завершён</span>, <span class="grey_text">4499 руб</span>\n' +
'    </a>\n' +
'</div>';




let searchResCont = document.getElementById('search_result_cont');
let searchInput = document.getElementById('search_input');
let searchInputTimeOut;

function showSearchResOnInput() {
    clearTimeout(searchInputTimeOut);

    let str = searchInput.value;
    if (str.length > 1) {
        searchInputTimeOut = setTimeout(function () {
            searchResCont.style.display = 'block';
            getSearchResults();
        }, 300);
    } else {
        searchResCont.innerHTML = '';
        searchResCont.style.display = 'none';
    }
}

/*function showSearchResOnFocus() {
    let str = searchInput.value;
    if (str.length > 1) {
        searchResCont.style.display = 'block';
    }
}*/

function hideSearchResOnBlur() {
    searchResCont.style.display = 'none';
}

function getSearchResults() {
    if (typeof srch_mode === 'undefined' && typeof srch_filter === 'undefined') {
        searchResCont.innerHTML = searchStr;
    } else if (srch_mode === 'users') {
        searchResCont.innerHTML = searchUserStr;
        console.log(srch_filter);
    } else if (srch_mode === 'orders') {
        searchResCont.innerHTML = searchOrderStr;
        console.log(srch_filter);
    }
}

function keepSearchResOnMouseOver() {
    searchInput.onblur = null;
}

function keepSearchResOnMouseOut() {
    searchInput.onblur = hideSearchResOnBlur;
}

searchInput.oninput = showSearchResOnInput;
// searchInput.onfocus = showSearchResOnFocus;
searchInput.onfocus = showSearchResOnInput;
searchInput.onblur = hideSearchResOnBlur;
searchResCont.onmouseover = keepSearchResOnMouseOver;
searchResCont.onmouseout = keepSearchResOnMouseOut;