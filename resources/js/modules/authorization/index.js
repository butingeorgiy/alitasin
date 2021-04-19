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

        loginButton.addEventListener('click', e => {
            if (!e.currentTarget.classList.contains('loading')) {
                controller.login(loginPopup);
            }
        });
    }
});
