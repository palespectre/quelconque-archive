import css from '../css/app.scss';
import LocomotiveScroll from 'locomotive-scroll';

const scroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    smooth: true,
});


let images = document.querySelectorAll('img');
images.forEach(img => {
    img.onload = function() {
        scroll.update();
        console.log('update');
    }
})