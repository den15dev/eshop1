/* global bootstrap: false */
(() => {
    'use strict'
    const tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.forEach(tooltipTriggerEl => {
        new bootstrap.Tooltip(tooltipTriggerEl)
    })
})()


let filt_apply_btn = document.getElementById('sidebar_submit_btn');

function goToSidebarURL() {
    let filt_apply_url = location.href;
    let sidebar_cont = document.getElementById('sidebar');

    let filt_cont_arr = Array.from(sidebar_cont.getElementsByClassName('collapse show'));
    let param_arr = [];

    [...filt_cont_arr].forEach(function(elem) {
        let filterId = elem.id;
        if (filterId === 'price_range') {
            let pricemin = document.getElementById('price_min').value;
            let pricemax = document.getElementById('price_max').value;
            if (pricemin !== '') {
                param_arr.push('pricemin=' + pricemin);
            }
            if (pricemax !== '') {
                param_arr.push('pricemax=' + pricemax);
            }
        } else {
            let list_arr = Array.from(elem.getElementsByTagName('li'));
            let val_arr = [];

            [...list_arr].forEach(function(liElem) {
                if (liElem.getElementsByTagName('input')[0].checked) {
                    let selValue = liElem.getElementsByTagName('label')[0].childNodes[0].nodeValue.trim();
                    val_arr.push(encodeURIComponent(selValue));
                }
            });

            if (val_arr.length > 1) {
                for (let i=0; i<val_arr.length; i++) {
                    param_arr.push(filterId + '[]=' + val_arr[i]);
                }
            } else if (val_arr.length === 1) {
                param_arr.push(filterId + '=' + val_arr[0]);
            }
        }
    });

    if (param_arr.length > 0) {
        let query_str = param_arr.join('&');
        filt_apply_url += '?' + query_str;
    }

    location.href = filt_apply_url;
}

filt_apply_btn.onclick = goToSidebarURL;