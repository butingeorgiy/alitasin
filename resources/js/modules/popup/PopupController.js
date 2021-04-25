import EventHandler from '../../core/EventHandler';

class PopupController extends EventHandler {
    constructor(popupNode, afterCloseHandler = null) {
        super();

        this.popup = popupNode;

        this.addEvent(popupNode.querySelector('.close-popup-button'), 'click', _ => this.close(afterCloseHandler));
    }

    open(beforeOpen = null) {
        this.popup.classList.remove('hidden');

        if (beforeOpen) {
            beforeOpen();
        }

        setTimeout(_ => {
            this.popup.querySelector('.popup').classList.remove('top-80');
        }, 0);
    }

    close(afterClose = null) {
        this.popup.querySelector('.popup').classList.add('top-80');

        setTimeout(_ => {
            this.popup.classList.add('hidden');
        }, 250);

        if (afterClose) {
            afterClose();
        }
    }
}

export default PopupController;
