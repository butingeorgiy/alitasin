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

        this.loading = false;
        this.nodes = {
            ...nodes,
            makePartnerPaymentButton: nodes.partnerPaymentPopup.querySelector('.make-partner-payment-button'),
            updateProfitPercentButton: nodes.updateProfitPercentPopup.querySelector('.update-profit-percent-button')
        };
        this.view = new PartnerListView({
            paymentPopupButtonNode: this.nodes.makePartnerPaymentButton,
            paymentPopupErrorNode: nodes.partnerPaymentPopup.querySelector('.error-message'),
            paymentPopupSuccessNode: nodes.partnerPaymentPopup.querySelector('.success-message'),
            updatePercentPopupButtonNode: this.nodes.updateProfitPercentButton,
            updatePercentPopupErrorNode: nodes.updateProfitPercentPopup.querySelector('.error-message'),
            updatePercentPopupSuccessNode: nodes.updateProfitPercentPopup.querySelector('.success-message')
        });

        this.initPartnerPayment();
        this.initUpdatingProfitPercent();

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

    initUpdatingProfitPercent() {
        this.updateProfitPercentPopup = PopupObserver.init(
            this.nodes.updateProfitPercentPopup,
            false,
            _ => this.removeAllListeners(this.nodes.updateProfitPercentButton, 'click')
        )
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
            case 'update-partner-profit-percent':
                this.nodes.updateProfitPercentPopup.querySelector('.current-profit-percent').innerText =
                    JsonHelper.getFromJson(options, 'current_value');
                this.updateProfitPercentPopup.open(_ => {
                    this.addEvent(this.nodes.updateProfitPercentButton, 'click', _ => {
                        if (!this.loading) {
                            this.loading = true;
                            this.updateProfitPercent(
                                JsonHelper.getFromJson(options, 'id')[0],
                                JsonHelper.getFromJson(options, 'is_sub_partner_percent')[0]
                            );
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

    updateProfitPercent(id, isSubPartnerPercent) {
        if (!id) {
            return;
        }

        this.view.hidePaymentPopupError();
        this.view.showUpdatePercentPopupLoading();

        const formData = new FormData();

        if (this.nodes.updateProfitPercentPopup.querySelector('input[name="profit_percent"]')) {
            formData.append(
                'profit_percent',
                this.nodes.updateProfitPercentPopup.querySelector('input[name="profit_percent"]').value
            );
        }

        formData.append('is_sub_partner_percent', isSubPartnerPercent);

        PartnerListModel.updateProfitPercent(formData, id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    this.loading = false;
                } else if (result.error) {
                    this.view.showUpdatePercentPopupError(result.message);
                    this.loading = false;
                } else {
                    this.view.showUpdatePercentPopupSuccess(result.message);
                    setTimeout(_ => location.reload(), 500);
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
                this.loading = false;
            })
            .finally(_ => {
                this.view.hideUpdatePercentPopupLoading();
            });
    }
}

export default PartnerListController;
