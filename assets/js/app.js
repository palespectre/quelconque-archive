import css from '../css/app.scss';
import LocomotiveScroll from 'locomotive-scroll';

// init locomotive-scroll
const scroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    smooth: true,
});

// update locomotive-scroll once all images are loaded
let images = document.querySelectorAll('img');
images.forEach(img => {
    img.onload = function() {
        scroll.update();
    }
});

// update locomotive-scroll after filters change
jQuery(document).on('berocket_ajax_products_loaded', function() {
    scroll.update();
    console.log('updaaate');
});