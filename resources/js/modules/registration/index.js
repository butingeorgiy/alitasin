import RegistrationController from './RegistrationController';

document.addEventListener('DOMContentLoaded', _ => {
    const regPopup = document.querySelector('#regPopup');

    if (regPopup) {
        const regButton = document.querySelector('#regPopup .create-account-button');
        const showRegPopupButton = document.querySelector('.show-reg-popup-button');

        const controller = new RegistrationController({
            popup: regPopup,
            error: document.querySelector('#regPopup .error-message'),
            btn: regButton
        });

        if (showRegPopupButton) {
            showRegPopupButton.addEventListener('click', _ => controller.showForm());
        }

        regButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.reg(regPopup);
            }
        });
    }
});
