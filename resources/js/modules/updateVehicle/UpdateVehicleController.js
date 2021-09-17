import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import CreateVehicleView from '../createVehicle/CreateVehicleView';
import JsonHelper from '../../helpers/JsonHelper';
import LocaleHelper from '../../helpers/LocaleHelper';
import OrderVehicleModel from '../orderVehicle/OrderVehicleModel';
import UpdateVehicleModel from './UpdateVehicleModel';
import UpdateTourModel from '../updateTour/UpdateTourModel';

class UpdateVehicleController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.loading = false;
        this.view = new CreateVehicleView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.updateVehicleButton,
            paramPopupError: nodes.paramPopup.querySelector('.error-message'),
            paramsContainer: nodes.paramsContainer
        });

        this.params = this.getInitParams();

        document.querySelectorAll('.dettach-param-button').forEach(buttonNode => {
            this.dettachParamHandler(buttonNode, buttonNode.getAttribute('data-id'));
        });

        document.querySelectorAll('.edit-param-button').forEach(buttonNode => {
            this.editParamHandler(buttonNode, JsonHelper.parse(buttonNode.getAttribute('data-param')));
        });

        this.addEvent(nodes.restoreButton, 'click', _ => {
            if (!confirm(LocaleHelper.translate('you-are-sure')) || this.loading) {
                return;
            }

            this.restore();
        });
    }

    static getCurrentVehicleId() {
        return location.pathname.split('/')[location.pathname.split('/').length - 1];
    }

    getInitParams() {
        let params = JsonHelper.parse(this.nodes.paramsContainer.getAttribute('data-params')),
            output = [];

        params.forEach(param => {
            output.push({
                id: param.id.toString(),
                name: param.name,
                en_value: param.en_value,
                ru_value: param.ru_value,
                tr_value: param.tr_value,
                ua_value: param.ua_value
            });
        });

        return output;
    }

    initImageBoxes(items) {
        items.forEach(item => {
            let imageId = null;
            imageId = item.getAttribute('data-image-id');

            if (imageId) {
                this.addEvent(item.querySelector('.make-image-main-button'), 'click', e => {
                    e.preventDefault();
                    this.makeImageMainHandler(imageId);
                });

                this.addEvent(item.querySelector('.remove-image-button'), 'click', e => {
                    e.preventDefault();
                    this.removeImageHandler(imageId);
                });
            }

            this.addEvent(item.querySelector('input[type="file"]'), 'change', e => {
                if (!confirm(LocaleHelper.translate('you-are-sure'))) {
                    e.currentTarget.value = '';
                    return;
                }

                this.uploadImageHandler(e.currentTarget.files[0], imageId);
            });
        });
    }

    restore() {
        OrderVehicleModel.restoreVehicle(UpdateVehicleController.getCurrentVehicleId())
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`)
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

    updateVehicle(form) {
        this.view.showLoader();
        this.view.hideMessages();

        const formData = new FormData(form);

        if (this.params.length > 0) {
            formData.append('params', JSON.stringify(this.params));
        }

        UpdateVehicleModel.update(UpdateVehicleController.getCurrentVehicleId(), formData)
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

    makeImageMainHandler(imageId) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        const formData = new FormData();
        formData.append('image_id', imageId);

        UpdateVehicleModel.setMainImage(UpdateVehicleController.getCurrentVehicleId(), formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`)
                } else if (result.error) {
                    alert(`Error: ${result.message}`)
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }

    removeImageHandler(imageId) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        const formData = new FormData();
        formData.append('image_id', imageId);

        UpdateVehicleModel.deleteImage(UpdateVehicleController.getCurrentVehicleId(), formData)
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
            .catch(error => alert(`Error: ${error}`));
    }

    uploadImageHandler(file, imageReplace = null) {
        const formData = new FormData();
        formData.append('image', file);

        if (imageReplace) {
            formData.append('replace_image_id', imageReplace);
        }

        UpdateVehicleModel.uploadImage(UpdateVehicleController.getCurrentVehicleId(), formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`)
                } else if (result.error) {
                    alert(`Error: ${result.message}`)
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }
}

export default UpdateVehicleController;
