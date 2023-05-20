// Check if arrows needed
let crsName = 'crs_recently_viewed';
let blockWidth = 242;
let enableArrows = true;
let crsSection = document.getElementsByClassName(crsName);
let sectionWidth = crsSection[0].clientWidth;
let blockNum = crsSection[0].getElementsByClassName('cat_block').length;
if (blockNum * blockWidth < sectionWidth) enableArrows = false;

new Splide( '.' + crsName, {
    type: 'slide',
    speed: 200,
    easing: 'cubic-bezier(0.2, 0, 0.5, 1)',
    fixedWidth: blockWidth,
    gap: 18,
    perPage: carousel_perpage,
    breakpoints: {
        1400: {
            perPage: carousel_perpage-1,
        },
        1200: {
            perPage: carousel_perpage-2,
        },
    },
    perMove: 1,
    arrows: enableArrows,
    rewind: true,
    pagination: false
} ).mount();
