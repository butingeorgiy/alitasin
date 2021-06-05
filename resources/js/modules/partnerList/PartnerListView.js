class PartnerListView {
    constructor(nodes) {
        this.paymentPopupButtonNode = nodes.paymentPopupButtonNode;
        this.paymentPopupErrorNode = nodes.paymentPopupErrorNode;
        this.paymentPopupSuccessNode = nodes.paymentPopupSuccessNode;

        this.updatePercentPopupButtonNode = nodes.updatePercentPopupButtonNode;
        this.updatePercentPopupErrorNode = nodes.updatePercentPopupErrorNode;
        this.updatePercentPopupSuccessNode = nodes.updatePercentPopupSuccessNode;
    }

    showPaymentPopupLoading() {
        this.paymentPopupButtonNode.classList.add('loading');
    }

    hidePaymentPopupLoading() {
        this.paymentPopupButtonNode.classList.remove('loading');
    }

    showPaymentPopupError(msg) {
        this.paymentPopupErrorNode.classList.remove('hidden');
        this.paymentPopupErrorNode.querySelector('span').innerText = msg;
    }

    hidePaymentPopupError() {
        this.paymentPopupErrorNode.classList.add('hidden');
        this.paymentPopupErrorNode.querySelector('span').innerText = '';
    }

    showPaymentPopupSuccess(msg) {
        this.paymentPopupSuccessNode.classList.remove('hidden');
        this.paymentPopupSuccessNode.querySelector('span').innerText = msg;
    }

    showUpdatePercentPopupLoading() {
        this.updatePercentPopupButtonNode.classList.add('loading');
    }

    hideUpdatePercentPopupLoading() {
        this.updatePercentPopupButtonNode.classList.remove('loading');
    }

    showUpdatePercentPopupError(msg) {
        this.updatePercentPopupErrorNode.classList.remove('hidden');
        this.updatePercentPopupErrorNode.querySelector('span').innerText = msg;
    }

    hideUpdatePercentPopupError() {
        this.updatePercentPopupErrorNode.classList.add('hidden');
        this.updatePercentPopupErrorNode.querySelector('span').innerText = '';
    }

    showUpdatePercentPopupSuccess(msg) {
        this.updatePercentPopupSuccessNode.classList.remove('hidden');
        this.updatePercentPopupSuccessNode.innerText = msg;
    }
}

export default PartnerListView;
