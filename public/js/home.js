new Splide( '.crs_actions', {
    height: 500,
    arrows: false,
    type: 'loop',
    autoplay: true
} ).mount();


// Check if arrows needed
let crsNames = [
    'crs_best_prices',
    'crs_new',
    'crs_most_popular'
];
let blockWidth = 242;

for (let i=0; i<crsNames.length; i++) {
    let enableArrows = true;
    let crsSection = document.getElementsByClassName(crsNames[i]);
    let sectionWidth = crsSection[0].clientWidth;
    let blockNum = crsSection[0].getElementsByClassName('cat_block').length;
    if (blockNum * blockWidth < sectionWidth) enableArrows = false;

    let carousel_params = {
        type: 'slide',
        speed: 200,
        easing: 'cubic-bezier(0.2, 0, 0.5, 1)',
        fixedWidth: blockWidth,
        gap: 18,
        perPage: carousel_perpage,
        breakpoints: {
            1400: {
                perPage: carousel_perpage - 1,
            },
            1200: {
                perPage: carousel_perpage - 2,
            },
        },
        perMove: 1,
        arrows: enableArrows,
        rewind: true,
        pagination: false
    };

    new Splide('.' + crsNames[i], carousel_params).mount();
}
