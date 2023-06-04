const searchResCont = document.getElementById('search_result_cont');
const searchInput = document.getElementById('search_input');
const clearBtn = document.getElementById('clear_btn');
let searchInputTimeOut;

function showSearchResOnInput() {
    clearTimeout(searchInputTimeOut);

    let str = searchInput.value;
    if (str.length > 1) {
        searchInputTimeOut = setTimeout(function () {
            searchResCont.style.display = 'block';
            getSearchResults(str);
        }, 200);
    } else {
        searchResCont.innerHTML = '';
        searchResCont.style.display = 'none';
        clearBtn.style.display = 'none';
    }
}

function hideSearchResOnBlur() {
    searchResCont.style.display = 'none';
}

function getSearchResults(query_str) {
    $.ajax({
        url: '/search/autocomplete',
        method: 'get',
        dataType: 'text',
        data: {query: query_str},
        success: function(data){
            searchResCont.innerHTML = data;
            clearBtn.style.display = 'block';
        }
    });
}

function keepSearchResOnMouseOver() {
    searchInput.onblur = null;
}

function keepSearchResOnMouseOut() {
    searchInput.onblur = hideSearchResOnBlur;
}

function clearSearchRes() {
    searchInput.value = '';
    searchResCont.innerHTML = '';
    searchResCont.style.display = 'none';
    clearBtn.style.display = 'none';
    searchInput.focus();
}

searchInput.oninput = showSearchResOnInput;
searchInput.onfocus = showSearchResOnInput;
searchInput.onblur = hideSearchResOnBlur;
searchResCont.onmouseover = keepSearchResOnMouseOver;
searchResCont.onmouseout = keepSearchResOnMouseOut;
clearBtn.onclick = clearSearchRes;
