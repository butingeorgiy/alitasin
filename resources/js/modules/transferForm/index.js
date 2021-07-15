import TransferFormController from './TransferFormController';

document.addEventListener('DOMContentLoaded', _ => {
    const transferFormSection = document.querySelector('#transferFormSection');

    if (transferFormSection) {
        new TransferFormController({
            typeTabs: transferFormSection.querySelectorAll('.transfer-type-tab-item'),
            departureInput: transferFormSection.querySelector('input[name="departure"]'),
            arrivalInput: transferFormSection.querySelector('input[name="arrival"]'),
            error: transferFormSection.querySelector('.error-message'),
            calculateButton: transferFormSection.querySelector('.calculate-transfer-cost'),
            capacityRadioInputs: transferFormSection.querySelectorAll('input[name="capacity"]'),
            costWrapper: transferFormSection.querySelector('.transfer-cost-wrapper')
        });
    }
});