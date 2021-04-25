class ReservationListView {
    constructor(nodes) {
        this.updateStatusError = nodes.updateStatusError;
        this.updateStatusSuccess = nodes.updateStatusSuccess;
        this.updateStatusButton = nodes.updateStatusButton;
        this.statusSelect = nodes.statusSelect;
    }

    showUpdateStatusSuccess(msg) {
        this.updateStatusSuccess.classList.remove('hidden');
        this.updateStatusSuccess.querySelector('span').innerText = msg;
    }

    showUpdateStatusError(msg) {
        this.updateStatusError.classList.remove('hidden');
        this.updateStatusError.querySelector('span').innerText = msg;
    }

    hideUpdateStatusMessages() {
        this.updateStatusSuccess.classList.add('hidden');
        this.updateStatusSuccess.querySelector('span').innerText = '';

        this.updateStatusError.classList.add('hidden');
        this.updateStatusError.querySelector('span').innerText = '';
    }

    setDisabledUpdateStatusButton() {
        this.updateStatusButton.classList.add('disabled');
    }

    setLoadingUpdateStatusButton() {
        this.updateStatusButton.classList.add('loading');
    }

    setEnabledUpdateStatusButton() {
        this.updateStatusButton.classList.remove('disabled');
        this.updateStatusButton.classList.remove('loading');
    }

    disableUpdateStatusSelect() {
        this.statusSelect.setAttribute('disabled', 'disabled');
    }

    enableUpdateStatusSelect() {
        this.statusSelect.removeAttribute('disabled');
    }
}

export default ReservationListView;
