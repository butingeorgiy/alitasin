import CreateSubPartnerController from "./CreateSubPartnerController";

document.addEventListener('DOMContentLoaded', _ => {
    const createSubPartnerPopup = document.querySelector('#createSubPartnerPopup');
    const showPopupButton = document.querySelector('.add-sub-partner-button');

    if (createSubPartnerPopup) {
        new CreateSubPartnerController({
            popup: createSubPartnerPopup,
            showPopupButton,
            errorNode: createSubPartnerPopup.querySelector('.error-message'),
            successNode: createSubPartnerPopup.querySelector('.success-message'),
            submitFormButton: createSubPartnerPopup.querySelector('.save-sub-partner-button')
        });
    }
});