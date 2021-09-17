import UpdateVehicleController from './UpdateVehicleController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#editVehicleForm');
    const updateVehicleButton = document.querySelector('#editVehicleForm .save-vehicle-button');

    if (form) {
        const controller = new UpdateVehicleController({
            error: document.querySelector('#editVehicleForm .error-message'),
            success: document.querySelector('#editVehicleForm .success-message'),
            updateVehicleButton,
            paramPopup: document.querySelector('#parameterPopup'),
            openParamPopupButton: form.querySelector('.open-param-popup-button'),
            paramsContainer: form.querySelector('.params-container'),
            restoreButton: form.querySelector('.restore-vehicle-button')
        });

        // Image boxes initialization
        const imageItems = form.querySelectorAll('.image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Update vehicle handler
        updateVehicleButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.updateVehicle(form);
            }
        });
    }
});