import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import UpdateTourView from './UpdateTourView';
import UpdateTourModel from './UpdateTourModel';
import DateHelper from "../../helpers/DateHelper";

class UpdateTourController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.view = new UpdateTourView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.updateTourButton
        });
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
                    this.removeImageHandler(imageId)
                });
            }

            this.addEvent(item.querySelector('input[type="file"]'), 'change', e => {
                if (!confirm('You are sure?')) {
                    e.currentTarget.value = '';
                    return;
                }

                this.uploadImageHandler(e.currentTarget.files[0], imageId);
            });
        });
    }

    uploadImageHandler(file, imageReplace = null) {
        const formData = new FormData();
        formData.append('image', file);

        if (imageReplace) {
            formData.append('replace_image_id', imageReplace);
        }

        UpdateTourModel.uploadImage(UpdateTourController.getCurrentTourId(), formData)
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

    makeImageMainHandler(imageId) {
        if (!confirm('You are sure?')) {
            return;
        }

        const formData = new FormData();
        formData.append('image_id', imageId);

        UpdateTourModel.setMainImage(UpdateTourController.getCurrentTourId(), formData)
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
        if (!confirm('You are sure?')) {
            return;
        }

        const formData = new FormData();
        formData.append('image_id', imageId);

        UpdateTourModel.removeImage(UpdateTourController.getCurrentTourId(), formData)
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

    static getCurrentTourId() {
        return location.pathname.split('/')[location.pathname.split('/').length - 1];
    }

    updateTour(form) {
        this.view.showLoader();
        this.view.hideMessages();

        const formData = new FormData(form);

        if (this.datePicker.selectedDates[0]) {
            formData.append('date', DateHelper.format(this.datePicker.selectedDates[0]));
        } else {
            formData.delete('date');
        }

        UpdateTourModel.update(UpdateTourController.getCurrentTourId(), formData)
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
            .catch(error => alert(`Error: ${error}`));
    }
}

export default UpdateTourController;
