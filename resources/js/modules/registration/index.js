import RegistrationController from './RegistrationController';

document.addEventListener('DOMContentLoaded', _ => {
    const regPopup = document.querySelector('#regPopup');

    if (regPopup) {
        const regButton = document.querySelector('#regPopup .create-account-button');
        const showRegPopupButtons = document.querySelectorAll('.show-reg-popup-button');

        const controller = new RegistrationController({
            popup: regPopup,
            error: document.querySelector('#regPopup .error-message'),
            btn: regButton
        });

        if (showRegPopupButtons.length > 0) {
            showRegPopupButtons.forEach(node => {
                node.addEventListener('click', _ => controller.showForm());
            });
        }

        regButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.reg(regPopup);
            }
        });
    }
});
