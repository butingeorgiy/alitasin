import AuthenticationBaseController from '../../extenders/controllers/AuthenticationBaseController';
import RegistrationView from './RegistrationView';
import PopupObserver from '../../observers/PopupObserver';
import RegistrationModel from './RegistrationModel';

class RegistrationController extends AuthenticationBaseController {
    constructor(nodes) {
        super(nodes);

        this.view = new RegistrationView({
            error: nodes.error,
            btn: nodes.btn
        });
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup);
    }

    reg(form) {
        this.view.showLoader();
        this.view.hideError();

        const formData = new FormData();

        if (form.querySelector('input[name="first_name"]')) {
            formData.append('first_name', form.querySelector('input[name="first_name"]').value);
        }

        if (form.querySelector('input[name="email"]')) {
            formData.append('email', form.querySelector('input[name="email"]').value);
        }

        if (form.querySelector('input[name="phone"]')) {
            formData.append('phone', form.querySelector('input[name="phone"]').value.replace(/\D/g, ''));
        }

        RegistrationModel.reg(formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`)
                    this.view.hideLoader();
                    this.loading = false;
                } else if (result.error) {
                    this.view.showError(result.message);
                    this.view.hideLoader();
                    this.loading = false;
                } else {
                    this.setAuthCookie(result.cookies);
                    location.assign(`${location.origin}/profile/client`);
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }
}

export default RegistrationController;
