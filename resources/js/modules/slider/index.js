import SliderController from './SliderController';

document.addEventListener('DOMContentLoaded', _ => {
    if (document.querySelector("#reviewsSliderSection .swiper-container")) {
        SliderController.initReviewsSlider();
    }

    if (document.querySelector("#transportSection .swiper-container")) {
        SliderController.initTransportSlider();
    }

    if (document.querySelector('#regionsSection .swiper-container')) {
        SliderController.initRegionsSlider();
    }

    if (document.querySelector('#popularToursSection .swiper-container')) {
        SliderController.initPopularToursSlider();
    }

    if (document.querySelector('#tourInfoSection .swiper-container')) {
        SliderController.initTourGallerySlider();
    }
});
