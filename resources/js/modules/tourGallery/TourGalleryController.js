import EventHandler from '../../core/EventHandler';
import lightGallery from 'lightgallery';
import lgThumbnail from 'lightgallery/plugins/thumbnail';
import lgZoom from 'lightgallery/plugins/zoom';

class TourGalleryController extends EventHandler {
    constructor(nodes, params) {
        super();

        this.nodes = nodes;
        this.params = params;

        if (params.images) {
            this.initGallery();

            nodes.images.forEach(node => {
                this.addEvent(node, 'click', _ => {
                    this.showGallery(parseInt(node.getAttribute('data-gallery-image-index')));
                });
            })
        } else {
            console.warn('Failed to initialize tour gallery!');
        }
    }

    initGallery() {
        this.galleryInstance = lightGallery(this.nodes.images[0], {
            dynamic: true,
            thumbnail: true,
            plugins: [lgThumbnail, lgZoom],
            dynamicEl: this.params.images.map(link => ({
                src: link,
                thumb: link
            }))
        });
    }

    showGallery(index) {
        this.galleryInstance.openGallery(index);
    }
}

export default TourGalleryController;