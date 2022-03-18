import CreatePropertyController from './CreatePropertyController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#createPropertyForm');
    const savePropertyButton = document.querySelector('#createPropertyForm .save-property-button');

    if (form) {
        const controller = new CreatePropertyController({
            error: form.querySelector('.error-message'),
            success: form.querySelector('.success-message'),
            savePropertyButton,
            paramPopup: document.querySelector('#parameterPopup'),
            openParamPopupButton: form.querySelector('.open-param-popup-button'),
            paramsContainer: form.querySelector('.params-container')
        });

        // Image boxes initialization

        const imageItems = document.querySelectorAll('#createPropertyForm .image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Save property handler

        savePropertyButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.saveProperty(form);
            }
        });
    }
});