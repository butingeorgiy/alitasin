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

    showLoading() {
        this.orderButton.classList.add('loading');
    }

    hideLoading() {
        this.orderButton.classList.remove('loading');
    }

    showError(msg) {
        this.error.classList.remove('hidden');
        this.error.querySelector('span').innerHTML = msg;
    }

    hideError() {
        this.error.classList.add('hidden');
    }

    showSuccess(msg) {
        this.success.classList.remove('hidden');
        this.success.querySelector('span').innerText = msg;
    }
}

export default TransferRequestView;