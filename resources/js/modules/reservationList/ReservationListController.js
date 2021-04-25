import EventHandler from '../../core/EventHandler';
import DropdownObserver from '../../observers/DropdownObserver';
import PopupObserver from '../../observers/PopupObserver';
import JsonHelper from '../../helpers/JsonHelper';
import ReservationListView from './ReservationListView';
import ReservationListModel from './ReservationListModel';
import flatpickr from 'flatpickr';
import DateHelper from '../../helpers/DateHelper';
import LocaleHelper from "../../helpers/LocaleHelper";
import {Russian} from "flatpickr/dist/l10n/ru";
import {Turkish} from "flatpickr/dist/l10n/tr";

class ReservationListController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = {
            ...nodes,
            statusSelect: nodes.statusPopup.querySelector('select[name="reservation_status"]'),
            updateStatusButton: nodes.statusPopup.querySelector('.update-status-button'),
            filtersContainer: nodes.container.querySelector('.reserves-filters'),
            detailsDateInput: nodes.detailsPopup.querySelector('input[name="tour_date"]')
        };

        this.view = new ReservationListView({
            updateStatusButton: this.nodes.updateStatusButton,
            updateStatusError: nodes.statusPopup.querySelector('.error-message'),
            updateStatusSuccess: nodes.statusPopup.querySelector('.success-message'),
            statusSelect: this.nodes.statusSelect
        });

        this.filters = {
            'tour_id': null,
            'date_min': null,
            'date_max': null,
            'time': null
        };

        this.statusUpdatingLoading = false;
        this.statusUpdatingDisabled = true;

        this.initStatusPopup();
        this.initDetailsPopup();
        this.initFilters();
        this.initDetailsDatePicker();
        this.initShowReservationContextMenu(nodes.container.querySelectorAll('.reserves-item'));
    }

    initDetailsDatePicker() {
        let locale = LocaleHelper.getLocale();

        if (locale === 'ru') {
            locale = Russian;
        } else if (locale === 'tr') {
            locale = Turkish;
        } else {
            locale = null;
        }

        this.detailsDatePicker = flatpickr(this.nodes.detailsDateInput, {
            inline: true,
            locale
        });
    }

    initFilters() {
        // Init date pickers
        this.datePicker = flatpickr(this.nodes.filtersContainer.querySelector('input[name="date"]'), {
            dateFormat: 'd.m.y',
            mode: 'range',
            defaultDate: JsonHelper.parse(this.nodes.filtersContainer.querySelector('input[name="date"]').getAttribute('data-value')),
            locale: {
                rangeSeparator: ' - '
            },
            onChange: selectedDates => {
                if (selectedDates.length !== 1) {
                    const minDate = selectedDates[0] ? DateHelper.format(selectedDates[0]) : null,
                          maxDate = selectedDates[1] ? DateHelper.format(selectedDates[1]) : null;

                    if (this.filters['date_min'] !== minDate || this.filters['date_max'] !== maxDate) {
                        this.filters = {
                            ...this.filters,
                            'date_min': minDate,
                            'date_max': maxDate
                        };
                        this.applyFilters();
                    }
                }
            }
        });

        if (this.datePicker.selectedDates.length === 2) {
            this.filters = {
                ...this.filters,
                'date_min': DateHelper.format(this.datePicker.selectedDates[0]),
                'date_max': DateHelper.format(this.datePicker.selectedDates[1])
            };
        }

        this.timePicker = flatpickr(this.nodes.filtersContainer.querySelector('input[name="time"]'), {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onClose: (_, text) => {
                if (text !== this.filters['time']) {
                    this.filters = {
                        ...this.filters,
                        'time': text ? text : null
                    };
                    this.applyFilters();
                }
            }
        });

        if (this.nodes.filtersContainer.querySelector('input[name="time"]').value) {
            this.filters = {
                ...this.filters,
                'time': this.nodes.filtersContainer.querySelector('input[name="time"]').value
            };
        }

        // Init handlers
        this.addEvent(this.nodes.filtersContainer.querySelector('select[name="tour_id"]'), 'change', e => {
            this.filters = {
                ...this.filters,
                'tour_id': e.target.value
            };

            this.applyFilters();
        });

        if (this.nodes.filtersContainer.querySelector('select[name="tour_id"]').value) {
            this.filters = {
                ...this.filters,
                'tour_id': this.nodes.filtersContainer.querySelector('select[name="tour_id"]').value
            };
        }
    }

    applyFilters() {
        let uri = '?';

        for (let key in this.filters) {
            if (!this.filters[key]) {
                continue;
            }

            uri += `${key}=${this.filters[key]}&`;
        }

        location.replace(uri === '?' ? '/admin/reserves' : uri);
    }

    initShowReservationContextMenu(items) {
        items.forEach(item => {
            DropdownObserver.init(
                item.querySelector('.custom-dropdown-container'),
                item.querySelector('.show-custom-dropdown-button'),
                (key, options) => this.onContextOptionClick(key, options)
            );
        });
    }

    initStatusPopup() {
        this.statusPopup = PopupObserver.init(this.nodes.statusPopup, false, _ => this.afterStatusPopupCloseHandler());
    }

    initDetailsPopup() {
        this.detailsPopup = PopupObserver.init(this.nodes.detailsPopup, false);
    }

    onContextOptionClick(key, options) {
        switch (key) {
            case 'change-status':
                this.statusPopup.open(_ => this.beforeStatusPopupOpenHandler(...JsonHelper.getFromJson(options, 'status_id', 'reservation_id')));
                break;
            case 'show-info':
                this.detailsPopup.open(_ => this.beforeDetailsPopupOpenHandler(JsonHelper.parse(options)));
                break;
            default:
                console.error('Undefined option!', [key, options]);

        }
    }

    beforeDetailsPopupOpenHandler(details) {
        this.nodes.detailsPopup.querySelector('.user-name').innerText = details['user-name'];
        this.nodes.detailsPopup.querySelector('.user-email').innerText = details['user-email'];
        this.nodes.detailsPopup.querySelector('.user-phone').innerText = details['user-phone'];

        this.nodes.detailsPopup.querySelector('.hotel-name').innerText = details['hotel-name'];
        this.nodes.detailsPopup.querySelector('.communication-type').innerText = details['communication-type'];
        this.nodes.detailsPopup.querySelector('.available-time').innerText = details['time'];
        this.nodes.detailsPopup.querySelector('.total-cost').innerText = details['total-cost'];

        if (details['promo-code']) {
            this.nodes.detailsPopup.querySelector('.promo-code .code').innerText = details['promo-code']['code'];
            this.nodes.detailsPopup.querySelector('.promo-code .active').innerText = `Активен (-${details['promo-code']['percent']}%)`;
            this.nodes.detailsPopup.querySelector('.promo-code .active').classList.remove('hidden');
        } else {
            this.nodes.detailsPopup.querySelector('.promo-code .code').innerText = 'Ничего не указано';
            this.nodes.detailsPopup.querySelector('.promo-code .active').innerText = '';
            this.nodes.detailsPopup.querySelector('.promo-code .active').classList.add('hidden');
        }
    }

    beforeStatusPopupOpenHandler(statusId, reservationId) {
        this.nodes.statusSelect.value = statusId;

        this.addEvent(this.nodes.statusSelect, 'change', _ => {
            this.statusUpdatingDisabled = (this.nodes.statusSelect.value === statusId.toString());

            if (this.statusUpdatingDisabled === true) {
                this.view.setDisabledUpdateStatusButton();
            } else {
                this.view.setEnabledUpdateStatusButton();
            }
        });

        this.addEvent(this.nodes.updateStatusButton, 'click', _ => {
            if (this.statusUpdatingLoading || this.statusUpdatingDisabled) {
                return;
            }

            this.statusUpdatingLoading = true;
            this.view.setLoadingUpdateStatusButton();
            this.view.disableUpdateStatusSelect();
            this.view.hideUpdateStatusMessages();

            this.updateStatus(reservationId);
        });
    }

    afterStatusPopupCloseHandler() {
        this.removeAllListeners(this.nodes.updateStatusButton, 'click');
        this.removeAllListeners(this.nodes.statusSelect, 'change');
        this.nodes.updateStatusButton.classList.add('disabled');
        this.statusUpdatingLoading = false;
        this.statusUpdatingDisabled = true;
    }

    updateStatus(reservationId) {
        const formData = new FormData();

        formData.append('reservation_status_id', this.nodes.statusSelect.value);

        ReservationListModel.updateStatus(formData, reservationId)
            .then(result => {
                if (typeof result === 'string') {
                    this.statusUpdatingLoading = false;
                    this.statusUpdatingDisabled = false;
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.statusUpdatingLoading = false;
                    this.statusUpdatingDisabled = false;
                    this.view.showUpdateStatusError(result.message);
                } else {
                    this.view.showUpdateStatusSuccess(result.message);
                    setTimeout(_ => location.reload(), 500);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.view.enableUpdateStatusSelect();
                this.view.setEnabledUpdateStatusButton();
            });
    }
}

export default ReservationListController;
