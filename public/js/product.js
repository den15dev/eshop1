/* ---------- Cart quantity buttons ------------ */

let qty_input = document.getElementById('item_qty_input');
let qty_minus_btn = qty_input.parentNode.getElementsByTagName('button')[0];
let qty_plus_btn = qty_input.parentNode.getElementsByTagName('button')[1];
qty_minus_btn.onclick = function () {
    if (qty_input.value > 1) {
        qty_input.value = parseInt(qty_input.value, 10) - 1;
        Livewire.emit('updateQuantity', qty_input.value);
    }
}
qty_plus_btn.onclick = function () {
    qty_input.value = parseInt(qty_input.value, 10) + 1;
    Livewire.emit('updateQuantity', qty_input.value);
}



/* --------------- Images ------------------ */

document.addEventListener( 'DOMContentLoaded', function () {
    var main = new Splide( '#item_img_main', {
        type      : 'fade',
        rewind    : true,
        pagination: false,
        arrows    : false,
    } );

    var thumbnails = new Splide( '#item_thumbnails', {
        fixedWidth  : 80,
        fixedHeight : 80,
        gap         : 4,
        arrows      : false,
        rewind      : true,
        pagination  : false,
        cover       : true,
        isNavigation: true,
        breakpoints : {
            576: {
                fixedWidth : 60,
                fixedHeight: 60,
            },
        },
    } );

    main.sync( thumbnails );
    main.mount();
    thumbnails.mount();
});



/* ---------- Tabs functionality ----------- */

$(function(){
    let hash = window.location.hash;
    hash && $('div.nav a[href="' + hash + '"]').tab('show');

    $('.nav-tabs a').click(function (e) {
        $(this).tab('show');
        let scrollmem = $(window).scrollTop();
        window.location.hash = this.hash;
        $('html,body').scrollTop(scrollmem);
    });

    $('#all_specs_link').click(function (e) {
        $('div.nav a[href="#specifications"]').tab('show');
        window.location.hash = this.hash;
    });
});



/* ------------- Review form -------------- */

let rateStarsCont = document.getElementById('item_rate_stars');
let ratingInput = document.getElementById('rating_input');
let ratingNote = document.getElementById('rating_note');

if (rateStarsCont) {
    let starsArr = Array.from(rateStarsCont.getElementsByClassName('bi-star'));

    for (let i = 0; i < 5; i++) {
        starsArr[i].onclick = function (event) {
            let curStar = event.currentTarget;
            let ind = starsArr.indexOf(curStar);

            for (let i = 0; i < 5; i++) {
                if (i < (ind + 1)) {
                    starsArr[i].className = 'bi-star-fill';
                } else {
                    starsArr[i].className = 'bi-star';
                }
            }

            ratingInput.value = ind + 1;
            ratingNote.style.display = 'none';
        };

        // Recolor stars in case of failed submitting
        if (ratingInput.value) {
            for (let i = 0; i < 5; i++) {
                if (i < (ratingInput.value)) {
                    starsArr[i].className = 'bi-star-fill';
                } else {
                    starsArr[i].className = 'bi-star';
                }
            }
        }
    }
}

function validateReviewForm() {
    if (!ratingInput.value) {
        ratingNote.style.display = 'block';
        return false;
    }
    return true;
}
