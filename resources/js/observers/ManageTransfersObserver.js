class ManageTransfersObserver {
    static showCreatingAirportPopup() {
        if (ManageTransfersObserver._showCreatingAirportPopupHandler) {
            ManageTransfersObserver._showCreatingAirportPopupHandler();
        } else {
            console.error('Failed to open popup, because handler has not been set by CreateAirport module!');
        }
    }

    static showCreatingDestinationPopup() {
        if (ManageTransfersObserver._showCreatingDestinationPopupHandler) {
            ManageTransfersObserver._showCreatingDestinationPopupHandler();
        } else {
            console.error('Failed to open popup, because handler has not been set by CreateDestination module!');
        }
    }

    static setShowCreatingAirportPopupHandler(handler) {
        ManageTransfersObserver._showCreatingAirportPopupHandler = handler;
    }

    static setShowCreatingDestinationPopupHandler(handler) {
        ManageTransfersObserver._showCreatingDestinationPopupHandler = handler;
    }
}

export default ManageTransfersObserver;