class PartnerRegistrationView {
    constructor(nodes) {
        this.buttonNode = nodes.buttonNode;
        this.errorNode = nodes.errorNode;
    }

    showError(msg) {
        this.errorNode.classList.remove('hidden');
        this.errorNode.innerText = msg;
    }

    hideError() {
        this.errorNode.classList.add('hidden');
        this.errorNode.innerText = '';
    }

    showButtonLoading() {
        this.buttonNode.classList.add('loading');
    }

    hideButtonLoading() {
        this.buttonNode.classList.remove('loading');
    }
}

export default PartnerRegistrationView;