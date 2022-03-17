import ClickToCallWidgetController from './ClickToCallWidgetController';

document.addEventListener('DOMContentLoaded', _ => {
    const widget = document.querySelector('.click-to-call-widget');

    if (widget) {
        new ClickToCallWidgetController({
            widget
        });
    }
});