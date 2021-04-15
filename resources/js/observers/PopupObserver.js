import PopupController from '../modules/popup/PopupController';

class PopupObserver {
    static init(node, needToOpen = false) {
        const popup = new PopupController(node);

        if (needToOpen) {
            popup.open();
        }

        return popup;
    }
}

export default PopupObserver;
