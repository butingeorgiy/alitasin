import TourFormBaseController from '../../extenders/controllers/TourFormBaseController';
import CreateVehicleView from '../createVehicle/CreateVehicleView';
import JsonHelper from '../../helpers/JsonHelper';

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
}

export default UpdateVehicleController;
