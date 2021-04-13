import UpdateTourController from './UpdateTourController';

document.addEventListener('DOMContentLoaded', _ => {
    const form = document.querySelector('#editTourForm');
    const updateTourButton = document.querySelector('#editTourForm .update-tour-button');

    if (form) {
        const controller = new UpdateTourController({
            error: document.querySelector('#editTourForm .error-message'),
            success: document.querySelector('#editTourForm .success-message'),
            updateTourButton
        });

        // Image boxes initialization
        const imageItems = document.querySelectorAll('#editTourForm .image-item');

        if (imageItems.length !== 0) {
            controller.initImageBoxes(imageItems);
        } else {
            console.error('Failed to initialize image boxes!');
        }

        // Date picker initialization
        const datePickerTextInput = document.querySelector('#editTourForm input[name="date"]');

        if (datePickerTextInput) {
            controller.initDateCalendar(datePickerTextInput);
        } else {
            console.error('Failed to initialize date picker!');
        }

        // Update tour
        updateTourButton.addEventListener('click', e => {
            if (!e.currentTarget.classList.contains('loading')) {
                controller.updateTour(form);
            }
        });
    }
});
