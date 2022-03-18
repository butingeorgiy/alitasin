import CreateTourView from './CreateTourView';
import CreateTourModel from './CreateTourModel';
import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';

class CreateTourController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.loading = false;
        this.view = new CreateTourView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.saveTourButton,
            additionPopupError: nodes.additionPopup.querySelector('.error-message'),
            includesAdditionsContainer: nodes.includesAdditionsContainer,
            notIncludesAdditionsContainer: nodes.notIncludesAdditionsContainer
        });

        this.initFiltersSelect('#createTourForm select[name="filters"]');
        this.initWeekDaysSelect('#createTourForm select[name="conduct_at"]');
    }

    saveTour(form) {
        this.view.showLoader();
        this.view.hideMessages();

        const formData = new FormData(form);

        formData.append('filters', JSON.stringify(this.filtersSelect.getValue()));
        formData.append('conducted_at', JSON.stringify(this.weekDaysSelect.getValue()));

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

        const durationInput = form.querySelector('input[name="duration"]');
        const durationSelect = form.querySelector('select[name="duration-mode"]');

        if (durationInput && durationSelect) {
            formData.append('duration', durationInput.value ? `${durationInput.value}~${durationSelect.value}` : '');
        }

        CreateTourModel.create(formData)
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

export default CreateTourController;
