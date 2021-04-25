import DropdownController from '../modules/dropdown/DropdownController';

class DropdownObserver {
    static init(dropdownNode, showDropdownButtonNode, onClickHandler = null, onFailed = null) {
        const dropdownObject = new DropdownController(dropdownNode, showDropdownButtonNode, onClickHandler);

        if (dropdownObject.error.status) {
            if (onFailed) {
                onFailed(dropdownObject.error.message);
            } else {
                console.error(dropdownObject.error.message);
            }
        }
    }
}

export default DropdownObserver;
