import ReviewsSliderController from './reviewsSliderController';

document.addEventListener('DOMContentLoaded', _ => {
    if (document.querySelector("#reviewsSliderSection .swiper-container")) {
        ReviewsSliderController.init();
    }
});
