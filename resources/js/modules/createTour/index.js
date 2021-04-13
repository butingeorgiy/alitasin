import CreateTourController from './CreateTourController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#createTourForm');
    const saveTourButton = document.querySelector('#createTourForm .save-tour-button');

    if (form) {
        const controller = new CreateTourController({
            error: document.querySelector('#createTourForm .error-message'),
            success: document.querySelector('#createTourForm .success-message'),
            saveTourButton
        });

        // Image boxes initialization
        const imageItems = document.querySelectorAll('#createTourForm .image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Date picker initialization
        const datePickerTextInput = document.querySelector('#createTourForm input[name="date"]');

        if (datePickerTextInput) {
            controller.initDateCalendar(datePickerTextInput);
        } else {
            console.error('Failed to initialize date picker!');
        }

        // Save tour
        saveTourButton.addEventListener('click', e => {
            if (!e.currentTarget.classList.contains('loading')) {
                controller.saveTour(form);
            }
        });
    }
});
