import ReservationListController from './ReservationListController';

document.addEventListener('DOMContentLoaded', _ => {
    if (/^\/admin\/reserves$/.test(location.pathname) || /^\/profile\/partner$/.test(location.pathname)) {
        new ReservationListController({
            container: document.querySelector('#reservesSection .reserves-container'),
            statusPopup: document.querySelector('#updateReserveStatusPopup'),
            detailsPopup: document.querySelector('#reserveDetailsPopup')
        });
    }
});
