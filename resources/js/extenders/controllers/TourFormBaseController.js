import EventHandler from '../../core/EventHandler';
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import LocaleHelper from '../../helpers/LocaleHelper';
import PopupObserver from '../../observers/PopupObserver';

class TourFormBaseController extends EventHandler {
    constructor(nodes) {
        super();
        this.nodes = {
            ...nodes,
            attachAdditionButton: nodes.additionPopup.querySelector('.save-addition-button')
        };
        this.additions = [];

        this.initAdditionPopup();

        this.nodes.openAdditionPopupButtons.forEach(buttonNode => {
            this.addEvent(buttonNode, 'click', _ => {
                this.additionPopup.open(_ => this.beforeAdditionPopupOpenHandler(buttonNode.getAttribute('data-is-include')));
            });
        });
    }

    initAdditionPopup() {
        this.additionPopup = PopupObserver.init(this.nodes.additionPopup, false, _ => this.afterAdditionPopupCloseHandler());
    }

    afterAdditionPopupCloseHandler() {
        this.nodes.additionPopup.querySelector('select[name="addition_id"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="en_description"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="ru_description"]').value = '';
        this.nodes.additionPopup.querySelector('input[name="tr_description"]').value = '';
        this.view.hideAdditionPopupError();
        this.removeAllListeners(this.nodes.attachAdditionButton, 'click');
    }

    beforeAdditionPopupOpenHandler(isInclude) {
        this.addEvent(this.nodes.attachAdditionButton, 'click', _ => this.attachAddition(isInclude));
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
                is_include: isInclude
            });
        }

        this.additionPopup.close(_ => this.afterAdditionPopupCloseHandler());
        this.view.renderAdditions(
            this.additions,
            (buttonNode, additionId) => this.dettachAdditionHandler(buttonNode, additionId),
            (buttonNode, addition) => this.editAdditionHandler(buttonNode, addition)
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

    editAdditionHandler(buttonNode, addition) {
        this.addEvent(buttonNode, 'click', _ => {
            this.additionPopup.open(_ => {
                this.nodes.additionPopup.querySelector('select[name="addition_id"]').value = `${addition.id}~${addition.title}`;
                this.nodes.additionPopup.querySelector('input[name="en_description"]').value = addition.en_description;
                this.nodes.additionPopup.querySelector('input[name="ru_description"]').value = addition.ru_description;
                this.nodes.additionPopup.querySelector('input[name="tr_description"]').value = addition.tr_description;
                this.addEvent(this.nodes.attachAdditionButton, 'click', _ => this.attachAddition(addition.is_include));
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

    initAvailableTimeSelect(selector) {
        this.availableTimeSelect = new TomSelect(selector, {
            create: true,
            createFilter: '^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$',
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    return `<div class="mr-2 py-1 px-2 text-sm text-gray-600 rounded bg-gray-100">${data.text}</div>`;
                },
                'option_create': data => {
                    return `<div class="create">${LocaleHelper.translate('add-time')}:&nbsp;${data.input}</div>`;
                },
                'option': _ => {
                    return null;
                }
            }
        });
    }
}

export default TourFormBaseController;
