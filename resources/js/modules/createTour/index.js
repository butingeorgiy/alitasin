import CreateTourController from './CreateTourController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#createTourForm');
    const saveTourButton = document.querySelector('#createTourForm .save-tour-button');

    if (form) {
        const controller = new CreateTourController({
            error: document.querySelector('#createTourForm .error-message'),
            success: document.querySelector('#createTourForm .success-message'),
            saveTourButton,
            datePickerTextInput: document.querySelector('#createTourForm input[name="date"]')
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
