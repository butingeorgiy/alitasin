import AuthorizationController from './AuthorizationController';

document.addEventListener('DOMContentLoaded', _ => {
    const loginPopup = document.querySelector('#loginPopup');

    if (loginPopup) {
        const loginButton = document.querySelector('.login-button');
        const showLoginPopupButtons = document.querySelectorAll('header .show-login-popup-button');

        const controller = new AuthorizationController({
            popup: loginPopup,
            error: document.querySelector('#loginPopup .error-message'),
            btn: loginButton
        });

        if (showLoginPopupButtons.length > 0) {
            showLoginPopupButtons.forEach(node => {
                node.addEventListener('click', _ => controller.showForm());
            });
        }

        loginButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.login(loginPopup);
            }
        });
    }
});
