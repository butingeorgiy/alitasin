import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import CreateVehicleView from './CreateVehicleView';
import CreateVehicleModel from './CreateVehicleModel';

class CreateVehicleController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.loading = false;
        this.view = new CreateVehicleView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.saveVehicleButton,
            paramPopupError: nodes.paramPopup.querySelector('.error-message'),
            paramsContainer: nodes.paramsContainer
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
        this.view.showLoader();
        this.view.hideMessages();

        const formData = new FormData(form);

        if (this.params.length > 0) {
            formData.append('params', JSON.stringify(this.params));
        }

        CreateVehicleModel.create(formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`)
                    this.view.hideLoader();
                } else if (result.error) {
                    this.view.showError(result.message);
                    this.view.hideLoader();
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => {
                        location.reload();
                    }, 500)
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }
}

export default CreateVehicleController;
