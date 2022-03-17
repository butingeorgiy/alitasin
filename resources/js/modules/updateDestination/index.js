import UpdateDestinationController from './UpdateDestinationController';

document.addEventListener('DOMContentLoaded', _ => {
    const popup = document.querySelector('#destinationPopup');

    if (popup) {
        new UpdateDestinationController({
            popup,
            error: popup.querySelector('.error-message'),
            success: popup.querySelector('.success-message'),
            saveButton: popup.querySelector('.save-destination-button')
        });
    }
});