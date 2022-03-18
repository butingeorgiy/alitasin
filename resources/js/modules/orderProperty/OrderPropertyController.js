import EventHandler from '../../core/EventHandler';
import OrderPropertyView from './OrderPropertyView';
import lightGallery from 'lightgallery';
import lgThumbnail from 'lightgallery/plugins/thumbnail';
import lgZoom from 'lightgallery/plugins/zoom';
import PopupObserver from '../../observers/PopupObserver';
import LocaleHelper from '../../helpers/LocaleHelper';
import UpdatePropertyModel from '../updateProperty/UpdatePropertyModel';
import OrderPropertyModel from './OrderPropertyModel';

class OrderPropertyController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;

        this.filters = this.getInitFilters();

        this.view = new OrderPropertyView({
            buttonNode: nodes.sendOrderButton,
            errorNode: nodes.popup.querySelector('.error-message'),
            successNode: nodes.popup.querySelector('.success-message')
        });

        this.initPopup();
        this.initPropertyCards(nodes.propertyCards);
        this.initGallery();

        this.addEvent(nodes.regionSelect, 'change', _ => {
            this.switchRegion(nodes.regionSelect.value);
        });

        this.addEvent(nodes.typeSelect, 'change', _ => {
            this.switchType(nodes.typeSelect.value);
        });
    }

    getInitFilters() {
        const path = location.search.slice(1);

        let region = path.match(/region_id=(\d+)/),
            type = path.match(/type_id=(\d+)/);

        if (region) {
            region = region[1];
        }

        if (type) {
            type = type[1];
        }

        return {
            'region_id': region,
            'type_id': type
        };
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup, false, _ => {
            this.removeAllListeners(this.nodes.sendOrderButton, 'click');
        });
    }

    beforePopupOpenHandler(propertyId, propertyTitle) {
        this.nodes.popup.querySelector('.chosen-property').innerText = propertyTitle;

        this.addEvent(this.nodes.sendOrderButton, 'click', _ => {
            if (!this.loading) {
                this.loading = true;
                this.orderProperty(propertyId);
            }
        });
    }

    switchRegion(regionId) {
        this.filters = {
            ...this.filters,
            'region_id': regionId || null
        };

        this.applyFilters();
    }

    switchType(typeId) {
        this.filters = {
            ...this.filters,
            'type_id': typeId || null
        };

        this.applyFilters();
    }

    applyFilters() {
        let params = '?';

        Object.entries(this.filters).forEach(([key, value]) => {
            if (value !== null) {
                params += `${key}=${value}&`;
            }
        });

        if (params === '?') {
            location.replace('/property');
        } else {
            location.replace(`/property${params.slice(0, -1)}`);
        }
    }

    initPropertyCards(items) {
        items.forEach(item => {
            const propertyId = item.getAttribute('data-id');
            const propertyTitle = item.getAttribute('data-title');
            const deleteButton = item.querySelector('.delete-property-button');
            const restoreButton = item.querySelector('.restore-property-button');

            this.addEvent(item.querySelector('.show-property-order-button'), 'click', _ => {
                this.popup.open(_ => {
                    this.beforePopupOpenHandler(propertyId, propertyTitle);
                });
            });

            this.addEvent(deleteButton, 'click', _ => {
                if (!confirm(LocaleHelper.translate('you-are-sure')) || this.loading) {
                    return;
                }

                this.loading = true;
                this.delete(propertyId);
            });


            this.addEvent(restoreButton, 'click', _ => {
                if (!confirm(LocaleHelper.translate('you-are-sure')) || this.loading) {
                    return;
                }

                this.loading = true;
                this.restore(propertyId);
            });
        });
    }

    initGallery() {
        if (!this.nodes.propertyCards.length) {
            return;
        }

        this.galleryInstance = lightGallery(this.nodes.propertyCards[0].querySelector('.show-property-gallery-btn'), {
            dynamic: true,
            thumbnail: true,
            plugins: [lgThumbnail, lgZoom],
            dynamicEl: []
        });

        this.nodes.propertyCards.forEach((node, index) => {
            const button = node.querySelector('.show-property-gallery-btn');

            if (!button) {
                console.warn(`Gallery was not initialized for ${++index} vehicle card!`);
                return;
            }

            const images = JSON.parse(button.getAttribute('data-images') || '[]');

            this.addEvent(button, 'click', _ => {
                this.updateGallery(images);
                this.galleryInstance.openGallery(0);
            });
        });
    }

    updateGallery(images) {
        this.galleryInstance.refresh(images.map(image => ({
            src: image,
            thumb: image,
        })));
    }

    orderProperty(propertyId) {
        this.view.showButtonLoading();
        this.view.hideError();

        const formData = new FormData();

        if (this.nodes.popup.querySelector('input[name="user_name"]')) {
            formData.append('user_name', this.nodes.popup.querySelector('input[name="user_name"]').value);
        }

        if (this.nodes.popup.querySelector('input[name="user_phone"]')) {
            formData.append('user_phone', this.nodes.popup.querySelector('input[name="user_phone"]').value.replace(/\D/g, ''));
        }

        OrderPropertyModel.order(propertyId, formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.view.showError(result.message);
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => location.reload(), 1500);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
                this.view.hideButtonLoading();
            });
    }

    delete(id) {
        UpdatePropertyModel.delete(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`)
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }

    restore(id) {
        UpdatePropertyModel.restore(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`)
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }
}

export default OrderPropertyController;