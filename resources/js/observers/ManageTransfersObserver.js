class ManageTransfersObserver {
    static showCreatingAirportPopup() {
        if (ManageTransfersObserver._showCreatingAirportPopupHandler) {
            ManageTransfersObserver._showCreatingAirportPopupHandler();
        } else {
            console.error('Failed to open popup, because handler has not been set by CreateAirport module!');
        }
    }

    static showUpdatingAirportPopup(data, id) {
        if (ManageTransfersObserver._showUpdatingAirportPopupHandler) {
            ManageTransfersObserver._showUpdatingAirportPopupHandler(data, id);
        } else {
            console.error('Failed to open popup, because handler has not been set by UpdateAirport module!');
        }
    }

    static showCreatingDestinationPopup() {
        if (ManageTransfersObserver._showCreatingDestinationPopupHandler) {
            ManageTransfersObserver._showCreatingDestinationPopupHandler();
        } else {
            console.error('Failed to open popup, because handler has not been set by CreateDestination module!');
        }
    }

    static showUpdatingDestinationPopup(data, id) {
        if (ManageTransfersObserver._showUpdatingDestinationPopupHandler) {
            ManageTransfersObserver._showUpdatingDestinationPopupHandler(data, id);
        } else {
            console.error('Failed to open popup, because handler has not been set by UpdateDestination module!');
        }
    }

    static setShowCreatingAirportPopupHandler(handler) {
        ManageTransfersObserver._showCreatingAirportPopupHandler = handler;
    }

    static setShowUpdatingAirportPopupHandler(handler) {
        ManageTransfersObserver._showUpdatingAirportPopupHandler = handler;
    }

    static setShowCreatingDestinationPopupHandler(handler) {
        ManageTransfersObserver._showCreatingDestinationPopupHandler = handler;
    }

    static setShowUpdatingDestinationPopupHandler(handler) {
        ManageTransfersObserver._showUpdatingDestinationPopupHandler = handler;
    }
}

export default ManageTransfersObserver;