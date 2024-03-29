import OrderVehicleController from './OrderVehicleController';

document.addEventListener('DOMContentLoaded', _ => {
    const vehicleOrderPopup = document.querySelector('#vehicleOrderPopup');
    const vehicleCards = document.querySelectorAll('.vehicle-item');

    if (vehicleOrderPopup) {
        new OrderVehicleController({
            popup: vehicleOrderPopup,
            sendOrderButton: vehicleOrderPopup.querySelector('.send-vehicle-order-button'),
            vehicleCards,
            regionSelect: document.querySelector('#vehicleTypesSection select[name="region_id"]'),
            checkPromoCodeButton: vehicleOrderPopup.querySelector('.check-promo-code-button'),
            oldPrice: vehicleOrderPopup.querySelector('.old-price'),
            totalPrice: vehicleOrderPopup.querySelector('.total-price')
        });
    }
});
