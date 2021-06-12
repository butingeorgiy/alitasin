import OrderVehicleController from './OrderVehicleController';

document.addEventListener('DOMContentLoaded', _ => {
    const vehicleOrderPopup = document.querySelector('#vehicleOrderPopup');
    const vehicleCards = document.querySelectorAll('.vehicle-item');

    if (vehicleOrderPopup && vehicleCards.length > 0) {
        new OrderVehicleController({
            popup: vehicleOrderPopup,
            sendOrderButton: vehicleOrderPopup.querySelector('.send-vehicle-order-button'),
            vehicleCards
        });
    }
});
