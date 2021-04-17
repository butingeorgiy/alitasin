import SlidersController from './SlidersController';

document.addEventListener('DOMContentLoaded', _ => {
    if (document.querySelector("#reviewsSliderSection .swiper-container")) {
        SlidersController.initReviewsSlider('#transportSection .swiper-container');
    }
});
