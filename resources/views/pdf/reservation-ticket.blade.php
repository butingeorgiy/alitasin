<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        * {
            margin: 0;
            color: #123a65;
        }

        body {
            padding: 20px;
            font-family: DejaVu Sans, sans-serif;
            background-color: #e5e7eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td, th {
            font-size: 1.1em;
            border: 4px solid #1d4c82;
            padding: 14px;
            text-align: left;
        }

        h3 {
            margin-bottom: 14px;
        }

        td:nth-child(2n) {
            width: 45%;
        }

        .logo {
            width: 140px;
            margin-top: 7px;
        }

        .field-wrapper {
            display: flex;
        }

        .field-wrapper span {
            margin-left: 10px;
            padding-bottom: 2px;
            border-bottom: 2px solid #1d4c82;
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

    <table>
        <tr>
            <td>
                <img class="logo" src="{{ asset('images/logo.png') }}" alt="">
                <p style="position: relative; top: 16px; float: right">Ticket <b>№ {{ $reservation->id }}</b></p>
            </td>
            <td>
                <div class="field-wrapper" style="margin-bottom: 10px">
                    <p>Tour: <span>{{ $tour->title['en'] }}</span></p>
                </div>

                <div class="field-wrapper">
                    <p>Date: <span>
                            @php
                                $reservationDate = $reservation->date;

                                if ($reservationDate) {
                                    echo \Illuminate\Support\Carbon::parse($reservationDate)->format('d.m.Y');
                                } else {
                                    echo 'Not specified';
                                }
                            @endphp
                        </span></p>
                </div>
            </td>
        </tr>

        <tr>
            <td>
                <h3>Contact information:</h3>
                <div class="field-wrapper" style="margin-bottom: 10px">
                    <p>Name: <span>{{ $user->full_name }}</span></p>
                </div>

                <div class="field-wrapper" style="margin-bottom: 10px">
                    <p>Hotel: <span>{{ $reservation->hotel_name ?: 'Not specified' }}</span></p>
                </div>

                <div class="field-wrapper">
                    <p>Hotel room: <span>{{ $reservation->hotel_room_number ?: 'Not specified' }}</span></p>
                </div>
            </td>
            <td>
                <h3>Cost information:</h3>
                <div class="field-wrapper" style="margin-bottom: 10px">
                    <p>Price: <span>$ {{ $reservation->total_cost_without_sale }}</span> <i>(without discount)</i></p>
                </div>

                <div class="field-wrapper" style="margin-bottom: 10px">
                    <p>Deposit: <span>$ 0</span></p>
                </div>

                <div class="field-wrapper" style="margin-bottom: 10px">
                    <p>Promo code discount: <span>
                        @php
                            if ($reservation->isUsedPromoCode()) {
                                echo '$ ' . ($reservation->total_cost_without_sale * $reservation->promo_code_init_sale_percent / 100);
                            } else {
                                echo '$ 0';
                            }
                        @endphp
                    </span></p>
                </div>

                <div class="field-wrapper">
                    <p>Rest: <span>
                        @php
                            if ($reservation->isUsedPromoCode()) {
                                echo '$ ' . ($reservation->total_cost_without_sale * (100 - $reservation->promo_code_init_sale_percent) / 100);
                            } else {
                                echo '$ ' . $reservation->total_cost_without_sale;
                            }
                        @endphp
                    </span></p>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <h3>Tickets:</h3>
                <div>
                    @foreach($reservation->tickets()->withPivot(['amount'])->get() as $index => $ticket)
                        <p style="margin-bottom: 10px">{{ ++$index }}. {{ $ticket['en_name'] }} x {{ $ticket->getOriginal('pivot_amount') }}</p>
                    @endforeach
                </div>
            </td>
        </tr>
    </table>
</body>
</html>