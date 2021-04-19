class UpdateProfileInfoView {
    constructor(nodes) {
        this.btn = nodes.btn;
        this.error = nodes.error;
        this.success = nodes.success;
    }

    showLoading() {
        this.btn.classList.add('loading');
    }

    hideLoading() {
        this.btn.classList.remove('loading');
    }

    showError(msg) {
        this.error.classList.remove('hidden');
        this.error.innerText = msg;
    }

    hideError() {
        this.error.classList.add('hidden');
        this.error.innerText = '';
    }

    showSuccess(msg) {
        this.success.classList.remove('hidden');
        this.success.innerText = msg;
    }

    enableButton() {
        this.btn.classList.remove('disabled');
    }

    disableButton() {
        this.btn.classList.add('disabled');
    }

    removeButton() {
        this.btn.remove;
    }
}

export default UpdateProfileInfoView;
