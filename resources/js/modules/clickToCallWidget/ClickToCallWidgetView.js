class ClickToCallWidgetView {
    constructor(nodes) {
        this.toggleButtonNode = nodes.toggleButtonNode;
        this.linksWrapperNode = nodes.linksWrapperNode;
    }

    show() {
        // Button animation
        this.toggleButtonNode.querySelector('.hide-widget-icon').classList.remove('hidden');
        setTimeout(_ => this.toggleButtonNode.querySelector('.hide-widget-icon').classList.add('opacity-100'), 0);

        this.toggleButtonNode.querySelector('.show-widget-icon').classList.remove('opacity-100');
        this.toggleButtonNode.querySelector('.show-widget-icon').classList.add('hidden');

        // Links animation
        this.linksWrapperNode.classList.remove('hidden');
        setTimeout(_ => {
            this.linksWrapperNode.classList.add('scale-100');
            this.linksWrapperNode.classList.add('opacity-100');
        }, 0);
    }

    hide() {
        // Button animation
        this.toggleButtonNode.querySelector('.show-widget-icon').classList.remove('hidden');
        setTimeout(_ => this.toggleButtonNode.querySelector('.show-widget-icon').classList.add('opacity-100'), 0);

        this.toggleButtonNode.querySelector('.hide-widget-icon').classList.remove('opacity-100');
        this.toggleButtonNode.querySelector('.hide-widget-icon').classList.add('hidden');

        // Links animation
        this.linksWrapperNode.classList.remove('scale-100');
        this.linksWrapperNode.classList.remove('opacity-100');
        setTimeout(_ => this.linksWrapperNode.classList.add('hidden'), 200);
    }
}

export default ClickToCallWidgetView;
