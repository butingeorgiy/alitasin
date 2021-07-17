import EventHandler from '../../core/EventHandler';
import TransferRequestView from './TransferRequestView';
import PopupObserver from '../../observers/PopupObserver';
import TransferRequestObserver from '../../observers/TransferRequestObserver';
import TransferRequestModel from './TransferRequestModel';

class TransferRequestController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;

        this.view = new TransferRequestView({
            successMessage: nodes.successMessage,
            errorMessage: nodes.errorMessage,
            transferOrderButton: nodes.transferOrderButton,
            showPopupButton: nodes.showTransferOrderPopupButton
        });

        this.loading = false;
        this.requestData = {
            'user_id': null,
            'user_name': null,
            'user_phone': null,
            'user_email': null,
            'flight_number': null,
            'promo_code': null
        };

        this.initPopup();

        this.openPopup = this.openPopup.bind(this);

        TransferRequestObserver.setRenderShowTransferRequestPopupButtonHandler(_ => {
            this.view.renderShowPopupButton();
        });

        TransferRequestObserver.setHideShowTransferRequestPopupButtonHandler(_ => {
            this.view.hideShowPopupButton();
        });

        this.addEvent(nodes.transferOrderButton, 'click', _ => {
            if (!this.loading) {
                this.loading = true;
                this.sendRequest();
            }
        })
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.transferOrderPopup);

        this.addEvent(this.nodes.showTransferOrderPopupButton, 'click', _ => {
            this.popup.open();
        });
    }

    openPopup() {
        this.popup.open();
    }

    convertRequestDataToFormData(requestData, transferData) {
        const formData = new FormData();

        Object.entries({...requestData, ...transferData}).forEach(([key, value = null]) => {
            if (!value) {
                return;
            }

            formData.append(key, value);
        });

        return formData;
    }

    getDataFromRequestForm() {
        let output = {};

        this.nodes.transferOrderPopup.querySelectorAll('input').forEach(node => {
            const name = node.getAttribute('name');

            if (name && node.value) {
                switch (name) {
                    case 'user_id':
                        output['user_id'] = parseInt(node.value);
                        break;
                    case 'user_phone':
                        output['user_phone'] = node.value.replace(/[^\d]/g, '');
                        break;
                    default:
                        output[name] = node.value;
                }
            }
        });

        return output;
    }

    sendRequest() {
        this.view.showLoading();
        this.view.hideError();

        const transferState = TransferRequestObserver.getState();

        if (transferState === null) {
            this.view.hideLoading();
            this.loading = false;
            alert('Error: Failed to get transfer data!');
            return;
        }

        const data = this.convertRequestDataToFormData(
            this.getDataFromRequestForm(),
            transferState
        );

        TransferRequestModel.send(data)
            .then(result => {
                if (typeof result === 'string') {
                    this.loading = false;
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.loading = false;
                    this.view.showError(result.message);
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => location.reload(), 1500);
                }
            })
            .catch(error => {
                this.loading = false;
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.view.hideLoading();
            });
    }
}

export default TransferRequestController;