import EventHandler from "../../core/EventHandler";
import CreateSubPartnerView from "./CreateSubPartnerView";
import PopupObserver from "../../observers/PopupObserver";
import CreateSubPartnerModel from "./CreateSubPartnerModel";

class CreateSubPartnerController extends EventHandler {
    constructor(nodes) {
        super();

        this.loading = false;
        this.nodes = nodes;

        this.view = new CreateSubPartnerView({
            submitFormButton: nodes.submitFormButton,
            errorNode: nodes.errorNode,
            successNode: nodes.successNode
        });

        this.initPopup();

        this.addEvent(nodes.showPopupButton, 'click', _ => {
            this.popup.open();
        });

        this.addEvent(nodes.submitFormButton, 'click', e => {
            e.preventDefault();

            if (this.loading === false) {
                this.loading = true;
                this.createPartner();
            }
        });
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup);
    }

    prepareDataForCreating() {
        const formData = new FormData;
        const form = this.nodes.popup;

        if (form.querySelector('input[name="first_name"]')) {
            formData.append(
                'first_name',
                form.querySelector('input[name="first_name"]').value
            )
        }

        if (form.querySelector('input[name="last_name"]')?.value) {
            formData.append(
                'last_name',
                form.querySelector('input[name="last_name"]').value
            )
        }

        if (form.querySelector('input[name="phone"]')) {
            formData.append(
                'phone',
                form.querySelector('input[name="phone"]').value
            )
        }

        if (form.querySelector('input[name="email"]')) {
            formData.append(
                'email',
                form.querySelector('input[name="email"]').value
            )
        }

        if (form.querySelector('input[name="promo_code"]')) {
            formData.append(
                'promo_code',
                form.querySelector('input[name="promo_code"]').value
            )
        }

        if (form.querySelector('input[name="city"]')) {
            formData.append(
                'city',
                form.querySelector('input[name="city"]').value
            )
        }

        if (form.querySelector('input[name="password"]')) {
            formData.append(
                'password',
                form.querySelector('input[name="password"]').value
            )
        }

        if (form.querySelector('input[name="password_confirmation"]')) {
            formData.append(
                'password_confirmation',
                form.querySelector('input[name="password_confirmation"]').value
            )
        }

        return formData;
    }

    createPartner() {
        this.view.hideError();
        this.view.showButtonLoading();

        CreateSubPartnerModel.send(this.prepareDataForCreating())
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.view.showError(result.message);
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => location.reload(), 1000);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
                this.view.hideButtonLoading();
            });
    }
}

export default CreateSubPartnerController;