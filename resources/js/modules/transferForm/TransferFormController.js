import EventHandler from '../../core/EventHandler';
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import LocaleHelper from '../../helpers/LocaleHelper';
import TransferFormModel from './TransferFormModel';
import flatpickr from 'flatpickr';
import TransferFormView from './TransferFormView';
import TransferRequestObserver from '../../observers/TransferRequestObserver';

class TransferFormController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.calculation = false;

        this.view = new TransferFormView({
            calculateButton: nodes.calculateButton,
            error: nodes.error,
            costWrapper: nodes.costWrapper,
            cost: nodes.costWrapper.querySelector('.transfer-cost')
        });

        this.transferState = this.initTransferLocalState();

        this.initTypeSwitching();
        this.initCapacitySwitching();
        this.initAirportSelect();
        this.initDestinationSelect();
        this.initDepartureInput();
        this.initArrivalInput();
        
        this.addEvent(nodes.calculateButton, 'click', _ => {
            if (!this.calculation) {
                this.calculation = true;
                this.calculateTransferCost();
            }
        });
    }

    initTypeSwitching() {
        const unselectTabs = _ => {
            this.nodes.typeTabs.forEach(node => {
                node.classList.remove('active');
            });
        };

        this.nodes.typeTabs.forEach(node => {
            const typeId = node.getAttribute('data-type-id');

            this.addEvent(node, 'click', _ => {
                if (node.classList.contains('active')) {
                    return;
                }

                unselectTabs();
                node.classList.add('active');

                this.updateTransferLocalState('type_id', parseInt(typeId));
            });
        });
    }

    initCapacitySwitching() {
        this.nodes.capacityRadioInputs.forEach(node => {
            const capacityId = node.value;

            this.addEvent(node, 'change', _ => {
                this.updateTransferLocalState('capacity_id', parseInt(capacityId));
            });
        });
    }

    initAirportSelect() {
        this.airportSelect = new TomSelect('#airportSelect', {
            maxItems: 1,
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            preload: true,
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    return `<div class="mr-2 text-sm text-gray-600 comma-separate">${data.name}</div>`;
                }
            },
            load: function (_, callback) {
                const selectContext = this;

                if (selectContext.loading > 1) {
                    callback();
                    return;
                }

                TransferFormModel.getAirports()
                    .then(result => {
                        callback(result);
                        selectContext.settings.load = null;
                    })
                    .catch(error => {
                        console.error(error);
                        callback();
                    });
            },
            onChange: value => this.updateTransferLocalState('airport_id', value ? parseInt(value) : null)
        });
    }

    initDestinationSelect() {
        this.destinationSelect = new TomSelect('#destinationSelect', {
            maxItems: 1,
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            preload: true,
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    return `<div class="mr-2 text-sm text-gray-600 comma-separate">${data.name}</div>`;
                }
            },
            load: function (_, callback) {
                const selectContext = this;

                if (selectContext.loading > 1) {
                    callback();
                    return;
                }

                TransferFormModel.getDestinations()
                    .then(result => {
                        callback(result);
                        selectContext.settings.load = null;
                    })
                    .catch(error => {
                        console.error(error);
                        callback();
                    });
            },
            onChange: value => this.updateTransferLocalState('destination_id', value ? parseInt(value) : null)
        });
    }

    initDepartureInput() {
        const clearButton = this.nodes.departureInput.nextElementSibling;

        this.departurePicker = flatpickr(this.nodes.departureInput, {
            enableTime: true,
            dateFormat: 'd M, Y H:i',
            minDate: new Date(),
            disableMobile: true,
            onChange: (selectedDates, _, instance) => {
                if (selectedDates.length > 0) {
                    if (clearButton) {
                        clearButton.classList.remove('hidden');
                    }

                    this.updateTransferLocalState(
                        'departure',
                        instance.formatDate(selectedDates[0], 'Y-m-d H:i:00')
                    );
                } else {
                    if (clearButton) {
                        clearButton.classList.add('hidden');
                    }

                    this.updateTransferLocalState('departure', null);
                }
            }
        });

        this.addEvent(clearButton, 'click', _ => {
            this.departurePicker.clear();
        });
    }

    initArrivalInput() {
        const clearButton = this.nodes.arrivalInput.nextElementSibling;

        this.arrivalPicker = flatpickr(this.nodes.arrivalInput, {
            enableTime: true,
            dateFormat: 'd M, Y H:i',
            minDate: new Date(),
            disableMobile: true,
            onChange: (selectedDates, _, instance) => {
                if (selectedDates.length > 0) {
                    if (clearButton) {
                        clearButton.classList.remove('hidden');
                    }

                    this.updateTransferLocalState(
                        'arrival',
                        instance.formatDate(selectedDates[0], 'Y-m-d H:i:00')
                    );
                } else {
                    if (clearButton) {
                        clearButton.classList.add('hidden');
                    }

                    this.updateTransferLocalState('arrival', null);
                }
            }
        });

        this.addEvent(clearButton, 'click', _ => {
            this.arrivalPicker.clear();
        });
    }

    initTransferLocalState() {
        return {
            'type_id': this.nodes.typeTabs[0]?.getAttribute('data-type-id')
                ? parseInt(this.nodes.typeTabs[0]?.getAttribute('data-type-id')) : null,

            'airport_id': null,
            'destination_id': null,
            'departure': null,
            'arrival': null,
            'capacity_id': this.nodes.capacityRadioInputs[0]?.value
                ? parseInt(this.nodes.capacityRadioInputs[0]?.value) : null
        };
    }

    updateTransferLocalState(key, value) {
        if (this.transferState[key] === undefined) {
            console.error(`Local transfer data does not have specified key: ${key}`);
            return;
        }

        const prevState = this.transferState;

        this.transferState = {
            ...prevState,
            [key]: value
        };

        TransferRequestObserver.clearState();
        TransferRequestObserver.hideShowTransferRequestPopupButton(
            _ => {
                this.view.showCalculateButton();
            }
        );

        this.view.hideTransferCost();

        this.debugTransferState(); // TODO: remove after module developing
    }

    convertTransferLocalStateToFormData() {
        const formData = new FormData;

        Object.entries(this.transferState).forEach(([key, value = null]) => {
            if (value === null) {
                return;
            }

            formData.append(key, value);
        });

        return formData;
    }

    convertTransferLocalStateToGetQueryString() {
        let query = '?';

        Object.entries(this.transferState).forEach(([key, value = null]) => {
            if (value === null) {
                return;
            }

            query += `${encodeURIComponent(key)}=${encodeURIComponent(value)}&`;
        });

        if (query === '?') {
            return '';
        }

        return query.slice(0, -1); // remove last & character
    }

    calculateTransferCost() {
        this.view.showLoading();
        this.view.hideErrorMessage();
        this.view.hideTransferCost();

        TransferFormModel.calculate(this.convertTransferLocalStateToGetQueryString())
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    this.view.showErrorMessage(result.message);
                } else {
                    TransferRequestObserver.setState(this.transferState);

                    TransferRequestObserver.renderShowTransferRequestPopupButton(
                        _ => {
                            this.view.hideCalculateButton();
                        },
                        _ => {
                            alert('Unfortunately, Transfer Form Module is not ' +
                                'available now! Our developers try to fix it!')
                        }
                    );

                    this.view.showTransferCost(result['formatted_cost']);
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.calculation = false;
                this.view.hideLoading();
            });
    }

    // TODO: remove after module developing
    debugTransferState() {
        console.log('Transfer Local State: ', this.transferState);
    }
}

export default TransferFormController;