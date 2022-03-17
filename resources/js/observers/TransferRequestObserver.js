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

    static setCost(cost) {
        this.transferCost = cost;
    }

    static getCost() {
        if (!this.transferCost) {
            console.warn('Transfer cost was not set by Transfer Form module!');
            return null;
        }

        return this.transferCost;
    }

    static clearCost() {
        this.transferCost = null;
    }

    static setRenderShowTransferRequestPopupButtonHandler(handler) {
        this.showTransferRequestPopupButtonHandler = handler;
    }

    static setHideShowTransferRequestPopupButtonHandler(handler) {
        this.hideTransferRequestPopupButtonHandler = handler;
    }

    static renderShowTransferRequestPopupButton(onSuccess = null, onError = null) {
        if (!this.showTransferRequestPopupButtonHandler) {
            console.warn('showTransferRequestPopupHandler was not set by TransferRequest module!');

            if (onError) {
                onError();
            }

            return;
        }

        this.showTransferRequestPopupButtonHandler();

        if (onSuccess) {
            onSuccess();
        }
    }

    static hideShowTransferRequestPopupButton(onSuccess = null, onError = null) {
        if (!this.hideTransferRequestPopupButtonHandler) {
            console.warn('hideTransferRequestPopupButtonHandler was not set by TransferRequest module!');

            if (onError) {
                onError();
            }

            return;
        }

        this.hideTransferRequestPopupButtonHandler();

        if (onSuccess) {
            onSuccess();
        }
    }
}

export default TransferRequestObserver;