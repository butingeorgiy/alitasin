import UpdateSimpleEntityController from '../../extenders/controllers/UpdateSimpleEntityController';
import UpdateAirportView from './UpdateAirportView';
import ManageTransfersObserver from '../../observers/ManageTransfersObserver';
import ManageTransfersModel from '../manageTransfers/ManageTransfersModel';

class UpdateAirportController extends UpdateSimpleEntityController {
    constructor(nodes) {
        super(nodes);

        this.view = new UpdateAirportView({
            error: nodes.error,
            success: nodes.success,
            saveButton: nodes.saveButton
        });

        ManageTransfersObserver.setShowUpdatingAirportPopupHandler((data, id) => {
            this.removeAllListeners(nodes.saveButton, 'click');
            this.addEvent(nodes.saveButton, 'click', _ => {
                if (!this.loading) {
                    this.loading = false;
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
            alert('Failed to get airport ID! Please, try again...');
            location.reload();
            return;
        }

        ManageTransfersModel.updateAirport(this.getEntityCreatingData(), id)
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

export default UpdateAirportController;