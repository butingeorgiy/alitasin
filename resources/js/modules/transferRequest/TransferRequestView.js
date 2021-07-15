class TransferRequestView {
    constructor(nodes) {
        this.success = nodes.successMessage;
        this.error = nodes.errorMessage;
        this.orderButton = nodes.transferOrderButton;
        this.showPopupButton = nodes.showPopupButton;
    }

    renderShowPopupButton() {
        this.showPopupButton.classList.remove('hidden');
    }

    hideShowPopupButton() {
        this.showPopupButton.classList.add('hidden');
    };
}

export default TransferRequestView;