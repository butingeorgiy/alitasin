import PartnerRegistrationController from "./PartnerRegistrationController";

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#partnershipSection form');

    if (form) {
        new PartnerRegistrationController({
            form,
            submitFormButton: form.querySelector('.send-partner-reg-button'),
            errorNode: form.querySelector('.error-message')
        });
    }
});