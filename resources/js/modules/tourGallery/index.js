import TourGalleryController from './TourGalleryController';
import JsonHelper from '../../helpers/JsonHelper';

document.addEventListener('DOMContentLoaded', _ => {
    const tourImagesHiddenInput = document.querySelector('input[name="tour_images"]');

    if (/^\/tours\/\d+$/.test(location.pathname) && tourImagesHiddenInput) {
        new TourGalleryController({
            images: document.querySelectorAll('.show-gallery-button')
        }, {
            images: JsonHelper.parse(tourImagesHiddenInput.value)
        });
    }
});