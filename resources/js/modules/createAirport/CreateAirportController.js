import CreateAirportView from './CreateAirportView';
import CreateAirportModel from './CreateAirportModel';
import CreateSimpleEntityController from '../../extenders/controllers/CreateSimpleEntityController';
import ManageTransfersObserver from '../../observers/ManageTransfersObserver';

class CreateAirportController extends CreateSimpleEntityController {
    constructor(nodes) {
        super(nodes);

        this.view = new CreateAirportView({
            error: nodes.error,
            success: nodes.success,
            saveButton: nodes.saveButton
        });

        ManageTransfersObserver.setShowCreatingAirportPopupHandler(_ => {
            this.openPopup();
        });
    }

    save() {
        this.view.showLoading();
        this.view.hideError();

        CreateAirportModel.create(this.getEntityCreatingData())
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

export default CreateAirportController;