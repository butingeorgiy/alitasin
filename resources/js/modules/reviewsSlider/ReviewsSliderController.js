import Swiper from 'swiper';

class ReviewsSliderController {
    static init() {
        new Swiper('#reviewsSliderSection .swiper-container', {
            spaceBetween: 20,
            loop: true,
            slidesPerView: 3
        });
    }
}

export default ReviewsSliderController;
