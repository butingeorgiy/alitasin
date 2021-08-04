import EventHandler from '../../core/EventHandler';
import PopupObserver from '../../observers/PopupObserver';

class CreateSimpleEntityController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;

        this.addEvent(nodes.saveButton, 'click', _ => {
            if (!this.loading) {
                this.loading = true;
                this.save();
            }
        });

        this.initPopup();
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.popup);
    }

    openPopup() {
        this.popup.open();
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

export default CreateSimpleEntityController;