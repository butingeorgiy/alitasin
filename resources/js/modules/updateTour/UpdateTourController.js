import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import UpdateTourView from './UpdateTourView';
import UpdateTourModel from './UpdateTourModel';
import LocaleHelper from '../../helpers/LocaleHelper';
import JsonHelper from '../../helpers/JsonHelper';

class UpdateTourController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.loading = false;
        this.view = new UpdateTourView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.updateTourButton,
            additionPopupError: nodes.additionPopup.querySelector('.error-message'),
            includesAdditionsContainer: nodes.includesAdditionsContainer,
            notIncludesAdditionsContainer: nodes.notIncludesAdditionsContainer
        });

        this.additions = this.getInitAdditions();

        this.initFiltersSelect('#editTourForm select[name="filters"]');
        this.initWeekDaysSelect('#editTourForm select[name="conduct_at"]');

        document.querySelectorAll('.dettach-addition-button').forEach(buttonNode => {
            this.dettachAdditionHandler(buttonNode, buttonNode.getAttribute('data-id'));
        });

        document.querySelectorAll('.edit-addition-button').forEach(buttonNode => {
            this.editAdditionHandler(buttonNode, JsonHelper.parse(buttonNode.getAttribute('data-addition')));
        });
    }

    getInitAdditions() {
        let additions = JsonHelper.parse(this.nodes.includesAdditionsContainer.getAttribute('data-additions')),
            output = [];

        console.log(additions);

        additions['0']?.forEach(addition => {
            output.push({
                id: addition.id.toString(),
                title: addition.title,
                en_description: addition.en_description,
                ru_description: addition.ru_description,
                tr_description: addition.tr_description,
                ua_description: addition.ua_description,
                is_include: '0'
            });
        });

        additions['1']?.forEach(addition => {
            output.push({
                id: addition.id.toString(),
                title: addition.title,
                en_description: addition.en_description,
                ru_description: addition.ru_description,
                tr_description: addition.tr_description,
                ua_description: addition.ua_description,
                is_include: '1'
            });
        });

        console.log(output);

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

        const durationInput = form.querySelector('input[name="duration"]');
        const durationSelect = form.querySelector('select[name="duration-mode"]');

        if (durationInput && durationSelect) {
            formData.append('duration', durationInput.value ? `${durationInput.value}~${durationSelect.value}` : '')
        }

        if (this.additions.length > 0) {
            formData.append('additions', JSON.stringify(this.additions));
        }

        if (this.enDescriptionEditor) {
            formData.append('en_description', this.enDescriptionEditor.getData());
        }

        if (this.ruDescriptionEditor) {
            formData.append('ru_description', this.ruDescriptionEditor.getData());
        }

        if (this.trDescriptionEditor) {
            formData.append('tr_description', this.trDescriptionEditor.getData());
        }

        if (this.uaDescriptionEditor) {
            formData.append('ua_description', this.uaDescriptionEditor.getData());
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
