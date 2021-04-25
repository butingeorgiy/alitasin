import PopupController from '../modules/popup/PopupController';

class PopupObserver {
    static init(node, needToOpen = false, afterCloseHandler = null) {
        const popup = new PopupController(node, afterCloseHandler);

        if (needToOpen) {
            popup.open();
        }

        return popup;
    }
}

export default PopupObserver;
