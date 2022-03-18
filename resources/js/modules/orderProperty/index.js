import OrderPropertyController from './OrderPropertyController';

document.addEventListener('DOMContentLoaded', _ => {
    const propertyOrderPopup = document.querySelector('#propertyOrderPopup');
    const propertyCards = document.querySelectorAll('.property-item');

    if (propertyOrderPopup) {
        new OrderPropertyController({
            popup: propertyOrderPopup,
            sendOrderButton: propertyOrderPopup.querySelector('.send-property-order-button'),
            propertyCards,
            regionSelect: document.querySelector('#propertyTypesSection select[name="region_id"]'),
            typeSelect: document.querySelector('#propertyTypesSection select[name="type_id"]')
        })
    }
});