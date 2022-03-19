import EventHandler from '../../core/EventHandler';
import flatpickr from 'flatpickr';
import {Russian} from 'flatpickr/dist/l10n/ru.js';
import {Turkish} from 'flatpickr/dist/l10n/tr.js';
import LocaleHelper from '../../helpers/LocaleHelper';
import BookTourView from './BookTourView';
import BookTourModel from './BookTourModel';
import DateHelper from '../../helpers/DateHelper';
import Cookies from 'js-cookie';

class BookTourController extends EventHandler {
    constructor(nodes) {
        super();

        this.nodes = nodes;
        this.promoCodeLoading = false;
        this.loading = false;
        this.promoCode = {
            value: null,
            sale: null
        };
        this.initCost = null;
        this.view = new BookTourView({
            totalCostNode: nodes.form.querySelector('.total-cost'),
            promoCodeContainer: nodes.form.querySelector('.promo-code'),
            promoCodeInput: nodes.promoCodeInput,
            checkPromoCodeButton: nodes.checkPromoCodeButton,
            resetPromoCodeButton: nodes.resetPromoCodeButton,
            error: nodes.error,
            success: nodes.success,
            reserveTourButton: nodes.reserveTourButton
        });
        this.isUserAuth = nodes.generalInfoForm.getAttribute('data-is-auth') === '1';

        this.getCost();
        this.initDatePicker();
        this.initTicketsChoice();

        this.addEvent(nodes.checkPromoCodeButton, 'click', _ => {
            const code = nodes.promoCodeInput.value;

            if (!this.promoCodeLoading && this.promoCode.sale === null && code) {
                this.promoCodeLoading = true;
                this.checkPromoCode(code);
            }
        });

        this.addEvent(nodes.resetPromoCodeButton, 'click', _ => {
            this.promoCode = {
                value: null,
                sale: null
            };
            this.view.removePromoCodeActiveStatus();
            this.showTicketsChanges();
        });

        this.addEvent(nodes.reserveTourButton, 'click', _ => {
            if (!this.loading) {
                this.loading = true;
                this.reserve();
            }
        });
    }

    getDataBeforeReserving() {
        const formData = new FormData();

        if (this.nodes.form.querySelector('input[name="hotel_name"]').value) {
            formData.append('hotel_name', this.nodes.form.querySelector('input[name="hotel_name"]').value);
        }

        if (this.nodes.form.querySelector('input[name="hotel_room_number"]').value) {
            formData.append('hotel_room_number', this.nodes.form.querySelector('input[name="hotel_room_number"]').value);
        }

        if (this.nodes.form.querySelector('select[name="communication_type"]').value) {
            formData.append('communication_type', this.nodes.form.querySelector('select[name="communication_type"]').value);
        }

        if (this.nodes.form.querySelector('select[name="region_id"]').value) {
            formData.append('region_id', this.nodes.form.querySelector('select[name="region_id"]').value);
        }

        if (this.datePicker.selectedDates.length !== 0) {
            formData.append('date', DateHelper.format(this.datePicker.selectedDates[0]));
        }

        if (this.promoCode.value) {
            formData.append('promo_code', this.promoCode.value);
        }

        let tickets = [];

        this.tickets.forEach(ticket => {
            tickets.push({
                id: ticket.id,
                amount: ticket.amount
            });
        });

        formData.append('tickets', JSON.stringify(tickets));

        if (!this.isUserAuth) {
            if (this.nodes.generalInfoForm.querySelector('input[name="first_name"]').value) {
                formData.append('first_name', this.nodes.generalInfoForm.querySelector('input[name="first_name"]').value);
            }

            if (this.nodes.generalInfoForm.querySelector('input[name="email"]').value) {
                formData.append('email', this.nodes.generalInfoForm.querySelector('input[name="email"]').value);
            }

            if (this.nodes.generalInfoForm.querySelector('input[name="phone"]').value.replace(/\D/g, '')) {
                formData.append('phone', this.nodes.generalInfoForm.querySelector('input[name="phone"]').value.replace(/\D/g, ''));
            }
        }

        return formData;
    }

    initTicketsChoice() {
        let tickets = [];

        this.nodes.form.querySelectorAll('.ticket-item').forEach(ticket => {
            const ticketId = ticket.getAttribute('data-ticket-id'),
                ticketCost = ticket.getAttribute('data-ticket-cost'),
                minusButton = ticket.querySelector('.minus-ticket-button'),
                plusButton = ticket.querySelector('.plus-ticket-button');

            tickets.push({
                id: ticketId,
                amount: 0,
                price: ticketCost,
                amountNode: ticket.querySelector('.tickets-amount')
            });

            this.addEvent(minusButton, 'click', _ => this.ticketAmountChangeHandler(ticketId, 'minus', minusButton));
            this.addEvent(plusButton, 'click', _ => this.ticketAmountChangeHandler(ticketId, 'plus', minusButton));
        });

        this.tickets = tickets;
    }

    ticketAmountChangeHandler(id, mode, btnNode = null) {
        this.tickets.forEach(ticket => {
            if (ticket.id === id) {
                if (mode === 'minus') {
                    if (ticket.amount > 0) {
                        ticket.amount--;

                        if (ticket.amount === 0) {
                            BookTourView.disableTicketAmountChangeButton(btnNode);
                        } else {
                            BookTourView.enableTicketAmountChangeButton(btnNode);
                        }

                        this.showTicketsChanges();
                    }
                } else {
                    ticket.amount++;
                    BookTourView.enableTicketAmountChangeButton(btnNode);
                    this.showTicketsChanges();
                }
            }
        });
    }

    showTicketsChanges() {
        let totalCost = 0;

        this.tickets.forEach(ticket => {
            totalCost += ticket.price * ticket.amount;
        });

        if (this.promoCode.sale !== null) {
            totalCost -= totalCost * this.promoCode.sale / 100;
        }

        this.view.renderFormChanges(this.tickets, totalCost);
    }

    getCost() {
        this.initCost = parseFloat(this.nodes.form.getAttribute('data-init-cost'));
        this.nodes.form.removeAttribute('data-init-cost');
    }

    initDatePicker() {
        let locale = LocaleHelper.getLocale();
        const input = this.nodes.form.querySelector('input[name="tour_date"]');

        if (locale === 'ru') {
            locale = Russian;
        } else if (locale === 'tr') {
            locale = Turkish;
        } else {
            locale = null;
        }

        const allowDays = [];

        JSON.parse(input.getAttribute('data-allow-days')).forEach(day => {
            switch (day) {
                case 'mon':
                    allowDays.push(1);
                    break;
                case 'tue':
                    allowDays.push(2);
                    break;
                case 'wed':
                    allowDays.push(3);
                    break;
                case 'thu':
                    allowDays.push(4);
                    break;
                case 'fri':
                    allowDays.push(5);
                    break;
                case 'sat':
                    allowDays.push(6);
                    break;
                case 'sun':
                    allowDays.push(0);
                    break;
            }
        });

        this.datePicker = flatpickr(input, {
            inline: true,
            minDate: new Date(),
            enable: [
                date => {
                    return allowDays.includes(date.getDay());
                }
            ],
            locale
        });
    }

    checkPromoCode(code) {
        BookTourModel.getPromoCodeSale(code)
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                } else if (result.error) {
                    alert(result.message);
                } else {
                    this.promoCode = {
                        value: code,
                        sale: result.sale_percent
                    };

                    this.view.setPromoCodeActiveStatus(result.sale_percent);
                    this.showTicketsChanges();
                }
            })
            .catch(error => {
                alert(`Error: ${error}`);
            })
            .finally(_ => {
                this.promoCodeLoading = false;
            });
    }

    reserve() {
        this.view.showLoading();
        this.view.hideError();

        BookTourModel.reserve(this.getDataBeforeReserving(), location.pathname.split('/')[2])
            .then(result => {
                if (typeof result === 'string') {
                    alert(`Error: ${result}`);
                    this.loading = false;
                } else if (result.error) {
                    this.view.showError(result.message);
                    this.loading = false;
                } else {
                    this.view.disableReserveButton();
                    this.view.showSuccess(result.message);

                    if (result.cookies) {
                        Cookies.set('id', result.cookies.id, {expires: 7});
                        Cookies.set('token', result.cookies.token, {expires: 7});
                    }

                    setTimeout(_ => location.reload(), 500);
                }
            })
            .catch(error => alert(`Error: ${error}`))
            .finally(_ => {
                this.view.hideLoading();
            });
    }
}

export default BookTourController;
