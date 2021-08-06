import EventHandler from '../../core/EventHandler';
import ManageTransferVariationsView from './ManageTransferVariationsView';
import ManageTransferVariationsModel from './ManageTransferVariationsModel';
import ManageTransfersObserver from '../../observers/ManageTransfersObserver';
import LocaleHelper from '../../helpers/LocaleHelper';

class ManageTransferVariationsController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.loading = false;
        this.transferId = null;

        this.view = new ManageTransferVariationsView({
            container: nodes.container,
            variationsWrapper: nodes.variationsWrapper,
            variationsContainer: nodes.variationsContainer,
            loader: nodes.loader,
            createTransferButton: nodes.createTransferButton,
            deleteTransferButton: nodes.deleteTransferButton
        });

        this.saveCost = this.saveCost.bind(this);
        this.deleteCost = this.deleteCost.bind(this);

        ManageTransfersObserver.setResolveTransferHandler(async (airportId, destinationId) => {
            await this.resolveTransfer(airportId, destinationId);
        });

        ManageTransfersObserver.setHideTransferVariationsHandler(_ => {
            this.view.hideContainer();
        });
    }

    async resolveTransfer(airportId, destinationId) {
        this.loading = true;

        this.view.showLoader();
        this.view.hideContainer();
        this.view.hideVariationsWrapper();

        this.removeAllListeners(this.nodes.createTransferButton, 'click');
        this.removeAllListeners(this.nodes.deleteTransferButton, 'click');

        const isExistsResponse = await ManageTransferVariationsModel.checkTransfer(airportId, destinationId);

        if (isExistsResponse['result'] === false) {
            this.view.toggleManageButtons('create');

            this.addEvent(this.nodes.createTransferButton, 'click', _ => {
                if (!this.loading) {
                    this.loading = true;
                    this.createTransfer(airportId, destinationId);
                }
            });
        } else {
            this.view.toggleManageButtons('delete');
            this.transferId = parseInt(isExistsResponse['transfer_id']);

            this.addEvent(this.nodes.deleteTransferButton, 'click', _ => {
                if (!this.loading) {
                    this.loading = true;
                    this.deleteTransfer(this.transferId);
                }
            });

            const variationsResponse = await ManageTransferVariationsModel.getAvailableVariations(airportId, destinationId);

            if (typeof variationsResponse === 'string') {
                alert(`Error: ${variationsResponse}`);
            } else if (variationsResponse.error) {
                alert(`Error: ${variationsResponse.message}`);
            } else {
                this.view.clearVariations();
                this.view.renderVariations(variationsResponse['variations'], this.saveCost, this.deleteCost);
                this.view.showVariationsWrapper();
            }
        }

        this.view.showContainer();
        this.view.hideLoader();
        this.loading = false;
    }

    saveCost(typeId, capacityId, cost) {
        if (this.loading) {
            return;
        }

        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            this.loading = false;
            return;
        }

        this.loading = true;
        const formData = new FormData();

        formData.append('type_id', typeId);
        formData.append('capacity_id', capacityId);
        formData.append('cost', cost);

        ManageTransferVariationsModel.updateVariation(formData, this.transferId)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }

    deleteCost(typeId, capacityId, clearInputAfterDeleting) {
        if (this.loading) {
            return;
        }

        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            this.loading = false;
            return;
        }

        this.loading = true;
        const formData = new FormData();

        formData.append('type_id', typeId);
        formData.append('capacity_id', capacityId);

        ManageTransferVariationsModel.deleteVariation(formData, this.transferId)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    clearInputAfterDeleting();
                    alert(result.message);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }

    createTransfer(airportId, destinationId) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            this.loading = false;
            return;
        }

        const formData = new FormData();

        formData.append('airport_id', airportId);
        formData.append('destination_id', destinationId);

        ManageTransferVariationsModel.createTransfer(formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }

    deleteTransfer(transferId) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            this.loading = false;
            return;
        }

        ManageTransferVariationsModel.deleteTransfer(transferId)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }
}

export default ManageTransferVariationsController;