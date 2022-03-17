class TransferFormView {
    constructor(nodes) {
        this.calculateButton = nodes.calculateButton;
        this.error = nodes.error;
        this.costWrapper = nodes.costWrapper;
        this.cost = nodes.cost;
    }

    showLoading() {
        this.calculateButton.classList.add('loading');
    }

    hideLoading() {
        this.calculateButton.classList.remove('loading');
    }

    showErrorMessage(msg) {
        this.error.classList.remove('hidden');
        this.error.querySelector('span').innerText = msg;
    }

    hideErrorMessage() {
        this.error.classList.add('hidden');
    }

    showTransferCost(value) {
        this.costWrapper.classList.remove('hidden');
        this.cost.innerText = value;
    }

    hideTransferCost() {
        this.costWrapper.classList.add('hidden');
    }

    showCalculateButton() {
        this.calculateButton.classList.remove('hidden');
    }

    hideCalculateButton() {
        this.calculateButton.classList.add('hidden');
    }
}

export default TransferFormView;