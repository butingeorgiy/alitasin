import EventHandler from '../../core/EventHandler';
import PopupObserver from '../../observers/PopupObserver';
import OrderVehicleView from './OrderVehicleView';
import OrderVehicleModel from './OrderVehicleModel';

class OrderVehicleController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;
        this.view = new OrderVehicleView({
            buttonNode: nodes.sendOrderButton,
            errorNode: nodes.popup.querySelector('.error-message'),
            successNode: nodes.popup.querySelector('.success-message')
        });

        this.initPopup();
        this.initVehicleCards(nodes.vehicleCards);
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup, false, _ => {
            this.removeAllListeners(this.nodes.sendOrderButton, 'click');
        });
    }

    initVehicleCards(items) {
        items.forEach(item => {
            const vehicleId = item.getAttribute('data-id');
            const vehicleTitle = item.getAttribute('data-title');

            this.addEvent(item.querySelector('.show-vehicle-order-button'), 'click', _ => {
                this.popup.open(_ => {
                    this.beforePopupOpenHandler(vehicleTitle, vehicleId);
                });
            });
        });
    }

    beforePopupOpenHandler(vehicleTitle, vehicleId) {
        this.nodes.popup.querySelector('.chosen-vehicle').innerText = vehicleTitle;

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
}

export default OrderVehicleController;
