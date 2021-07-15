class TransferRequestObserver {
    static setState(transferState) {
        this.transferState = transferState;
    }

    static getState() {
        if (this.transferState) {
            return this.transferState;
        }

        console.warn('Transfer State was not set by TransferForm module!');
        return null;
    }

    static clearState() {
        this.transferState = null;
    }

    static setRenderShowTransferRequestPopupButtonHandler(handler) {
        this.showTransferRequestPopupHandler = handler;
    }

    static renderShowTransferRequestPopupButton(onSuccess = null, onError = null) {
        if (!this.showTransferRequestPopupHandler) {
            console.warn('showTransferRequestPopupHandler was not set by TransferRequest module!');

            if (onError) {
                onError();
            }

            return;
        }

        this.showTransferRequestPopupHandler();

        if (onSuccess) {
            onSuccess();
        }
    }
}

export default TransferRequestObserver;