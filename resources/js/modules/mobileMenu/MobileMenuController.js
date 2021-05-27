import EventHandler from '../../core/EventHandler';

class MobileMenuController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.isShown = false;

        this.addEvent(nodes.burgerIcon, 'click', _ => this.toggle());

        this.addEvent(window, 'click', e => {
            for (let node of e.path) {
                if (/burger-menu-icon|mobile-menu/.test(node.className)) {
                    return;
                }
            }

            this.hide();
        });

        nodes.mobileMenu.querySelectorAll('.close-after-click').forEach(node => {
            this.addEvent(node, 'click', _ => this.hide());
        });
    }

    toggle() {
        if (this.isShown) {
            this.hide();
        } else {
            this.show();
        }
    }

    show() {
        alert('Была нажата кнопка!');
        this.isShown = true;
        this.nodes.mobileMenu.classList.remove('hidden');
        setTimeout(_ => {
            this.nodes.mobileMenu.classList.add('scale-100', 'opacity-100');
        }, 0);
    }

    hide() {
        this.isShown = false;
        this.nodes.mobileMenu.classList.remove('scale-100', 'opacity-100')
        setTimeout(_ => this.nodes.mobileMenu.classList.add('hidden'), 150);
    }
}

export default MobileMenuController;
