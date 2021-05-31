import EventHandler from '../../core/EventHandler';
import PopupObserver from '../../observers/PopupObserver';
import CreatePartnerModel from './CreatePartnerModel';
import CreatePartnerView from './CreatePartnerView';

class CreatePartnerController extends EventHandler {
    constructor(nodes) {
        super();

        this.loading = false;
        this.nodes = {
            ...nodes,
            savePartnerButton: nodes.createPartnerPopup.querySelector('.save-partner-button')
        };
        this.view = new CreatePartnerView({
            buttonNode: this.nodes.savePartnerButton,
            errorNode: nodes.createPartnerPopup.querySelector('.error-message'),
            successNode: nodes.createPartnerPopup.querySelector('.success-message')
        });

        this.initPopup();

        this.addEvent(nodes.openCreatePartnerPopupButton, 'click', _ => this.popup.open());
        this.addEvent(this.nodes.savePartnerButton, 'click', _ => {
            if (!this.loading) {
                this.loading = true;
                this.create();
            }
        });
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.createPartnerPopup);
    }

    create() {
        this.view.showLoading();
        this.view.hideError();

        const formData = new FormData();

        if (this.nodes.createPartnerPopup.querySelector('input[name="first_name"]')?.value) {
            formData.append('first_name', this.nodes.createPartnerPopup.querySelector('input[name="first_name"]')?.value);
        }

        if (this.nodes.createPartnerPopup.querySelector('input[name="last_name"]')?.value) {
            formData.append('last_name', this.nodes.createPartnerPopup.querySelector('input[name="last_name"]')?.value);
        }

        if (this.nodes.createPartnerPopup.querySelector('input[name="phone"]')?.value.replace(/\D/g, '')) {
            formData.append('phone', this.nodes.createPartnerPopup.querySelector('input[name="phone"]')?.value.replace(/\D/g, ''));
        }

        if (this.nodes.createPartnerPopup.querySelector('input[name="email"]')?.value) {
            formData.append('email', this.nodes.createPartnerPopup.querySelector('input[name="email"]')?.value);
        }

        if (this.nodes.createPartnerPopup.querySelector('input[name="profit_percent"]')?.value) {
            formData.append('profit_percent', this.nodes.createPartnerPopup.querySelector('input[name="profit_percent"]')?.value);
        }

        if (this.nodes.createPartnerPopup.querySelector('input[name="promo_code"]')?.value) {
            formData.append('promo_code', this.nodes.createPartnerPopup.querySelector('input[name="promo_code"]')?.value);
        }

        if (this.nodes.createPartnerPopup.querySelector('input[name="sale_percent"]')?.value) {
            formData.append('sale_percent', this.nodes.createPartnerPopup.querySelector('input[name="sale_percent"]')?.value);
        }

        if (/^\/admin\/partners\/\d+$/.test(location.pathname)) {
            formData.append('parent_user_id', location.pathname.split('/')[3]);
        }

        if (
            /^\/admin\/partners$/.test(location.pathname) &&
            this.nodes.createPartnerPopup.querySelector('input[name="sub_partner_profit_percent"]')
        ) {
            formData.append(
                'sub_partner_profit_percent',
                this.nodes.createPartnerPopup.querySelector('input[name="sub_partner_profit_percent"]')?.value
            );
        }

        CreatePartnerModel.create(formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${error}`);
                    this.loading = false;
                    this.view.hideLoading();
                } else if (result.error) {
                    this.loading = false;
                    this.view.showError(result.message);
                    this.view.hideLoading();
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => location.reload(), 500);
                }
            }).catch(error => {
                alert(`Error: ${error}`);
                this.loading = false;
                this.view.hideLoading();
            });
    }
}

export default CreatePartnerController;
