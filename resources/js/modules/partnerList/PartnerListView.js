class PartnerListView {
    constructor(nodes) {
        this.paymentPopupButtonNode = nodes.paymentPopupButtonNode;
        this.paymentPopupErrorNode = nodes.paymentPopupErrorNode;
        this.paymentPopupSuccessNode = nodes.paymentPopupSuccessNode;
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
}

export default PartnerListView;
