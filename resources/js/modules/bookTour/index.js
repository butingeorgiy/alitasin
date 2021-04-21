import BookTourController from './BookTourController';

document.addEventListener('DOMContentLoaded', _ => {
    const bookTourSection = document.querySelector('#bookTourSection');

    if (bookTourSection && /\/tours\/\d+$/.test(location.pathname)) {
        const resetPromoCodeButton = document.querySelector('#bookTourSection .promo-code .reset-button'),
              checkPromoCodeButton = document.querySelector('#bookTourSection .promo-code .check-promo-code-button'),
              promoCodeInput = document.querySelector('#bookTourSection .promo-code input[name="promo_code"]');

        new BookTourController({
            form: document.querySelector('#bookTourSection form.book-tour-form'),
            generalInfoForm: document.querySelector('#bookTourSection form.general-info-form'),
            resetPromoCodeButton,
            checkPromoCodeButton,
            promoCodeInput,
            error: document.querySelector('#bookTourSection .error-message'),
            success: document.querySelector('#bookTourSection .success-message'),
            reserveTourButton: document.querySelector('#bookTourSection .save-book-button')
        });
    }
});
