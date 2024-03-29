import PartnerListController from './PartnerListController';

document.addEventListener('DOMContentLoaded', _ => {
    if (/^\/admin\/partners$/.test(location.pathname) || /^\/admin\/partners\/\d+$/.test(location.pathname)) {
        new PartnerListController({
            partnersContainer: document.querySelector('#partnersSection .partners-container'),
            partnerPaymentPopup: document.querySelector('#partnerPaymentPopup'),
            updateProfitPercentPopup: document.querySelector('#updateProfitPercentPopup')
        });
    }
});
