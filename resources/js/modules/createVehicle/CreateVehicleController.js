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
                    alert(`Error: ${result}`);
                    this.view.hideLoader();
                } else if (result.error) {
                    this.view.showError(result.message);
                    this.view.hideLoader();
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => {
                        location.reload();
                    }, 500);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }
}

export default CreateVehicleController;
