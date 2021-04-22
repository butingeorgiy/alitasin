import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import UpdateTourView from './UpdateTourView';
import UpdateTourModel from './UpdateTourModel';
import LocaleHelper from "../../helpers/LocaleHelper";

class UpdateTourController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.loading = false;
        this.view = new UpdateTourView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.updateTourButton
        });

        this.initFiltersSelect('#editTourForm select[name="filters"]');
        this.initWeekDaysSelect('#editTourForm select[name="conduct_at"]');
        this.initAvailableTimeSelect('#editTourForm select[name="available_time"]');
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
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
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

        formData.append('filters', JSON.stringify(this.filtersSelect.getValue()));
        formData.append('conducted_at', JSON.stringify(this.weekDaysSelect.getValue()));
        formData.append('available_time', JSON.stringify(this.availableTimeSelect.getValue()));

        const durationInput = form.querySelector('input[name="duration"]');
        const durationSelect = form.querySelector('select[name="duration-mode"]');

        if (durationInput && durationSelect) {
            formData.append('duration', durationInput.value ? `${durationInput.value}~${durationSelect.value}` : '')
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
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }
}

export default UpdateTourController;
