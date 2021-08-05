import UpdateAirportController from './UpdateAirportController';

document.addEventListener('DOMContentLoaded', _ => {
    const popup = document.querySelector('#airportPopup');

    if (popup) {
        new UpdateAirportController({
            popup,
            error: popup.querySelector('.error-message'),
            success: popup.querySelector('.success-message'),
            saveButton: popup.querySelector('.save-airport-button')
        });
    }
});