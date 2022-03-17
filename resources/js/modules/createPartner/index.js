import CreatePartnerController from "./CreatePartnerController";

document.addEventListener('DOMContentLoaded', _ => {
    const openCreatePartnerPopupButton = document.querySelector('.open-create-partner-popup-button'),
          createPartnerPopup = document.querySelector('#createPartnerPopup');

    if ((/^\/admin\/partners$/.test(location.pathname) || /^\/admin\/partners\/\d+$/.test(location.pathname))
        && openCreatePartnerPopupButton && createPartnerPopup) {
        new CreatePartnerController({
            openCreatePartnerPopupButton,
            createPartnerPopup
        });
    }
});
