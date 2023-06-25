const searchInput = document.getElementById('search_input');
const indexTable = document.getElementById('index_table');
const tableName = indexTable.getAttribute('data-id');
const tableCont = document.getElementById('index_table_cont');
const clearBtn = document.getElementById('clear_btn');

const chbActive = document.getElementById('chb_active');
const chbInactive = document.getElementById('chb_inactive');

let searchInputTimeOut;

function getSearchResults(query_str, page = null) {
    let data = {
        table: tableName,
        query: query_str
    };
    if (page) {
        data.page = page;
    }

    let is_active = getIsActiveValue();
    if (is_active !== 2) {
        data.is_active = is_active;
    }

    let order_by = getCurrentOrder();
    if (order_by) {
        data.order_by = order_by[0];
        data.order_dir = order_by[1];
    }

    $.ajax({
        url: '/admin/search',
        method: 'get',
        dataType: 'text',
        data: data,
        success: function(data){
            tableCont.innerHTML = data;
            if (query_str && query_str.length > 1) clearBtn.style.display = 'block';
            fixPaginationLinks();
            fixPaginationSize();
        },
        error: function (jqXHR) {
            showMessage({
                'type': 'warning',
                'message': 'Ошибка сервера:<br>' + jqXHR.status + ' (' + jqXHR.statusText + ')',
            });
        }
    });
}


function showSearchResOnInput() {
    clearTimeout(searchInputTimeOut);

    let str = searchInput.value;
    if (str.length > 1) {
        searchInputTimeOut = setTimeout(function () {
            getSearchResults(str);
        }, 300);
    } else {
        clearBtn.style.display = 'none';
    }
}

function clearSearchRes() {
    searchInput.value = '';
    getSearchResults('');
    clearBtn.style.display = 'none';
    searchInput.focus();
}

function fixPaginationLinks() {
    let paginationCont = document.getElementById('pagination');

    if (paginationCont) {
        let link_arr = Array.from(paginationCont.getElementsByTagName('a'));

        [...link_arr].forEach(function (linkElem) {
            let page_url = linkElem.href;
            let searchParams = new URLSearchParams(page_url);
            let query = searchParams.get("query");
            let page = searchParams.get("page");

            linkElem.onclick = function (event) {
                event.preventDefault();
                getSearchResults(query, page);
            };
        });
    }
}

function getIsActiveValue() {
    let is_active = 2;
    if (chbActive && chbInactive) {
        if (chbActive.checked && !chbInactive.checked) { is_active = 1; }
        else if (!chbActive.checked && chbInactive.checked) { is_active = 0; }
    }
    return is_active;
}


searchInput.oninput = showSearchResOnInput;
clearBtn.onclick = clearSearchRes;
fixPaginationLinks();

if (chbActive && chbInactive) {
    chbActive.onclick = function () {
        getSearchResults(searchInput.value);
    };
    chbInactive.onclick = function () {
        getSearchResults(searchInput.value);
    };
}




/* ------------- Handle sortable columns --------------- */

function changeOrder(column_id) {
    const table_head_arr = Array.from(indexTable.getElementsByTagName('thead')[0].getElementsByTagName('td'));

    [...table_head_arr].forEach(function (headTd) {

        const head_btn_arr = Array.from(headTd.getElementsByTagName('div'));

        if (head_btn_arr.length > 0) {
            const head_btn = head_btn_arr[0];
            const col_id = head_btn.getAttribute('data-id');
            const orderby = head_btn.getAttribute('data-orderby');
            const icon_cont = head_btn.getElementsByTagName('span')[0];

            if (col_id === column_id) {
                if (orderby === 'asc') {
                    icon_cont.className = 'bi-caret-up-fill small';
                    head_btn.setAttribute('data-orderby', 'desc');
                } else {
                    icon_cont.className = 'bi-caret-down-fill small';
                    icon_cont.style.display = 'inline';
                    head_btn.setAttribute('data-orderby', 'asc');
                }
            } else {
                icon_cont.className = '';
                icon_cont.style.display = 'none';
                head_btn.setAttribute('data-orderby', '');
            }
        }
    });

    getSearchResults(searchInput.value);
}


function getCurrentOrder() {
    let order = null;
    const table_head_arr = Array.from(indexTable.getElementsByTagName('thead')[0].getElementsByTagName('td'));

    [...table_head_arr].forEach(function (headTd) {
        const head_btn_arr = Array.from(headTd.getElementsByTagName('div'));

        if (head_btn_arr.length > 0) {
            const head_btn = head_btn_arr[0];
            const col_id = head_btn.getAttribute('data-id');
            const orderby = head_btn.getAttribute('data-orderby');
            if (orderby) {
                order = [col_id, orderby];
            }
        }
    });

    return order;
}




/* ------------- Set number of table rows per page --------------- */

function changePerPageNum(value) {
    document.cookie = 'tbl_ppage=' + encodeURIComponent(value) + '; path=/;  max-age=157680000';
    getSearchResults(searchInput.value);
}
