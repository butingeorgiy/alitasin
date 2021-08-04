import CreateSimpleEntityController from '../../extenders/controllers/CreateSimpleEntityController';
import CreateDestinationView from './CreateDestinationView';
import CreateDestinationModel from './CreateDestinationModel';
import ManageTransfersObserver from '../../observers/ManageTransfersObserver';

class CreateDestinationController extends CreateSimpleEntityController {
    constructor(nodes) {
        super(nodes);

        this.view = new CreateDestinationView({
            error: nodes.error,
            success: nodes.success,
            saveButton: nodes.saveButton
        });

        ManageTransfersObserver.setShowCreatingDestinationPopupHandler(_ => {
            this.openPopup();
        });
    }

    save() {
        this.view.showLoading();
        this.view.hideError();

        CreateDestinationModel.create(this.getEntityCreatingData())
            .then(result => {
                if (typeof result === 'string') {
                    this.loading = false;
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.loading = false;
                    this.view.showError(result.message);
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => location.reload(), 1500);
                }
            })
            .catch(error => {
                this.loading = false;
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.view.hideLoading();
            });
    }
}

export default CreateDestinationController;