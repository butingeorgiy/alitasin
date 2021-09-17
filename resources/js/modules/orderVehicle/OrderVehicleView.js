import LocaleHelper from '../../helpers/LocaleHelper';

class OrderVehicleView {
    constructor(nodes) {
        this.buttonNode = nodes.buttonNode;
        this.errorNode = nodes.errorNode;
        this.successNode = nodes.successNode;
        this.promoCodeWrapper = nodes.promoCodeWrapper;
        this.oldPrice = nodes.oldPrice;
        this.totalPrice = nodes.totalPrice;
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
}

export default OrderVehicleView;
