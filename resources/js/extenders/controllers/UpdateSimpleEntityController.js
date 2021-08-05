import EventHandler from '../../core/EventHandler';
import PopupObserver from '../../observers/PopupObserver';

class UpdateSimpleEntityController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;

        this.initPopup();
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup, false, _ => {
            this.clearForm();
            this.nodes.saveButton.removeAttribute('data-id');
        });
    }

    openPopup(data, id) {
        this.popup.open(_ => {
            this.setId(id);
            this.fillForm(data);
        });
    }

    clearForm() {
        this.nodes.popup.querySelectorAll('input').forEach(input => {
            input.value = '';
        });
    }

    fillForm(data) {
        Object.entries(data).forEach(([key, value = null]) => {
            const input = this.nodes.popup.querySelector(`input[name="${key}"]`);

            if (input) {
                input.value = value;
            }
        });
    }

    setId(id) {
        this.nodes.saveButton.setAttribute('data-id', id);
    }

    getId() {
        return this.nodes.saveButton.getAttribute('data-id');
    }

    getEntityCreatingData() {
        const formData = new FormData();

        this.nodes.popup.querySelectorAll('input').forEach(input => {
            if (input.value) {
                formData.append(input.getAttribute('name'), input.value);
            }
        });

        return formData;
    }
}

export default UpdateSimpleEntityController;