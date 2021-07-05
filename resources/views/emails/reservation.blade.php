<!doctype html>
<html lang='{{ App::getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Reservation Ticket</title>
    <style>
        * {
            color: #231F20;
        }

        table {
            font-family: arial, sans-serif;
            width: 100%;
            border-collapse: collapse;
        }

        p {
            font-size: 1.1em;
        }

        td, th {
            font-size: 1.1em;
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    @php
        /**
         * @var App\Models\User $user
         * @var App\Models\Reservation $reservation
         * @var App\Models\Tour $tour
         */
    @endphp
    <h2>{{ __('emails.reservation-successfully-formed', ['id' => $reservation->id]) }}</h2>
    <p>{{ __('emails.reservation-email-description') }}</p>
    <br>
    <h3>{{ __('emails.contact-information') }}:</h3>
    <table>
        <tr>
            <td>{{ __('short-phrases.first-name') }}:</td>
            <td>{{ $user->full_name }}</td>
        </tr>
        <tr>
            <td>{{ __('short-phrases.phone') }}:</td>
            <td>+ {{ $user->phone }}</td>
        </tr>
        <tr>
            <td>E-mail:</td>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <td>{{ __('short-phrases.convenient-way-communication') }}:</td>
            <td>{{ $reservation->communication_type ?: __('short-phrases.not-specified') }}</td>
        </tr>
        <tr>
            <td>{{ __('short-phrases.hotel') }}:</td>
            <td>{{ $reservation->hotel_name ?: __('short-phrases.not-specified') }}</td>
        </tr>
        <tr>
            <td>{{ __('short-phrases.hotel-room') }}:</td>
            <td>{{ $reservation->hotel_room_number ?: __('short-phrases.not-specified') }}</td>
        </tr>
        <tr>
            <td>{{ __('short-phrases.region') }}:</td>
            <td>
                @php
                    /** @var App\Models\Region|null $region */
                    $region = $reservation->region()->first();

                    if ($region) {
                        echo $region->name;
                    } else {
                        echo __('short-phrases.not-specified');
                    }
                @endphp
            </td>
        </tr>
    </table>
    <br>
    <h3>{{ __('short-phrases.excursion') }}:</h3>
    <table>
        <tr>
            <td>{{ __('short-phrases.name') }}:</td>
            <td>{{ $tour->title[App::getLocale()] }}</td>
        </tr>
        <tr>
            <td>{{ __('short-phrases.holding-date') }}:</td>
            <td>
                @php
                    $reservationDate = $reservation->date;

                    if ($reservationDate) {
                        echo \Illuminate\Support\Carbon::parse($reservationDate)->format('d.m.Y');
                    } else {
                        echo __('short-phrases.not-specified');
                    }
                @endphp
            </td>
        </tr>
    </table>
    <br>
    <h3>{{ __('short-phrases.tickets') }}:</h3>
    <table>
        <tr>
            <th>{{ __('short-phrases.name') }}:</th>
            <th>{{ __('short-phrases.amount') }}:</th>
            <th>{{ __('short-phrases.price') }}:</th>
        </tr>
        @php /** @var App\Models\Ticket $ticket */ @endphp
        @foreach($reservation->tickets()->withPivot(['amount', 'percent_from_init_cost'])->get() as $ticket)
            <tr>
                <td>{{ $ticket->name }}</td>
                <td>{{ $ticket->getOriginal('pivot_amount') }}</td>
                <td>${{ $reservation->tour_init_price * $ticket->getOriginal('pivot_percent_from_init_cost') / 100 }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="2"><b>{{ __('short-phrases.payed') }}:</b></td>
            <td>$0</td>
        </tr>
        <tr>
            <td colspan="2"><b>{{ __('emails.discount-by-promo-code') }}:</b></td>
            <td>
                @php
                    if ($reservation->isUsedPromoCode()) {
                        echo '$' . ($reservation->total_cost_without_sale * $reservation->promo_code_init_sale_percent / 100);
                    } else {
                        echo '$0';
                    }
                @endphp
            </td>
        </tr>
        <tr>
            <td colspan="2"><b>{{ __('short-phrases.total-cost') }}:</b></td>
            <td>
                @php
                    if ($reservation->isUsedPromoCode()) {
                        echo '$' . ($reservation->total_cost_without_sale * (100 - $reservation->promo_code_init_sale_percent) / 100);
                    } else {
                        echo '$' . ($reservation->total_cost_without_sale);
                    }
                @endphp
            </td>
        </tr>
    </table>
</body>
</html>