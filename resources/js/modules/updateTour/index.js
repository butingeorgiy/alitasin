import UpdateTourController from './UpdateTourController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#editTourForm');
    const updateTourButton = document.querySelector('#editTourForm .update-tour-button');

    if (form) {
        const controller = new UpdateTourController({
            error: document.querySelector('#editTourForm .error-message'),
            success: document.querySelector('#editTourForm .success-message'),
            updateTourButton,
            datePickerTextInput: document.querySelector('#createTourForm input[name="date"]'),
            additionPopup: document.querySelector('#additionPopup'),
            openAdditionPopupButtons: form.querySelectorAll('.open-addition-popup-button'),
            includesAdditionsContainer: form.querySelector('.tour-includes-container'),
            notIncludesAdditionsContainer: form.querySelector('.tour-not-includes-container')
        });

        // Image boxes initialization
        const imageItems = document.querySelectorAll('#editTourForm .image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Update tour handler
        updateTourButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.updateTour(form);
            }
        });
    }
});
