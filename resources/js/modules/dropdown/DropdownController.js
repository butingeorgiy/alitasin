import EventHandler from '../../core/EventHandler';

class DropdownController extends EventHandler {
    constructor(dropdownNode, showDropdownButtonNode, onClickHandler = null) {
        super();

        this.dropdown = dropdownNode;
        this.isShown = false;
        this.error = {status: false, message: null};

        try {
            if (onClickHandler) {
                this.initClickHandler(onClickHandler);
            }

            this.addEvent(showDropdownButtonNode, 'click', _ => this.toggle());

            if (DropdownController._instances === undefined) {
                DropdownController._instances = [];

                this.addEvent(window, 'click', e => {
                    for (let node of e.path) {
                        if (/show-custom-dropdown-button|custom-dropdown-container/.test(node.className)) {
                            return;
                        }
                    }

                    DropdownController.hideAll();
                });
            }

            DropdownController._instances.push(this);
        } catch (e) {
            this.error = {status: true, message: e};
        }
    }

    initClickHandler(handler) {
        this.dropdown.querySelectorAll('.custom-dropdown-option').forEach(option => {
            this.addEvent(option, 'click', _ => {
                this.toggle();

                handler(
                    option.getAttribute('data-option-name'),
                    option.getAttribute('data-option-params')
                );
            });
        });
    }

    toggle() {
        DropdownController.hideAll(this);

        if (this.isShown) {
            DropdownController.hide(this);
        } else {
            DropdownController.show(this);
        }
    }

    static hideAll(currentInstance = null) {
        DropdownController._instances.forEach(instance => {
            if ((currentInstance !== instance || !currentInstance) && instance.isShown) {
                instance.isShown = false;
                instance.dropdown.classList.remove('opacity-100', 'scale-100');
                setTimeout(_ => {
                    instance.dropdown.classList.add('hidden');
                }, 100);
            }
        });
    }

    static show(instance) {
        instance.isShown = true;
        instance.dropdown.classList.remove('hidden');

        setTimeout(_ => {
            instance.dropdown.classList.add('opacity-100', 'scale-100');
        }, 0);
    }

    static hide(instance) {
        instance.isShown = false;

        instance.dropdown.classList.remove('opacity-100', 'scale-100');

        setTimeout(_ => {
            instance.dropdown.classList.add('hidden');
        }, 100);
    }
}

export default DropdownController;
