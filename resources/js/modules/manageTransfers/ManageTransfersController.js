import EventHandler from '../../core/EventHandler';
import LocaleHelper from '../../helpers/LocaleHelper';
import TransferFormModel from '../transferForm/TransferFormModel';
import TomSelect from 'tom-select/dist/js/tom-select.complete.min';
import ManageTransfersObserver from '../../observers/ManageTransfersObserver';
import ManageTransfersModel from './ManageTransfersModel';

class ManageTransfersController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;

        this.state = {
            airportId: {
                value: null,
                depends: [
                    (_, newState) => {
                        this.toggleAirportManageButtons(newState.airportId);
                    },
                    this.resolveTransferVariations
                ]
            },
            isAirportDeleted: {
                value: false,
                depends: [
                    (_, newState) => {
                        if (newState.isAirportDeleted) {
                            this.enableAirportRecovery(newState.airportId);
                        } else {
                            this.disableAirportRecovery();
                        }
                    }
                ]
            },
            airportData: {
                value: null,
                depends: []
            },
            destinationId: {
                value: null,
                depends: [
                    (_, newState) => {
                        this.toggleDestinationManageButtons(newState.destinationId);
                    },
                    this.resolveTransferVariations
                ]
            },
            isDestinationDeleted: {
                value: false,
                depends: [
                    (_, newState) => {
                        if (newState.isDestinationDeleted) {
                            this.enableDestinationRecovery(newState.destinationId);
                        } else {
                            this.disableDestinationRecovery();
                        }
                    }
                ]
            },
            destinationData: {
                value: null,
                depends: []
            },
        };

        this.initAirportSelect();
        this.initDestinationSelect();

        this.addEvent(nodes.showAirportCreatingPopupButton, 'click', _ => {
            ManageTransfersObserver.showCreatingAirportPopup();
        });

        this.addEvent(nodes.showDestinationCreatingPopupButton, 'click', _ => {
            ManageTransfersObserver.showCreatingDestinationPopup();
        });
    }

    resolveTransferVariations(_, newState) {
        const {airportId, destinationId} = newState;

        if (airportId && destinationId) {
            ManageTransfersObserver.resolveTransfer(airportId, destinationId);
        } else {
            ManageTransfersObserver.hideTransferVariations();
        }
    }

    initAirportSelect() {
        this.airportSelect = new TomSelect('#airportSelect', {
            maxItems: 1,
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            maxOptions: 1000,
            preload: true,
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    const params = {
                        'en_name': data['en_name'],
                        'ru_name': data['ru_name'],
                        'tr_name': data['tr_name'],
                        'ua_name': data['ua_name']
                    };

                    return `<div class="mr-2 text-sm text-gray-600 comma-separate" data-is-deleted="${data['deleted_at'] ? 1 : 0}" data-params='${JSON.stringify(params)}'>${data['name']} ${data['deleted_at'] ? '(' + LocaleHelper.translate('deleted') + ')' : ''}</div>`;
                },
                'option': data => {
                    return `<div>${data['name']} ${data['deleted_at'] ? '(' + LocaleHelper.translate('deleted') + ')' : ''}</div>`;
                }
            },
            load: function (_, callback) {
                const selectContext = this;

                if (selectContext.loading > 1) {
                    callback();
                    return;
                }

                TransferFormModel.getAirports(true)
                    .then(result => {
                        callback(result);
                        selectContext.settings.load = null;
                    })
                    .catch(error => {
                        console.error(error);
                        callback();
                    });
            },
            onChange: value => {
                const isDeleted = this.airportSelect?.getItem(value)?.getAttribute('data-is-deleted') === '1';
                const params = this.airportSelect?.getItem(value)?.getAttribute('data-params');

                if (params) {
                    this.updateState('airportData', JSON.parse(params));
                } else {
                    this.updateState('airportData', null);
                }

                this.updateState('airportId', value ? parseInt(value) : null);
                this.updateState('isAirportDeleted', isDeleted);
            }
        });
    }

    initDestinationSelect() {
        this.destinationSelect = new TomSelect('#destinationSelect', {
            maxItems: 1,
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            maxOptions: 1000,
            preload: true,
            render: {
                'no_results': _ => {
                    return `<div class="no-results">${LocaleHelper.translate('no-results')}</div>`;
                },
                'item': data => {
                    const params = {
                        'en_name': data['en_name'],
                        'ru_name': data['ru_name'],
                        'tr_name': data['tr_name'],
                        'ua_name': data['ua_name']
                    };

                    return `<div class="mr-2 text-sm text-gray-600 comma-separate" data-is-deleted="${data['deleted_at'] ? 1 : 0}" data-params='${JSON.stringify(params)}'>${data['name']} ${data['deleted_at'] ? '(' + LocaleHelper.translate('deleted') + ')' : ''}</div>`;
                },
                'option': data => {
                    return `<div>${data['name']} ${data['deleted_at'] ? '(' + LocaleHelper.translate('deleted') + ')' : ''}</div>`;
                }
            },
            load: function (_, callback) {
                const selectContext = this;

                if (selectContext.loading > 1) {
                    callback();
                    return;
                }

                TransferFormModel.getDestinations(true)
                    .then(result => {
                        callback(result);
                        selectContext.settings.load = null;
                    })
                    .catch(error => {
                        console.error(error);
                        callback();
                    });
            },
            onChange: value => {
                const isDeleted = this.destinationSelect?.getItem(value)?.getAttribute('data-is-deleted') === '1';
                const params = this.destinationSelect?.getItem(value)?.getAttribute('data-params');

                if (params) {
                    this.updateState('destinationData', JSON.parse(params));
                } else {
                    this.updateState('destinationData', null);
                }

                this.updateState('destinationId', value ? parseInt(value) : null);
                this.updateState('isDestinationDeleted', isDeleted);
            }
        });
    }

    updateState(key, value) {
        if (this.state[key] === undefined) {
            console.error('Undefined key of state in ManageTransfers module!');
            return;
        }

        let prevState = {}, newState = {};

        Object.entries(this.state).forEach(([key, {value = null}]) => {
            prevState[key] = value;
        });

        this.state[key].value = value;

        Object.entries(this.state).forEach(([key, {value = null}]) => {
            newState[key] = value;
        });

        this.state[key].depends.forEach(handler => {
            handler(prevState, newState);
        });
    }

    getState(key) {
        if (this.state[key] === undefined) {
            console.error('Undefined key of state in ManageTransfers module!');
            return undefined;
        }

        return this.state[key].value;
    }

    toggleAirportManageButtons(airportId) {
        this.removeAllListeners(this.nodes.deleteAirportButton, 'click');
        this.removeAllListeners(this.nodes.showAirportUpdatingPopupButton, 'click');

        if (airportId === null) {
            this.nodes.showAirportUpdatingPopupButton.classList.add('disabled');
            this.nodes.deleteAirportButton.classList.add('disabled');
        } else {
            this.nodes.showAirportUpdatingPopupButton.classList.remove('disabled');
            this.nodes.deleteAirportButton.classList.remove('disabled');

            this.addEvent(this.nodes.deleteAirportButton, 'click', _ => {
                this.deleteAirport(airportId);
            });

            this.addEvent(this.nodes.showAirportUpdatingPopupButton, 'click', _ => {
                ManageTransfersObserver.showUpdatingAirportPopup(this.getState('airportData'), airportId);
            });
        }
    }

    toggleDestinationManageButtons(destinationId) {
        this.removeAllListeners(this.nodes.deleteDestinationButton, 'click');
        this.removeAllListeners(this.nodes.showDestinationUpdatingPopupButton, 'click');

        if (destinationId === null) {
            this.nodes.showDestinationUpdatingPopupButton.classList.add('disabled');
            this.nodes.deleteDestinationButton.classList.add('disabled');
        } else {
            this.nodes.showDestinationUpdatingPopupButton.classList.remove('disabled');
            this.nodes.deleteDestinationButton.classList.remove('disabled');

            this.addEvent(this.nodes.deleteDestinationButton, 'click', _ => {
                this.deleteDestination(destinationId);
            });

            this.addEvent(this.nodes.showDestinationUpdatingPopupButton, 'click', _ => {
                ManageTransfersObserver.showUpdatingDestinationPopup(this.getState('destinationData'), destinationId);
            });
        }
    }

    enableAirportRecovery(airportId) {
        this.nodes.deleteAirportButton.classList.add('hidden');
        this.nodes.restoreAirportButton.classList.remove('hidden');

        this.removeAllListeners(this.nodes.deleteAirportButton, 'click');
        this.removeAllListeners(this.nodes.restoreAirportButton, 'click');

        this.addEvent(this.nodes.restoreAirportButton, 'click', _ => {
            this.restoreAirport(airportId);
        });
    }

    enableDestinationRecovery(destinationId) {
        this.nodes.deleteDestinationButton.classList.add('hidden');
        this.nodes.restoreDestinationButton.classList.remove('hidden');

        this.removeAllListeners(this.nodes.deleteDestinationButton, 'click');
        this.removeAllListeners(this.nodes.restoreDestinationButton, 'click');

        this.addEvent(this.nodes.restoreDestinationButton, 'click', _ => {
            this.restoreDestination(destinationId);
        });
    }

    disableAirportRecovery() {
        this.nodes.deleteAirportButton.classList.remove('hidden');
        this.nodes.restoreAirportButton.classList.add('hidden');

        this.removeAllListeners(this.nodes.restoreAirportButton, 'click');
    }

    disableDestinationRecovery() {
        this.nodes.deleteDestinationButton.classList.remove('hidden');
        this.nodes.restoreDestinationButton.classList.add('hidden');

        this.removeAllListeners(this.nodes.restoreDestinationButton, 'click');
    }

    deleteAirport(id) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        ManageTransfersModel.deleteAirport(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }

    restoreAirport(id) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        ManageTransfersModel.restoreAirport(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }

    deleteDestination(id) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        ManageTransfersModel.deleteDestination(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }

    restoreDestination(id) {
        if (!confirm(LocaleHelper.translate('you-are-sure'))) {
            return;
        }

        ManageTransfersModel.restoreDestination(id)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(`Error: ${result.message}`);
                } else {
                    alert(result.message);
                    location.reload();
                }
            })
            .catch(error => alert(`Error: ${error}`));
    }
}

export default ManageTransfersController;