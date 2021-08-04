import ManageTransfersController from './ManageTransfersController';

document.addEventListener('DOMContentLoaded', _ => {
    if (/admin\/transfers/.test(location.pathname)) {
        new ManageTransfersController({
            showAirportCreatingPopupButton: document.querySelector('#editTransfersSection .airport-manage-button.create'),
            showAirportUpdatingPopupButton: document.querySelector('#editTransfersSection .airport-manage-button.update'),
            deleteAirportButton: document.querySelector('#editTransfersSection .airport-manage-button.delete'),
            restoreAirportButton: document.querySelector('#editTransfersSection .airport-manage-button.restore'),
            showDestinationCreatingPopupButton: document.querySelector('#editTransfersSection .destination-manage-button.create'),
            showDestinationUpdatingPopupButton: document.querySelector('#editTransfersSection .destination-manage-button.update'),
            deleteDestinationButton: document.querySelector('#editTransfersSection .destination-manage-button.delete'),
            restoreDestinationButton: document.querySelector('#editTransfersSection .destination-manage-button.restore')
        });
    }
});