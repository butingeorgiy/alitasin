import EventHandler from '../../core/EventHandler';
import TransferRequestView from './TransferRequestView';
import PopupObserver from '../../observers/PopupObserver';
import TransferRequestObserver from '../../observers/TransferRequestObserver';
import TransferRequestModel from './TransferRequestModel';

class TransferRequestController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = {
            ...nodes,
            promoCodeInput: nodes.transferOrderPopup.querySelector('input[name="promo_code"]'),
            resetPromoCodeButton: nodes.transferOrderPopup.querySelector('.reset-button')
        };

        this.view = new TransferRequestView({
            successMessage: nodes.successMessage,
            errorMessage: nodes.errorMessage,
            transferOrderButton: nodes.transferOrderButton,
            showPopupButton: nodes.showTransferOrderPopupButton,
            promoCodeWrapper: this.nodes.promoCodeInput?.parentElement,
            oldPrice: nodes.oldPrice,
            totalPrice: nodes.totalPrice
        });

        this.loading = false;
        this.promoCodeChecking = false;
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
        });

        this.nodes.promoCodeInput = nodes.transferOrderPopup.querySelector('input[name="promo_code"]');

        if (this.nodes.promoCodeInput) {
            this.addEvent(nodes.checkPromoCodeButton, 'click', e => {
                e.preventDefault();

                const promoCode = this.nodes.promoCodeInput.value;

                if (!this.promoCodeChecking && promoCode) {
                    this.promoCodeChecking = true;
                    this.checkPromoCode(promoCode);
                }
            });

            this.addEvent(this.nodes.resetPromoCodeButton, 'click', _ => {
                this.view.disablePromoCode();
                this.view.renderTransferTotalPrice(TransferRequestObserver.getCost());
                this.requestData['promo_code'] = null;
            });
        } else {
            console.warn('Promo code input is not defined!');
        }
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.transferOrderPopup, false, _ => {
            this.clearForm();
        });

        this.addEvent(this.nodes.showTransferOrderPopupButton, 'click', _ => {
            this.popup.open(_ => {
                this.view.renderTransferTotalPrice(TransferRequestObserver.getCost());
            });
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
                    case 'promo_code':
                        output['promo_code'] = this.requestData['promo_code'];
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

    setPromoCode(promoCode) {
        this.requestData['promo_code'] = promoCode;
    }

    clearForm() {
        this.requestData = {
            'user_id': null,
            'user_name': null,
            'user_phone': null,
            'user_email': null,
            'flight_number': null,
            'promo_code': null
        };

        this.view.clearForm();
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
                    this.setPromoCode(promoCode);
                    this.view.enablePromoCode(result['sale_percent']);
                    this.view.renderTransferTotalPrice(
                        TransferRequestObserver.getCost() * (100 - result['sale_percent']) / 100,
                        TransferRequestObserver.getCost()
                    )
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.promoCodeChecking = false;
            });
    }
}

export default TransferRequestController;