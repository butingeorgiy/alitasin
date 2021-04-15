import EventHandler from '../../core/EventHandler';
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import LocaleHelper from '../../helpers/LocaleHelper';

class TourFormBaseController extends EventHandler {
    constructor(nodes) {
        super();
        this.nodes = nodes;
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
