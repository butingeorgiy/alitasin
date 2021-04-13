import EventHandler from '../../core/EventHandler';
import flatpickr from 'flatpickr';

class TourFormBaseController extends EventHandler {
    constructor(nodes) {
        super();
        this.nodes = nodes;
    }

    initDateCalendar(input) {
        this.datePicker = flatpickr(input, {dateFormat: 'd.m.Y'});
    }
}

export default TourFormBaseController;
