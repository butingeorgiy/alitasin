import LocaleHelper from '../../helpers/LocaleHelper';

class BookTourView {
    constructor(nodes) {
        this.totalCost = nodes.totalCostNode;
        this.promoCodeInput = nodes.promoCodeInput;
        this.promoCodeActiveStatus = nodes.promoCodeContainer.querySelector('.active');
        this.promoCodeCheckButton = nodes.checkPromoCodeButton;
        this.promoCodeResetButton = nodes.resetPromoCodeButton;
        this.error = nodes.error;
        this.success = nodes.success;
        this.reserveTourButton = nodes.reserveTourButton;
    }

    static enableTicketAmountChangeButton(node) {
        node.classList.remove('opacity-50', 'cursor-not-allowed');
    }

    static disableTicketAmountChangeButton(node) {
        node.classList.add('opacity-50', 'cursor-not-allowed');
    }

    renderFormChanges(data, totalCost) {
        this.totalCost.innerText = totalCost;

        data.forEach(item => {
            item.amountNode.innerText = item.amount;
        });
    }

    setPromoCodeActiveStatus(salePercent) {
        this.promoCodeInput.setAttribute('readonly', 'readonly');
        this.promoCodeInput.classList.add('cursor-not-allowed');
        this.promoCodeCheckButton.classList.add('hidden');
        this.promoCodeActiveStatus.classList.remove('hidden');
        this.promoCodeActiveStatus.innerText = `${LocaleHelper.translate('activated')} (-${salePercent}%)`;
        this.promoCodeResetButton.classList.remove('hidden');
    }

    removePromoCodeActiveStatus() {
        this.promoCodeInput.removeAttribute('readonly');
        this.promoCodeInput.classList.remove('cursor-not-allowed');
        this.promoCodeInput.value = '';
        this.promoCodeCheckButton.classList.remove('hidden');
        this.promoCodeActiveStatus.classList.add('hidden');
        this.promoCodeActiveStatus.innerText = '';
        this.promoCodeResetButton.classList.add('hidden');
    }

    showError(msg) {
        this.error.classList.remove('hidden');
        this.error.querySelector('span').innerText = msg;
    }

    hideError() {
        this.error.classList.add('hidden');
        this.error.querySelector('span').innerText = '';
    }

    showSuccess(msg) {
        this.success.classList.remove('hidden');
        this.success.querySelector('span').innerText = msg;
    }

    showLoading() {
        this.reserveTourButton.classList.add('loading');
    }

    hideLoading() {
        this.reserveTourButton.classList.remove('loading');
    }

    disableReserveButton() {
        this.reserveTourButton.classList.add('disabled');
    }
}

export default BookTourView;
