import UpdatePropertyController from './UpdatePropertyController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#editPropertyForm');
    const updatePropertyButton = document.querySelector('#editPropertyForm .save-property-button');

    if (form) {
        const controller = new UpdatePropertyController({
            error: document.querySelector('#editPropertyForm .error-message'),
            success: document.querySelector('#editPropertyForm .success-message'),
            updatePropertyButton,
            paramPopup: document.querySelector('#parameterPopup'),
            openParamPopupButton: form.querySelector('.open-param-popup-button'),
            paramsContainer: form.querySelector('.params-container'),
            restoreButton: form.querySelector('.restore-property-button')
        });

        // Image boxes initialization
        const imageItems = form.querySelectorAll('.image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Update vehicle handler
        updatePropertyButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.updateProperty(form);
            }
        });
    }
});