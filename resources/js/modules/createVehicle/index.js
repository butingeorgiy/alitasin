import CreateVehicleController from './CreateVehicleController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#createVehicleForm');
    const saveVehicleButton = document.querySelector('#createVehicleForm .save-vehicle-button');

    if (form) {
        const controller = new CreateVehicleController({
            error: form.querySelector('.error-message'),
            success: form.querySelector('.success-message'),
            saveVehicleButton,
            paramPopup: document.querySelector('#parameterPopup'),
            openParamPopupButton: form.querySelector('.open-param-popup-button'),
            paramsContainer: form.querySelector('.params-container')
        });

        // Image boxes initialization
        const imageItems = document.querySelectorAll('#createVehicleForm .image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Save tour handler
        saveVehicleButton.addEventListener('click', _ => {
            if (!controller.loading) {
                controller.loading = true;
                controller.saveVehicle(form);
            }
        });
    }
});
