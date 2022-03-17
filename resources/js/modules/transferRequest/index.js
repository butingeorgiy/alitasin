import TransferRequestController from './TransferRequestController';

document.addEventListener('DOMContentLoaded', _ => {
    const transferOrderPopup = document.querySelector('#transferOrderPopup');
    const showTransferOrderPopupButton = document.querySelector('.show-transfer-request-popup');

    if (transferOrderPopup && showTransferOrderPopupButton) {
        new TransferRequestController({
            transferOrderPopup,
            showTransferOrderPopupButton,
            transferOrderButton: transferOrderPopup.querySelector('.order-transfer-button'),
            successMessage: transferOrderPopup.querySelector('.success-message'),
            errorMessage: transferOrderPopup.querySelector('.error-message'),
            checkPromoCodeButton: transferOrderPopup.querySelector('.check-promo-code-button'),
            oldPrice: transferOrderPopup.querySelector('.old-price'),
            totalPrice: transferOrderPopup.querySelector('.total-price')
        });
    }
});