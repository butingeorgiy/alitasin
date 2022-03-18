class OrderPropertyView {
    constructor(nodes) {
        this.buttonNode = nodes.buttonNode;
        this.errorNode = nodes.errorNode;
        this.successNode = nodes.successNode;
    }

    showButtonLoading() {
        this.buttonNode.classList.add('loading');
    }

    hideButtonLoading() {
        this.buttonNode.classList.remove('loading');
    }

    showError(msg) {
        this.errorNode.classList.remove('hidden');
        this.errorNode.innerText = msg;
    }

    hideError() {
        this.errorNode.classList.add('hidden');
        this.errorNode.innerText = '';
    }

    showSuccess(msg) {
        this.successNode.classList.remove('hidden');
        this.successNode.innerText = msg;
    }
}

export default OrderPropertyView;