import CreateTourController from './CreateTourController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#createTourForm');
    const saveTourButton = document.querySelector('#createTourForm .save-tour-button');

    if (form) {
        const controller = new CreateTourController({
            error: form.querySelector('.error-message'),
            success: form.querySelector('.success-message'),
            saveTourButton,
            datePickerTextInput: form.querySelector('input[name="date"]'),
            additionPopup: document.querySelector('#additionPopup'),
            openAdditionPopupButtons: form.querySelectorAll('.open-addition-popup-button'),
            includesAdditionsContainer: form.querySelector('.tour-includes-container'),
            notIncludesAdditionsContainer: form.querySelector('.tour-not-includes-container')
        });

        // Image boxes initialization
        const imageItems = document.querySelectorAll('#createTourForm .image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Save tour handler
        saveTourButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.saveTour(form);
            }
        });
    }
});
