import Swiper from 'swiper';

class SliderController {
    static initReviewsSlider() {
        new Swiper('#reviewsSliderSection .swiper-container', {
            spaceBetween: 20,
            loop: true,
            slidesPerView: 2,
            breakpoints: {
                768: {
                    slidesPerView: 3
                }
            }
        });
    }

    static initTransportSlider() {

    }
}

export default SliderController;
