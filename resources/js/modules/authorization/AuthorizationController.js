import PopupObserver from '../../observers/PopupObserver';
import AuthorizationView from './AuthorizationView';
import AuthorizationModel from './AuthorizationModel';
import AuthenticationBaseController from '../../extenders/controllers/AuthenticationBaseController';

class AuthorizationController extends AuthenticationBaseController {
    constructor(nodes) {
        super(nodes);

        this.view = new AuthorizationView({
            error: nodes.error,
            btn: nodes.btn
        });
    }

    initPopup() {
        this.popup = PopupObserver.init(
            this.nodes.popup,
            location.hash === '#login'
        );

        if (location.hash === '#login') {
            history.replaceState(null, null, '/');
        }
    }

    login(form) {
        this.view.showLoader();
        this.view.hideError();

        const emailInput = form.querySelector('input[name="email"]');
        const passwordInput = form.querySelector('input[name="password"]');
        const formData = new FormData();

        if (emailInput) {
            formData.append('email', emailInput.value);
        }

        if (passwordInput) {
            formData.append('password', passwordInput.value);
        }

        AuthorizationModel.login(formData)
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
                    location.assign(result.redirect_to);
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }
}

export default AuthorizationController;
