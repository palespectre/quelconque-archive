import css from '../css/app.scss';
import LocomotiveScroll from 'locomotive-scroll';

const header = document.querySelector('header#masthead');

// show/hide header on scroll
export const showMenu = (event) => {
    if (event.direction === 'down') {
        header.classList.remove('show-menu');
        header.classList.add('hide-menu');
    } else {
        header.classList.remove('hide-menu');
        header.classList.add('show-menu');
    }
}
// init locomotive-scroll
const scroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    smooth: true,
    getDirection: true
});

scroll.on('scroll', event => {
    showMenu(event);
});

// update locomotive-scroll once all images are loaded
let images = document.querySelectorAll('img');
images.forEach((img, iteration) => {
    // add condition if images.length > 20, last item
    if (images.length > 10) {
        if (iteration === images.length-1) {
            img.onload = function() {
                scroll.update();
            }
        }
    } else {
        img.onload = function() {
            scroll.update();
        }
    }
});

// update locomotive-scroll after filters change
jQuery(document).on('berocket_ajax_products_loaded', function() {
    scroll.update();
    scroll.scrollTo("#content", {duration:100});
});

// prevent wordpress from asking confirmation to navigate away from the current post

// resize product images
const resizeImage = () => {
    let picture = document.querySelector('.wp-post-image');
    picture.width = picture.clientWidth;
    picture.height = picture.clientHeight;
}

setTimeout(function(){ scroll.update(); }, 1000);