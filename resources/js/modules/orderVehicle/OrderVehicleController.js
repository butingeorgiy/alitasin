import EventHandler from '../../core/EventHandler';
import PopupObserver from '../../observers/PopupObserver';
import OrderVehicleView from './OrderVehicleView';
import OrderVehicleModel from './OrderVehicleModel';
import lightGallery from 'lightgallery';
import lgThumbnail from 'lightgallery/plugins/thumbnail'
import lgZoom from 'lightgallery/plugins/zoom';
import LocaleHelper from '../../helpers/LocaleHelper';
import TransferRequestModel from '../transferRequest/TransferRequestModel';

class OrderVehicleController extends EventHandler {
    constructor(nodes) {
        super();

        this.loading = false;
        this.nodes = {
            ...nodes,
            promoCodeInput: nodes.popup.querySelector('input[name="promo_code"]'),
            resetPromoCodeButton: nodes.popup.querySelector('.reset-button')
        };

        this.view = new OrderVehicleView({
            buttonNode: nodes.sendOrderButton,
            errorNode: nodes.popup.querySelector('.error-message'),
            successNode: nodes.popup.querySelector('.success-message'),
            promoCodeWrapper: this.nodes.promoCodeInput?.parentElement,
            oldPrice: nodes.oldPrice,
            totalPrice: nodes.totalPrice
        });

        this.promoCode = null;
        this.totalPrice = null;

        this.initPopup();
        this.initVehicleCards(nodes.vehicleCards);
        this.initGallery();

        this.addEvent(nodes.regionSelect, 'change', _ => {
            this.switchRegion(nodes.regionSelect.value);
        });

        if (this.nodes.promoCodeInput) {
            this.addEvent(nodes.checkPromoCodeButton, 'click', e => {
                e.preventDefault();

                const promoCode = this.nodes.promoCodeInput.value;

                if (!this.loading && promoCode) {
                    this.loading = true;
                    this.checkPromoCode(promoCode);
                }
            });

            this.addEvent(this.nodes.resetPromoCodeButton, 'click', _ => {
                this.resetPromoCode();
            });
        }
    }

    checkPromoCode(promoCode) {
        this.view.hideError();

        TransferRequestModel.checkPromoCode(promoCode)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.view.showError(result.message);
                } else {
                    this.promoCode = promoCode;
                    this.view.enablePromoCode(result['sale_percent']);
                    this.view.renderTransferTotalPrice(
                        this.totalPrice * (100 - result['sale_percent']) / 100,
                        this.totalPrice
                    );
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.loading = false;
            });
    }

    resetPromoCode() {
        this.view.disablePromoCode();
        this.view.renderTransferTotalPrice(this.totalPrice);
        this.promoCode = null;
    }

    switchRegion(regionId) {
        const path = location.search.slice(1);
        const matches = path.match(/vehicle_type_id=(\d+)/);

        if (!matches) {
            location.replace(`${location.origin}/vehicles`);
            return;
        }

        let newPath = `vehicle_type_id=${matches[1]}`;

        if (regionId) {
            newPath += `&region_id=${regionId}`;
        }

        location.replace(`${location.origin}/vehicles?${newPath}`);
    }

    initGallery() {
        if (!this.nodes.vehicleCards.length) {
            return;
        }

        this.galleryInstance = lightGallery(this.nodes.vehicleCards[0].querySelector('.show-vehicle-gallery-btn'), {
            dynamic: true,
            thumbnail: true,
            plugins: [lgThumbnail, lgZoom],
            dynamicEl: [
                {
                    src: 'http://ali-tour.local/storage/vehicle_pictures/8xEPJ8k6iA7GdR.png',
                    thumb: 'http://ali-tour.local/storage/vehicle_pictures/8xEPJ8k6iA7GdR.png',
                },
                {
                    src: 'http://ali-tour.local/storage/vehicle_pictures/639Wk6V7PoesUR.png',
                    thumb: 'http://ali-tour.local/storage/vehicle_pictures/639Wk6V7PoesUR.png',
                }
            ]
        });

        this.nodes.vehicleCards.forEach((node, index) => {
            const button = node.querySelector('.show-vehicle-gallery-btn');

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

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup, false, _ => {
            this.removeAllListeners(this.nodes.sendOrderButton, 'click');
            this.resetPromoCode();
            this.totalPrice = null;
        });
    }

    initVehicleCards(items) {
        items.forEach(item => {
            const vehicleId = item.getAttribute('data-id');
            const vehicleTitle = item.getAttribute('data-title');
            const vehicleCost = parseInt(item.getAttribute('data-price'));
            const availableRegion = item.getAttribute('data-region');
            const deleteButton = item.querySelector('.delete-vehicle-button');
            const restoreButton = item.querySelector('.restore-vehicle-button');

            this.addEvent(item.querySelector('.show-vehicle-order-button'), 'click', _ => {
                this.popup.open(_ => {
                    this.totalPrice = vehicleCost;
                    this.beforePopupOpenHandler(vehicleTitle, vehicleId, availableRegion, vehicleCost);
                });
            });

            this.addEvent(deleteButton, 'click', _ => {
                if (!confirm(LocaleHelper.translate('you-are-sure')) || this.loading) {
                    return;
                }

                this.loading = true;
                this.delete(vehicleId);
            });


            this.addEvent(restoreButton, 'click', _ => {
                if (!confirm(LocaleHelper.translate('you-are-sure')) || this.loading) {
                    return;
                }

                this.loading = true;
                this.restore(vehicleId);
            });
        });
    }

    beforePopupOpenHandler(vehicleTitle, vehicleId, availableRegion, vehiclePrice) {
        this.nodes.popup.querySelector('.chosen-vehicle').innerText = vehicleTitle;
        this.nodes.popup.querySelector('.available-region').innerText = availableRegion;
        this.nodes.totalPrice.innerText = vehiclePrice;

        this.addEvent(this.nodes.sendOrderButton, 'click', _ => {
            if (!this.loading) {
                this.loading = true;
                this.orderVehicle(vehicleId);
            }
        });
    }

    orderVehicle(vehicleId) {
        this.view.showButtonLoading();
        this.view.hideError();

        const formData = new FormData();

        if (this.nodes.popup.querySelector('input[name="user_name"]')) {
            formData.append('user_name', this.nodes.popup.querySelector('input[name="user_name"]').value);
        }

        if (this.nodes.popup.querySelector('input[name="user_phone"]')) {
            formData.append('user_phone', this.nodes.popup.querySelector('input[name="user_phone"]').value.replace(/\D/g, ''));
        }

        if (this.nodes.popup.querySelector('input[name="location_region"]')) {
            formData.append('location_region', this.nodes.popup.querySelector('input[name="location_region"]').value);
        }

        if (this.promoCode) {
            formData.append('promo_code', this.promoCode);
        }

        OrderVehicleModel.send(vehicleId, formData)
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
        OrderVehicleModel.deleteVehicle(id)
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
        OrderVehicleModel.restoreVehicle(id)
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

export default OrderVehicleController;
