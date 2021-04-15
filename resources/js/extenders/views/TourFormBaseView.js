class TourFormBaseView {
    constructor(nodes) {
        this.error = nodes.error;
        this.success = nodes.success;
        this.btn = nodes.btn;
    }

    static renderImage(node, image) {
        node.classList.add('filled')
        node.style.backgroundImage = `url(${image})`;
    }

    static removeImage(node) {
        node.classList.remove('filled');
        node.style.backgroundImage = '';
    }

    hideMessages() {
        this.error.classList.add('hidden');
        this.success.classList.add('hidden');
    }

    showError(msg) {
        document.body.classList.add('shake');

        setTimeout(_ => {
            document.body.classList.remove('shake');
        }, 200);

        this.error.classList.remove('hidden');
        this.error.querySelector('span').innerText = msg;
    }

    showSuccess(msg) {
        this.success.classList.remove('hidden');
        this.success.querySelector('span').innerText = msg;
    }

    showLoader() {
        this.btn.classList.add('loading');
    }

    hideLoader() {
        this.btn.classList.remove('loading');
    }
}

export default TourFormBaseView;
