<!doctype html>
<html lang='{{ App::getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Transfer Request Created</title>
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
    @php /** @var App\Models\TransferRequest $transferRequest */ @endphp
    <h2>Заявка на трансфер!</h2>

    <br>
    <h3>Контактная информация:</h3>
    <table>
        <tr>
            <td>Имя:</td>
            <td>{{ $transferRequest->user_name }}</td>
        </tr>
        <tr>
            <td>Номер телефона:</td>
            <td>+ {{ format_phone_number($transferRequest->user_phone) }}</td>
        </tr>
        <tr>
            <td>E-mail:</td>
            <td>{{ $transferRequest->user_email }}</td>
        </tr>
    </table>

    <br>
    <h3>Трансфер:</h3>
    <table>
        <tr>
            <td>Тип:</td>
            <td>{{ $transferRequest->type['ru_name'] }}</td>
        </tr>
        <tr>
            <td>Аэропорт:</td>
            <td>{{ $transferRequest->airport['ru_name'] }}</td>
        </tr>
        <tr>
            <td>Направление:</td>
            <td>{{ $transferRequest->destination['ru_name'] }}</td>
        </tr>
        <tr>
            <td>Вместимость:</td>
            <td>{{ $transferRequest->capacity['ru_name'] ?? 'Не указано' }}</td>
        </tr>
        <tr>
            <td>Отправление:</td>
            <td>{{ $transferRequest->departure ?: 'Не указано' }}</td>
        </tr>
        <tr>
            <td>Прибытие:</td>
            <td>{{ $transferRequest->arrival ?: 'Не указано' }}</td>
        </tr>
    </table>

    <br>
    <h3>Стоимость:</h3>
    <table>
        <tr>
            <td>Промо код:</td>
            <td>
                @php

                $promoCode = $transferRequest->promoCode;

                if (!$promoCode) {
                    return 'Не указано';
                }

                echo $promoCode->code . " ($promoCode->sale_percent)%";

                @endphp
            </td>
        </tr>
        <tr>
            <td>Цена (со скидкой):</td>
            <td>$ {{ number_format($transferRequest->costWithSale(), 2, '.', ' ') }}</td>
        </tr>
    </table>
</body>
</html>

