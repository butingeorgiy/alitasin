<!doctype html>
<html lang='{{ App::getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('css/index.css') }}'>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ __('page-titles.personal-partner-cabinet') }}</title>
</head>
<body class="bg-gray-50">
    @include('components.general.header')
    @include('components.general.profile-hero')
    @include('components.profile.personal-info')

    @php

    /** @var App\Models\User $user */
    /** @var App\Models\Partner $partner */

    // Promo code info calculation

    $promoCodeInfo = [
        'promoCode' => $partner->promoCodes()->first()['code'],
        'salePercent' => $partner->promoCodes()->first()['sale_percent'],
        'profitPercent' => $partner->profit_percent
    ];

    if ($partner->isSubPartner()) {
        $promoCodeInfo['subPartnerProfitPercent'] = 0;
    }


    // Promo code statistic calculation

    $promoCodeStatistic = [
        'attractedReservations' => $partner->attractedReservations()->count(),
        'attractedTransfers' => $partner->attractedTransfers()->count(),
        'attractedVehicles' => $partner->attractedVehicles()->count(),
        'income' => $partner->company_income,
        'earned' => $partner->earned_profit,
        'payed' => $partner->received_profit
    ];

    @endphp

    @include('components.partners.promo-code-info', $promoCodeInfo)
    @include('components.partners.promo-code-statistic', $promoCodeStatistic)

    <section id="reservesSection" class="mt-10 mb-10">
        <div class="container mx-auto px-5">
            <p class="mb-3 text-black text-2xl font-bold text-black">{{ __('short-phrases.reserves') }}<span class="text-blue">.</span></p>

            <div class="reserves-container bg-white border border-gray-200 rounded-md">
                <!-- Reserve table header  -->
                @if(count($reservations) > 0)
                    <div class="grid grid-cols-reserve-table gap-5 px-8 pt-3 pb-1 border-b border-gray-200">
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-offered-by') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-tour') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-offered-at') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-status') }}</div>
                    </div>
            @endif
            <!-- Reserve table items  -->
            @foreach($reservations as $reservation)
                @include('components.reserve.reserves-table-item', compact('reservation'))
            @endforeach
            <!-- Reserve table footer  -->
                <div class="px-8 py-4 {{ count($reservations) === 0 ? 'border-t border-gray-200' : '' }}">
                    <div class="flex">
                        <span class="text-sm text-gray-900 font-medium">Найдено записей:&nbsp;&nbsp;</span>
                        <span class="text-sm text-gray-800">{{ count($reservations) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.reserve-details')
    @include('popups.create-sub-partner')
</body>
</html>
