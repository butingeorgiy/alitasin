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
            slidesPerView: 'auto',
            mousewheel: {
                releaseOnEdges: true
            }
        });
    }

    static initToursSlider() {
        new Swiper('#toursSliderSection .swiper-container', {
            spaceBetween: 16,
            slidesPerView: 'auto'
        });
    }

    static initTourGallerySlider() {
        new Swiper('#tourInfoSection .swiper-container', {
            spaceBetween: 16,
            loop: true,
            slidesPerView: 'auto'
        });
    }

    static initFavoritesSlider() {
        new Swiper('#favoritesSection .swiper-container', {
            spaceBetween: 16,
            slidesPerView: 1,
            breakpoints: {
                1024: {
                    slidesPerView: 4
                },
                768: {
                    slidesPerView: 3
                },
                640: {
                    slidesPerView: 2
                }
            }
        });
    }

    static initVehicleTypesSlider() {
        new Swiper('#vehicleTypesSection .swiper-container', {
            spaceBetween: 16,
            slidesPerView: 'auto',
            mousewheel: {
                releaseOnEdges: true
            }
        });
    }
}

export default SliderController;
