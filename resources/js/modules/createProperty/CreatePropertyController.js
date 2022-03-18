import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import CreatePropertyView from './CreatePropertyView';
import CreatePropertyModel from './CreatePropertyModel';

class CreatePropertyController extends TourFormBaseController {
    constructor(nodes) {
        super(nodes);

        this.loading = false;
        this.view = new CreatePropertyView({
            error: nodes.error,
            success: nodes.success,
            btn: nodes.savePropertyButton,
            paramPopupError: nodes.paramPopup.querySelector('.error-message'),
            paramsContainer: nodes.paramsContainer
        });
    }

    saveProperty(form) {
        this.view.showLoader();
        this.view.hideMessages();

        const formData = new FormData(form);

        if (this.params.length > 0) {
            formData.append('params', JSON.stringify(this.params));
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

        CreatePropertyModel.create(formData)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    this.view.hideLoader();
                } else if (result.error) {
                    this.view.showError(result.message);
                    this.view.hideLoader();
                } else {
                    this.view.showSuccess(result.message);
                    setTimeout(_ => {
                        location.reload();
                    }, 500);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.loading = false;
            });
    }
}

export default CreatePropertyController;