import LocaleHelper from '../../helpers/LocaleHelper';

class TransferRequestView {
    constructor(nodes) {
        this.success = nodes.successMessage;
        this.error = nodes.errorMessage;
        this.orderButton = nodes.transferOrderButton;
        this.showPopupButton = nodes.showPopupButton;
        this.promoCodeWrapper = nodes.promoCodeWrapper;
        this.oldPrice = nodes.oldPrice;
        this.totalPrice = nodes.totalPrice;
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

    enablePromoCode(salePercent) {
        this.promoCodeWrapper.querySelector('input').setAttribute('readonly', true);
        this.promoCodeWrapper.querySelector('input').classList.add('cursor-not-allowed');
        this.promoCodeWrapper.querySelector('.check-promo-code-button').classList.add('hidden');
        this.promoCodeWrapper.querySelector('.reset-button').classList.remove('hidden');
        this.promoCodeWrapper.querySelector('.active').classList.remove('hidden');
        this.promoCodeWrapper.querySelector('.active').innerText = `${LocaleHelper.translate('activated')} (-${salePercent}%)`;
    }

    disablePromoCode() {
        this.promoCodeWrapper.querySelector('input').removeAttribute('readonly');
        this.promoCodeWrapper.querySelector('input').classList.remove('cursor-not-allowed');
        this.promoCodeWrapper.querySelector('input').value = '';
        this.promoCodeWrapper.querySelector('.check-promo-code-button').classList.remove('hidden');
        this.promoCodeWrapper.querySelector('.reset-button').classList.add('hidden');
        this.promoCodeWrapper.querySelector('.active').classList.add('hidden');
        this.promoCodeWrapper.querySelector('.active').innerText = '';
    }

    renderTransferTotalPrice(totalPrice, oldPrice = null) {
        this.totalPrice.innerText = `$ ${totalPrice}`;

        if (oldPrice) {
            this.oldPrice.classList.remove('hidden');
            this.oldPrice.innerText = `$ ${oldPrice}`;
        } else {
            this.oldPrice.classList.add('hidden');
            this.oldPrice.innerText = '';
        }
    }

    clearForm() {
        this.disablePromoCode();
        this.hideError();
    }
}

export default TransferRequestView;