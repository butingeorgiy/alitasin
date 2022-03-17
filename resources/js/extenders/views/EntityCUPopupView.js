class EntityCUPopupView {
    constructor(nodes) {
        this.error = nodes.error;
        this.success = nodes.success;
        this.saveButton = nodes.saveButton;
    }

    showLoading() {
        this.saveButton.classList.add('loading');
    }

    hideLoading() {
        this.saveButton.classList.remove('loading');
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
}

export default EntityCUPopupView;