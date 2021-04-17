import Swiper from 'swiper';

class SliderController {
    static initReviewsSlider() {
        new Swiper('#reviewsSliderSection .swiper-container', {
            spaceBetween: 20,
            loop: true,
            slidesPerView: 'auto',
            breakpoints: {
                768: {
                    slidesPerView: 3
                },
                640: {
                    slidesPerView: 2
                }
            }
        });
    }

    static initTransportSlider() {
        new Swiper('#transportSection .swiper-container', {
            spaceBetween: 16,
            loop: true,
            slidesPerView: 'auto'
        });
    }

    static initRegionsSlider() {
        new Swiper('#regionsSection .swiper-container', {
            spaceBetween: 16,
            loop: true,
            slidesPerView: 'auto'
        });
    }

    static initPopularToursSlider() {
        new Swiper('#popularToursSection .swiper-container', {
            spaceBetween: 16,
            loop: true,
            slidesPerView: 'auto'
        });
    }
}

export default SliderController;
