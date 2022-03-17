import EventHandler from '../../core/EventHandler';
import ClickToCallWidgetView from './ClickToCallWidgetView';

class ClickToCallWidgetController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.isVisible = false;
        this.view = new ClickToCallWidgetView({
            toggleButtonNode: nodes.widget.querySelector('.toggle-button'),
            linksWrapperNode: nodes.widget.querySelector('.links-wrapper')
        });

        this.addEvent(nodes.widget.querySelector('.toggle-button'), 'click', _ => this.onClickHandler());
    }

    onClickHandler() {
        if (this.isVisible) {
            this.isVisible = false;
            this.view.hide();
        } else {
            this.isVisible = true;
            this.view.show();
        }
    }
}

export default ClickToCallWidgetController;
