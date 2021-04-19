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
            btn: nodes.saveTourButton
        });

        this.initFiltersSelect('#createTourForm select[name="filters"]');
        this.initWeekDaysSelect('#createTourForm select[name="conduct_at"]');
        this.initAvailableTimeSelect('#createTourForm select[name="available_time"]');
    }

    initImageBoxes(items) {
        items.forEach(item => {
            const fileInput = item.querySelector('input[type="file"]');

            this.addEvent(fileInput, 'change', e => {
                const file = e.target.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = f => CreateTourView.renderImage(item, f.target.result);
                    reader.readAsDataURL(file);

                    this.addEvent(item.querySelector('.remove-image-button'), 'click', e => {
                        e.preventDefault();
                        this.dropImage(item);
                    });
                }
            });
        });
    }

    dropImage(item) {
        CreateTourView.removeImage(item);
        item.querySelector('input[type="file"]').value = '';

        this.removeAllListeners(item.querySelector('.remove-image-button'), 'click');
    }

    saveTour(form) {
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
