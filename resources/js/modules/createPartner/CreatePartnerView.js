class CreatePartnerView {
    constructor(nodes) {
        this.buttonNode = nodes.buttonNode;
        this.errorNode = nodes.errorNode;
        this.successNode = nodes.successNode;
    }

    showLoading() {
        this.buttonNode.classList.add('loading');
    }

    hideLoading() {
        this.buttonNode.classList.remove('loading');
    }

    showError(msg) {
        this.errorNode.classList.remove('hidden');
        this.errorNode.querySelector('span').innerText = msg;
    }

    hideError() {
        this.errorNode.classList.add('hidden');
    }

    showSuccess(msg) {
        this.successNode.classList.remove('hidden');
        this.successNode.querySelector('span').innerText = msg;
    }
}

export default CreatePartnerView;
