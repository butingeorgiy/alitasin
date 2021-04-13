import CreateTourView from './CreateTourView';
import CreateTourModel from './CreateTourModel';
import DateHelper from '../../helpers/DateHelper';
import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';

class CreateTourController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.view = new CreateTourView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.saveTourButton
        });
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

        if (this.datePicker.selectedDates[0]) {
            formData.append('date', DateHelper.format(this.datePicker.selectedDates[0]));
        } else {
            formData.delete('date');
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
            .catch(error => alert(`Error: ${error}`));
    }
}

export default CreateTourController;
