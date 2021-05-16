import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import CreateVehicleView from './CreateVehicleView';

class CreateVehicleController extends TourFormBaseController {
    constructor(nodes) {
        super();

        this.loading = false;
        this.view = new CreateVehicleView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.saveTourButton,
            additionPopupError: nodes.additionPopup.querySelector('.error-message'),
            includesAdditionsContainer: nodes.includesAdditionsContainer,
            notIncludesAdditionsContainer: nodes.notIncludesAdditionsContainer
        });
    }

    initImageBoxes(items) {
        items.forEach(item => {
            const fileInput = item.querySelector('input[type="file"]');

            this.addEvent(fileInput, 'change', e => {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = f => CreateVehicleView.renderImage(item, f.target.result);
                    reader.readAsDataURL(file);

                    this.addEvent(item.querySelector('.remove-image-button'), 'click', e => {
                        e.preventDefault();
                        this.dropImage(item);
                    });
                }
            });
        });
    }

    dropImage(item) {
        CreateVehicleView.removeImage(item);
        item.querySelector('input[type="file"]').value = '';

        this.removeAllListeners(item.querySelector('.remove-image-button'), 'click');
    }

    saveVehicle(form) {

    }
}

export default CreateVehicleController;
