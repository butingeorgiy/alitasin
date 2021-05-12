import EventHandler from '../../core/EventHandler';
import DropdownObserver from '../../observers/DropdownObserver';
import LocaleHelper from '../../helpers/LocaleHelper';
import JsonHelper from '../../helpers/JsonHelper';
import PartnerListModel from './PartnerListModel';
import PopupObserver from '../../observers/PopupObserver';
import PartnerListView from './PartnerListView';

class PartnerListController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = {
            ...nodes,
            makePartnerPaymentButton: nodes.partnerPaymentPopup.querySelector('.make-partner-payment-button')
        };
        this.view = new PartnerListView({
            paymentPopupButtonNode: this.nodes.makePartnerPaymentButton,
            paymentPopupErrorNode: nodes.partnerPaymentPopup.querySelector('.error-message'),
            paymentPopupSuccessNode: nodes.partnerPaymentPopup.querySelector('.success-message')
        });
        this.loading = false;

        this.initPartnerPayment();

        nodes.partnersContainer.querySelectorAll('.partners-item').forEach(node => {
            if (node.querySelector('.show-custom-dropdown-button') && node.querySelector('.custom-dropdown-container')) {
                DropdownObserver.init(
                    node.querySelector('.custom-dropdown-container'),
                    node.querySelector('.show-custom-dropdown-button'),
                    (key, option) => this.onContextOptionClick(key, option)
                );
            }
        });
    }

    initPartnerPayment() {
        this.partnerPaymentPopup = PopupObserver.init(
            this.nodes.partnerPaymentPopup,
            false,
            _ => this.removeAllListeners(this.nodes.makePartnerPaymentButton, 'click')
        );
    }

    onContextOptionClick(key, options) {
        switch (key) {
            case 'delete':
                if (confirm(LocaleHelper.translate('you-are-sure'))) {
                    this.delete(JsonHelper.getFromJson(options, 'id'));
                }
                break;
            case 'restore':
                if (confirm(LocaleHelper.translate('you-are-sure'))) {
                    this.restore(JsonHelper.getFromJson(options, 'id'));
                }
                break;
            case 'make-payment':
                this.partnerPaymentPopup.open(_ => {
                    this.addEvent(this.nodes.makePartnerPaymentButton, 'click', _ => {
                        if (!this.loading) {
                            this.loading = true;
                            this.makePayment(JsonHelper.getFromJson(options, 'id'));
                        }
                    });
                });
                break;
        }
    }

    delete(id) {
        if (!id) {
            return;
        }

        PartnerListModel.delete(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`)
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }

    restore(id) {
        if (!id) {
            return;
        }

        PartnerListModel.restore(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`)
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }

    makePayment(id) {
        if (!id) {
            return;
        }

        console.log(id)

        this.view.hidePaymentPopupError();
        this.view.showPaymentPopupLoading();

        const formData = new FormData();

        if (this.nodes.partnerPaymentPopup.querySelector('input[name="amount"]')?.value) {
            formData.append('amount', this.nodes.partnerPaymentPopup.querySelector('input[name="amount"]')?.value)
        }

        PartnerListModel.makePayment(formData, id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    this.loading = false;
                } else if (result.error) {
                    this.view.showPaymentPopupError(result.message);
                    this.loading = false;
                } else {
                    this.view.showPaymentPopupSuccess(result.message);
                    setTimeout(_ => location.reload(), 500);
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
                this.loading = false;
            })
            .finally(_ => {
                this.view.hidePaymentPopupLoading();
            });
    }
}

export default PartnerListController;
