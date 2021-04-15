import EventHandler from '../../core/EventHandler';

class PopupController extends EventHandler {
    constructor(popupNode) {
        super();

        this.popup = popupNode;

        this.addEvent(popupNode.querySelector('.close-popup-button'), 'click', _ => this.close());
    }

    open() {
        this.popup.classList.remove('hidden');

        setTimeout(_ => {
            this.popup.querySelector('.popup').classList.remove('top-80');
        }, 0);
    }

    close() {
        this.popup.querySelector('.popup').classList.add('top-80');

        setTimeout(_ => {
            this.popup.classList.add('hidden');
        }, 250);
    }
}

export default PopupController;
