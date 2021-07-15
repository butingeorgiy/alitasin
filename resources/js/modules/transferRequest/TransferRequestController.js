import EventHandler from '../../core/EventHandler';
import TransferRequestView from './TransferRequestView';
import PopupObserver from '../../observers/PopupObserver';
import TransferRequestObserver from '../../observers/TransferRequestObserver';

class TransferRequestController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;

        this.view = new TransferRequestView({
            successMessage: nodes.successMessage,
            errorMessage: nodes.errorMessage,
            transferOrderButton: nodes.transferOrderButton,
            showPopupButton: nodes.showTransferOrderPopupButton
        });

        this.initPopup();

        this.openPopup = this.openPopup.bind(this);

        // TransferRequestObserver.setRenderShowTransferRequestPopupButtonHandler(_ => {
        //     this.view.renderShowPopupButton();
        // });
    }

    initPopup() {
        this.popup = PopupObserver.init(this.nodes.transferOrderPopup);

        this.addEvent(this.nodes.showTransferOrderPopupButton, 'click', _ => {
            this.popup.open();
        });
    }

    openPopup() {
        this.popup.open();
    }
}

export default TransferRequestController;