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
    <title>{{ __('page-titles.partners') }}</title>
</head>
<body class="bg-gray-50">
    @php /** @var App\Models\User $partner */ @endphp

    @include('components.general.header')

    <section id="heroSection" class="flex justify-center items-center relative px-5 bg-center bg-cover bg-no-repeat"
             style="background-image: url({{ asset('images/profile-hero-bg.jpg') }})">
        <p class="relative -top-5 text-white text-3xl lg:text-6xl text-center font-bold tracking-wide">{{ __('short-phrases.partner') }}, {{ $partner->first_name }}</p>
        <label class="flex justify-center items-center absolute -bottom-8 lg:-bottom-12 w-24 h-24 lg:w-32 lg:h-32 bg-blue bg-center bg-cover bg-no-repeat border-6 border-white rounded-full cursor-pointer"
               style="background-image: url({{ $partner->profile }})">
            @if(!$partner->profile)
                <svg class="w-16 h-16" viewBox="0 0 166 166" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M83.0002 76.0833C98.28 76.0833 110.667 63.6965 110.667 48.4167C110.667 33.1368 98.28 20.75 83.0002
                      20.75C67.7203 20.75 55.3335 33.1368 55.3335 48.4167C55.3335 63.6965 67.7203 76.0833 83.0002 76.0833Z"
                          stroke="white" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M110.887 146.233C120.488 144.505 128.099 141.872 131.637 138.333C132.135 133.859 131.637 126.805
                      131.637 126.805C131.637 120.691 128.723 114.827 123.534 110.503C107.149 96.8484 52.3761 96.8484 35.9908
                      110.503C30.8023 114.827 27.8875 120.691 27.8875 126.805C27.8875 126.805 27.3903 133.859 27.8875 138.333C31.4258
                      141.872 39.037 144.505 48.6374 146.233" stroke="white" stroke-width="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            @endif
        </label>
    </section>

    @include('components.profile.personal-info', ['user' => $partner])

    @php

    // Promo code info calculation

    $promoCodeInfo = [
        'promoCode' => $partner->promoCodes()->first()['code'],
        'salePercent' => $partner->promoCodes()->first()['sale_percent'],
        'profitPercent' => $partner->profit_percent
    ];

    if ($partner->isSubPartner()) {
        $promoCodeInfo['subPartnerProfitPercent'] = $partner->sub_partners_profit_percent;
    }


    // Promo code statistic calculation

    $promoCodeStatistic = [
        'attractedReservations' => $partner->attractedReservations()->count(),
        'attractedTransfers' => $partner->attractedTransfers()->count(),
        'attractedVehicles' => $partner->attractedVehicles()->count(),
        'income' => $partner->getTotalIncome(),
        'earned' => $partner->getTotalProfit(),
        'payed' => $partner->getPaymentAmount()
    ];

    @endphp

    @include('components.partners.promo-code-info', $promoCodeInfo)
    @include('components.partners.promo-code-statistic', $promoCodeStatistic)

    @if(!$isSubPartner)
        <section id="partnersSection" class="mt-10 mb-10">
            <div class="container mx-auto px-5">
                <div class="flex items-center mb-5">
                    <p class="mr-5 text-black text-2xl font-bold text-black">{{ __('short-phrases.sub-partners') }}<span class="text-blue">.</span></p>
                    <div class="open-create-partner-popup-button flex justify-center items-center px-8 py-2 text-sm text-white font-medium rounded-md bg-green cursor-pointer">
                        <svg class="mr-3 h-4 w-4 text-white" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.3333 9.66671H12.3333V1.66671C12.3333 1.31309 12.1928 0.973947 11.9427 0.723899C11.6927 0.47385 11.3535 0.333374 10.9999
                                             0.333374C10.6463 0.333374 10.3072 0.47385 10.0571 0.723899C9.80706 0.973947 9.66658 1.31309 9.66658 1.66671V9.66671H1.66659C1.31296
                                             9.66671 0.973825 9.80718 0.723776 10.0572C0.473728 10.3073 0.333252 10.6464 0.333252 11C0.333252 11.3537 0.473728 11.6928 0.723776
                                             11.9428C0.973825 12.1929 1.31296 12.3334 1.66659 12.3334H9.66658V20.3334C9.66658 20.687 9.80706 21.0261 10.0571 21.2762C10.3072 21.5262
                                             10.6463 21.6667 10.9999 21.6667C11.3535 21.6667 11.6927 21.5262 11.9427 21.2762C12.1928 21.0261 12.3333 20.687 12.3333
                                             20.3334V12.3334H20.3333C20.6869 12.3334 21.026 12.1929 21.2761 11.9428C21.5261 11.6928 21.6666 11.3537 21.6666 11C21.6666
                                             10.6464 21.5261 10.3073 21.2761 10.0572C21.026 9.80718 20.6869 9.66671 20.3333 9.66671Z" fill="white"/>
                        </svg>
                        <span>{{ __('short-phrases.add-sub-partner') }}</span>
                    </div>
                </div>
                <div class="partners-container bg-white border border-gray-200 rounded-md">
                    <!-- Table head -->
                    <div class="grid grid-cols-partners-table gap-5 px-8 pt-4 pb-1 border-b border-gray-200">
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.partner') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.promo-code') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.income') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.earned') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.payed') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.status') }}</div>
                    </div>
                    <!-- Table body -->
                    @forelse($subPartners as $partner)
                        @include('components.partners.partner-table-item')
                    @empty
                        <div class="flex justify-center py-3 text-black font-light">{{ __('short-phrases.empty-list') }}</div>
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    @include('components.general.footer')

    @include('popups.create-partner')
    @include('popups.partner-payment')
    @include('popups.update-profit-percent')
</body>
</html>
