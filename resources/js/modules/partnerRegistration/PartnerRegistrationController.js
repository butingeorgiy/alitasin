import EventHandler from "../../core/EventHandler";
import PartnerRegistrationView from "./PartnerRegistrationView";
import PartnerRegistrationModel from "./PartnerRegistrationModel";
import Cookies from "js-cookie";

class PartnerRegistrationController extends EventHandler {
    constructor(nodes) {
        super();

        this.loading = false;
        this.nodes = nodes;

        this.view = new PartnerRegistrationView({
            buttonNode: nodes.submitFormButton,
            errorNode: nodes.errorNode
        });

        this.addEvent(nodes.submitFormButton, 'click', e => {
            e.preventDefault();

            if (this.loading === false) {
                this.loading = true;
                this.sendForm();
            }
        })
    }

    prepareRegisterData() {
        const formData = new FormData;
        const form = this.nodes.form;

        if (form.querySelector('input[name="first_name"]')) {
            formData.append(
                'first_name',
                form.querySelector('input[name="first_name"]').value
            )
        }

        if (form.querySelector('input[name="email"]')) {
            formData.append(
                'email',
                form.querySelector('input[name="email"]').value
            )
        }

        if (form.querySelector('input[name="phone"]')) {
            formData.append(
                'phone',
                form.querySelector('input[name="phone"]').value.replace(/\D/g, '')
            )
        }

        if (form.querySelector('input[name="city"]')) {
            formData.append(
                'city',
                form.querySelector('input[name="city"]').value
            )
        }

        if (form.querySelector('input[name="promo_code"]')) {
            formData.append(
                'promo_code',
                form.querySelector('input[name="promo_code"]').value
            )
        }

        if (form.querySelector('input[name="partner_code"]')?.value) {
            formData.append(
                'partner_code',
                form.querySelector('input[name="partner_code"]').value
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

    sendForm() {
        this.view.showButtonLoading();
        this.view.hideError();

        PartnerRegistrationModel.send(this.prepareRegisterData())
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.view.showError(result.message);
                } else {
                    this.setAuthCookie(result.cookies);
                    location.replace('/profile/partner');
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
                this.view.hideButtonLoading();
            });
    }

    setAuthCookie(cookies) {
        Cookies.set('id', cookies.id, { expires: 7 });
        Cookies.set('token', cookies.token, { expires: 7 });
    }
}

export default PartnerRegistrationController;