import EventHandler from '../../core/EventHandler';
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import LocaleHelper from '../../helpers/LocaleHelper';
import PopupObserver from '../../observers/PopupObserver';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

class TourFormBaseController extends EventHandler {
    constructor(nodes) {
        super();
        this.nodes = nodes;

        if (nodes?.additionPopup) {
            this.nodes.attachAdditionButton = nodes.additionPopup.querySelector('.save-addition-button');
        }

        if (nodes?.paramPopup) {
            this.nodes.attachParameterButton = nodes.paramPopup.querySelector('.save-parameter-button');
        }

        this.additions = [];
        this.params = [];

        if (/(admin\/tours\/create)|(admin\/tours\/update\/\d+)/.test(location.pathname)) {
            this.initDescriptionEditors();
        }

        if (this.nodes?.attachAdditionButton) {
            this.initAdditionPopup();

            this.nodes.openAdditionPopupButtons.forEach(buttonNode => {
                this.addEvent(buttonNode, 'click', _ => {
                    this.additionPopup.open(_ => this.beforeAdditionPopupOpenHandler(buttonNode.getAttribute('data-is-include')));
                });
            });
        }

        if (this.nodes?.attachParameterButton) {
            this.initParamsPopup();

            this.addEvent(this.nodes.openParamPopupButton, 'click', _ => {
                this.paramPopup.open(_ => this.beforeParamPopupOpenHandler());
            });
        }
    }

    initDescriptionEditors() {
        ClassicEditor
            .create(document.querySelector('#en-description-editor'))
            .then(editor => this.enDescriptionEditor = editor)
            .catch(error => alert(`Error: ${error}`));

        ClassicEditor
            .create(document.querySelector('#ru-description-editor'))
            .then(editor => this.ruDescriptionEditor = editor)
            .catch(error => alert(`Error: ${error}`));

        ClassicEditor
            .create(document.querySelector('#tr-description-editor'))
            .then(editor => this.trDescriptionEditor = editor)
            .catch(error => alert(`Error: ${error}`));

        ClassicEditor
            .create(document.querySelector('#ua-description-editor'))
            .then(editor => this.uaDescriptionEditor = editor)
            .catch(error => alert(`Error: ${error}`));
    }

    initAdditionPopup() {
        this.additionPopup = PopupObserver.init(
            this.nodes.additionPopup,
            false,
                _ => this.afterAdditionPopupCloseHandler()
        );
    }

    initParamsPopup() {
        this.paramPopup = PopupObserver.init(
            this.nodes.paramPopup,
            false,
            _ => this.afterParamPopupCloseHandler()
        );
    }

    afterAdditionPopupCloseHandler() {
        this.nodes.additionPopup.querySelector('select[name="addition_id"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="en_description"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="ru_description"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="tr_description"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="ua_description"]').value = '';
        this.view.hideAdditionPopupError();
        this.removeAllListeners(this.nodes.attachAdditionButton, 'click');
    }

    afterParamPopupCloseHandler() {
        this.nodes.paramPopup.querySelector('select[name="vehicle_param_id"]').value = '';
        this.nodes.paramPopup.querySelector('input[name="en_value"]').value = '';
        this.nodes.paramPopup.querySelector('input[name="ru_value"]').value = '';
        this.nodes.paramPopup.querySelector('input[name="tr_value"]').value = '';
        this.nodes.paramPopup.querySelector('input[name="ua_value"]').value = '';
        this.view.hideParamPopupError();
        this.removeAllListeners(this.nodes.attachParameterButton, 'click');
    }

    beforeAdditionPopupOpenHandler(isInclude) {
        this.addEvent(this.nodes.attachAdditionButton, 'click', _ => this.attachAddition(isInclude));
    }

    beforeParamPopupOpenHandler() {
        this.addEvent(this.nodes.attachParameterButton, 'click', _ => this.attachParam());
    }

    attachAddition(isInclude) {
        this.view.hideAdditionPopupError();

        if (this.nodes.additionPopup.querySelector('select[name="addition_id"]').value === '') {
            this.view.showAdditionPopupError(LocaleHelper.translate('choose-addition'));
            return;
        }

        let id = this.nodes.additionPopup.querySelector('select[name="addition_id"]').value.split('~')[0],
            title = this.nodes.additionPopup.querySelector('select[name="addition_id"]').value.split('~')[1],
            en_description = this.nodes.additionPopup.querySelector('input[name="en_description"]').value,
            ru_description = this.nodes.additionPopup.querySelector('input[name="ru_description"]').value,
            tr_description = this.nodes.additionPopup.querySelector('input[name="tr_description"]').value,
            ua_description = this.nodes.additionPopup.querySelector('input[name="ua_description"]').value,
            needToCreate = true;

        // Check if this addition already attached
        this.additions.forEach((item, index) => {
            if (item.id === id) {
                needToCreate = false;
                this.additions[index] = {
                    ...item,
                    en_description,
                    ru_description,
                    tr_description,
                    ua_description,
                    is_include: isInclude
                };
            }
        });

        if (needToCreate) {
            this.additions.push({
                id,
                title,
                en_description,
                ru_description,
                tr_description,
                ua_description,
                is_include: isInclude
            });
        }

        this.additionPopup.close(_ => this.afterAdditionPopupCloseHandler());
        this.view.renderAdditions(
            this.additions,
            (buttonNode, paramId) => this.dettachAdditionHandler(buttonNode, paramId),
            (buttonNode, param) => this.editAdditionHandler(buttonNode, param)
        );
    }

    attachParam() {
        this.view.hideParamPopupError();

        if (this.nodes.paramPopup.querySelector('select[name="vehicle_param_id"]').value === '') {
            this.view.showParamPopupError(LocaleHelper.translate('choose-param'));
            return;
        }

        let id = this.nodes.paramPopup.querySelector('select[name="vehicle_param_id"]').value.split('~')[0],
            name = this.nodes.paramPopup.querySelector('select[name="vehicle_param_id"]').value.split('~')[1],
            en_value = this.nodes.paramPopup.querySelector('input[name="en_value"]').value,
            ru_value = this.nodes.paramPopup.querySelector('input[name="ru_value"]').value,
            tr_value = this.nodes.paramPopup.querySelector('input[name="tr_value"]').value,
            ua_value = this.nodes.paramPopup.querySelector('input[name="ua_value"]').value,
            needToCreate = true;

        if (!en_value || !ru_value || !tr_value || !ua_value) {
            this.view.showParamPopupError(LocaleHelper.translate('not-all-fields-filled'));
            return;
        }

        // Check if this addition already attached
        this.params.forEach((item, index) => {
            if (item.id === id) {
                needToCreate = false;
                this.params[index] = {
                    ...item,
                    en_value,
                    ru_value,
                    tr_value,
                    ua_value
                };
            }
        });

        if (needToCreate) {
            this.params.push({
                id,
                name,
                en_value,
                ru_value,
                tr_value,
                ua_value
            });
        }

        this.paramPopup.close(_ => this.afterParamPopupCloseHandler());
        this.view.renderParams(
            this.params,
            (buttonNode, additionId) => this.dettachParamHandler(buttonNode, additionId),
            (buttonNode, addition) => this.editParamHandler(buttonNode, addition)
        );
    }

    dettachAdditionHandler(buttonNode, additionId) {
        this.addEvent(buttonNode, 'click', _ => {
            this.additions.forEach(item => {
                if (item.id === additionId) {
                    this.additions.splice(this.additions.indexOf(item), 1);
                }
            });

            this.view.renderAdditions(
                this.additions,
                (buttonNode, additionId) => this.dettachAdditionHandler(buttonNode, additionId),
                (buttonNode, addition) => this.editAdditionHandler(buttonNode, addition)
            );
        });
    }

    dettachParamHandler(buttonNode, paramId) {
        this.addEvent(buttonNode, 'click', _ => {
            this.params.forEach(item => {
                if (item.id === paramId) {
                    this.params.splice(this.params.indexOf(item), 1);
                }
            });

            this.view.renderParams(
                this.params,
                (buttonNode, paramId) => this.dettachParamHandler(buttonNode, paramId),
                (buttonNode, param) => this.editParamHandler(buttonNode, param)
            );
        });
    }

    editAdditionHandler(buttonNode, addition) {
        this.addEvent(buttonNode, 'click', _ => {
            this.additionPopup.open(_ => {
                this.nodes.additionPopup.querySelector('select[name="addition_id"]').value = `${addition.id}~${addition.title}`;
                this.nodes.additionPopup.querySelector('input[name="en_description"]').value = addition.en_description;
                this.nodes.additionPopup.querySelector('input[name="ru_description"]').value = addition.ru_description;
                this.nodes.additionPopup.querySelector('input[name="tr_description"]').value = addition.tr_description;
                this.nodes.additionPopup.querySelector('input[name="ua_description"]').value = addition.ua_description;
                this.addEvent(this.nodes.attachAdditionButton, 'click', _ => this.attachAddition(addition.is_include));
            });
        });
    }

    editParamHandler(buttonNode, param) {
        this.addEvent(buttonNode, 'click', _ => {
            this.paramPopup.open(_ => {
                this.nodes.paramPopup.querySelector('select[name="vehicle_param_id"]').value = `${param.id}~${param.name}`;
                this.nodes.paramPopup.querySelector('input[name="en_value"]').value = param.en_value;
                this.nodes.paramPopup.querySelector('input[name="ru_value"]').value = param.ru_value;
                this.nodes.paramPopup.querySelector('input[name="tr_value"]').value = param.tr_value;
                this.nodes.paramPopup.querySelector('input[name="ua_value"]').value = param.ua_value;
                this.addEvent(this.nodes.attachParameterButton, 'click', _ => this.attachParam());
            });
        });
    }

    initWeekDaysSelect(selector) {
        this.weekDaysSelect = new TomSelect(selector, {
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    return `<div class="mr-2 text-sm text-gray-600 comma-separate">${data.text}</div>`;
                },
            }
        });
    }

    initFiltersSelect(selector) {
        this.filtersSelect = new TomSelect(selector, {
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    return `<div class="mr-2 py-1 px-2 text-sm text-gray-600 rounded bg-gray-100">${data.text}</div>`;
                },
            }
        });
    }
}

export default TourFormBaseController;
