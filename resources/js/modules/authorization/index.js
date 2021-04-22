import AuthorizationController from './AuthorizationController';

document.addEventListener('DOMContentLoaded', _ => {
    const loginPopup = document.querySelector('#loginPopup');

    if (loginPopup) {
        const loginButton = document.querySelector('.login-button');
        const showLoginPopupButton = document.querySelector('header .show-login-popup-button');

        const controller = new AuthorizationController({
            popup: loginPopup,
            error: document.querySelector('#loginPopup .error-message'),
            btn: loginButton
        });

        if (showLoginPopupButton) {
            showLoginPopupButton.addEventListener('click', _ => controller.showForm());
        }

        loginButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.login(loginPopup);
            }
        });
    }
});
