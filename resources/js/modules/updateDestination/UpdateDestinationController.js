import UpdateSimpleEntityController from '../../extenders/controllers/UpdateSimpleEntityController';
import UpdateDestinationView from './UpdateDestinationView';
import ManageTransfersModel from '../manageTransfers/ManageTransfersModel';
import ManageTransfersObserver from '../../observers/ManageTransfersObserver';

class UpdateDestinationController extends UpdateSimpleEntityController {
    constructor(nodes) {
        super(nodes);

        this.view = new UpdateDestinationView({
            error: nodes.error,
            success: nodes.success,
            saveButton: nodes.saveButton
        });

        ManageTransfersObserver.setShowUpdatingDestinationPopupHandler((data, id) => {
            this.removeAllListeners(nodes.saveButton, 'click');
            this.addEvent(nodes.saveButton, 'click', _ => {
                if (!this.loading) {
                    this.loading = true;
                    this.update();
                }
            });

            this.openPopup(data, id);
        });
    }

    update() {
        this.view.showLoading();
        this.view.hideError();

        const id = this.getId();

        if (!id) {
            alert('Failed to get destination ID! Please, try again...');
            location.reload();
            return;
        }

        ManageTransfersModel.updateDestination(this.getEntityCreatingData(), id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    this.loading = false;
                } else if (result.error) {
                    this.view.showError(result.message);
                    this.loading = false;
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => location.reload(), 1500);
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
                this.loading = false;
            })
            .finally(_ => {
                this.view.hideLoading();
            });
    }
}

export default UpdateDestinationController;