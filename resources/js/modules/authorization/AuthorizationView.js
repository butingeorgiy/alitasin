class AuthorizationView {
    constructor(nodes) {
        this.error = nodes.error;
        this.btn = nodes.btn;
    }

    showError(msg) {
        this.error.classList.remove('hidden');
        this.error.querySelector('span').innerText = msg;
    }

    hideError() {
        this.error.classList.add('hidden');
    }

    showLoader() {
        this.btn.classList.add('loading');
    }

    hideLoader() {
        this.btn.classList.remove('loading');
    }
}

export default AuthorizationView;
