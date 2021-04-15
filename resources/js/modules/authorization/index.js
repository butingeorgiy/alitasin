import AuthorizationController from './AuthorizationController';

document.addEventListener('DOMContentLoaded', _ => {
    const loginPopup = document.querySelector('#loginPopup');
    const showLoginPopupButton = document.querySelector('header .show-login-popup-button');

    if (loginPopup && showLoginPopupButton) {
        const loginButton = document.querySelector('.login-button');

        const controller = new AuthorizationController({
            popup: loginPopup,
            error: document.querySelector('#loginPopup .error-message'),
            btn: loginButton
        });

        showLoginPopupButton.addEventListener('click', _ => controller.showForm());

        loginButton.addEventListener('click', e => {
            if (!e.currentTarget.classList.contains('loading')) {
                controller.login(loginPopup);
            }
        });
    }

    // Logout
    const logoutButton = document.querySelector('header .logout-button');

    if (logoutButton) {
        logoutButton.addEventListener('click', AuthorizationController.logout);
    }
});
