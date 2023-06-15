/* --------------- Tabs ------------------ */

let tabCont = document.getElementById('shops_tab_cont');
let tabBtnArr = Array.from(tabCont.getElementsByClassName('nav-link'));

[...tabBtnArr].forEach(function(tabBtn) {
    tabBtn.onclick = function() {
        if (tabBtn.className !== 'nav-link active') {
            let btnId = tabBtn.getAttribute('data-pageid');
            let btnPageCont = document.getElementById(btnId + '_page');

            [...tabBtnArr].forEach(function(prevActiveBtn) {
                if (prevActiveBtn.className === 'nav-link active') {
                    prevActiveBtn.className = 'nav-link blue_link';
                    let prevActiveBtnId = prevActiveBtn.getAttribute('data-pageid');
                    let prevActivePageCont = document.getElementById(prevActiveBtnId + '_page');
                    prevActivePageCont.style.display = 'none';
                }
            });

            tabBtn.className = 'nav-link active';
            btnPageCont.style.display = 'block';
        }
    };
});


function showInactiveTabs(state) {
    [...tabBtnArr].forEach(function(tabBtn) {
        if (tabBtn.className !== 'nav-link active') {
            tabBtn.className = 'nav-link blue_link';
            let tabId = tabBtn.getAttribute('data-pageid');
            let tabCont = document.getElementById(tabId + '_page');
            tabCont.style.display = state ? 'block' : 'none';
        }
    });
}

function widthChangeCallback(mediaQuery) {
    if(mediaQuery.matches) {
        showInactiveTabs(true);
        mapZoom = 11;
    } else {
        showInactiveTabs(false);
        mapZoom = 10;
    }
}

let mapZoom = 11;
let lgMedia = window.matchMedia('(min-width: 992px)');
widthChangeCallback(lgMedia);
lgMedia.addEventListener('change', widthChangeCallback);




/* --------------- Map and Shop list ------------------ */

const list_win = document.getElementById('shop_list_page');
const shop_items = list_win.getElementsByClassName('shop_item');

function scrollParentToChild(parent, child) {
    let parentRect = parent.getBoundingClientRect();
    let parentViewableArea = {
        height: parent.clientHeight,
        width: parent.clientWidth
    };

    let childRect = child.getBoundingClientRect();
    let isViewable = (childRect.top >= parentRect.top) && (childRect.bottom <= parentRect.top + parentViewableArea.height);

    if (!isViewable) {
        const scrollTop = childRect.top - parentRect.top;
        const scrollBot = childRect.bottom - parentRect.bottom;
        if (Math.abs(scrollTop) < Math.abs(scrollBot)) {
            parent.scrollTop += scrollTop;
        } else {
            parent.scrollTop += scrollBot;
        }
    }
}

function hilightListItem(shop_id) {
    const items_cont = list_win.querySelector('.shop_items_cont');

    [...shop_items].forEach(function(shop_item) {
        const item_id = shop_item.getAttribute('data-shopid');
        const info_block = shop_item.getElementsByClassName('shop_info')[0];

        if (parseInt(item_id, 10) === parseInt(shop_id, 10)) {
            shop_item.className = 'shop_item shop_item_active';
            info_block.style.display = 'block';

            scrollParentToChild(items_cont, shop_item);

        } else {
            shop_item.className = 'shop_item';
            info_block.style.display = 'none';
        }
    });
}

function init(){
    let eshopMap = new ymaps.Map("map", {
        center: [55.75, 37.62],
        zoom: mapZoom
    });

    for (let i=0; i<shops_data.length; i++) {
        let placemark = new ymaps.Placemark(
            shops_data[i][2],
            {
                balloonContentHeader: shops_data[i][1][0],
                balloonContentBody: shops_data[i][1][1],
                balloonContentFooter: shops_data[i][1][2],
            },
            {
                hideIconOnBalloonOpen: false,
                balloonOffset: [2, -28],
            }
        );
        eshopMap.geoObjects.add(placemark);

        placemark.events.add('click', function () {
            hilightListItem(shops_data[i][0]);
        });

        shops_data[i].push(placemark);
    }

    eshopMap.events.add('balloonclose', function () {
        hilightListItem(0);
    });

    [...shop_items].forEach(function(shop_item) {
        shop_item.onclick = function (event) {
            const item_id = event.currentTarget.getAttribute('data-shopid');
            hilightListItem(item_id);

            let current_shop = [];
            for (let i=0; i<shops_data.length; i++) {
                if (shops_data[i][0] === parseInt(item_id, 10)) {
                    current_shop = shops_data[i];
                }
            }

            const center = current_shop[2];
            const placemark = current_shop[3];

            eshopMap.setCenter(center, 14, {
                duration: 500,
                timingFunction: 'ease',
            }).then(function () {
                placemark.balloon.open();
            });
        }
    });

    eshopMap.controls.remove('searchControl');
    eshopMap.controls.remove('typeSelector');
    eshopMap.controls.remove('trafficControl');
}

ymaps.ready(init);

