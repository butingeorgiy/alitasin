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
    @include('components.general.header')
    @include('components.general.profile-hero')

    <section id="partnersSection" class="mt-10 mb-10">
        <div class="container mx-auto px-5">
            <div class="flex items-center mb-5">
                <p class="mr-5 text-black text-2xl font-bold text-black">{{ __('short-phrases.partners') }}<span class="text-blue">.</span></p>
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
                    <span>{{ __('short-phrases.add-partner') }}</span>
                </div>

                <div class="partners-search-wrapper" style="width: 450px">
                    <input type="text" name="search" placeholder="{{ __('short-phrases.search') }}"
                           autocomplete="off" class="w-full text-sm text-gray-500 bg-gray-50 placeholder-gray-500">
                    <svg class="animate-spin ml-3 h-5 w-5 text-blue hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <!-- Partners search output container -->
                    <div class="partners-search-results-container hidden absolute flex flex-col top-full left-0 z-10 w-full mt-2 bg-white rounded-md shadow-md overflow-y-scroll" style="max-height: 220px"></div>
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
                @foreach($partners as $partner)
                    @php /** @var App\Models\User $partner */ @endphp

                    @if($partner->isSubPartner())
                        @continue
                    @endif

                    @include('components.partners.partner-table-item')
                @endforeach
            </div>
        </div>
    </section>

    @include('components.general.footer')

    @include('popups.create-partner')
    @include('popups.partner-payment')
    @include('popups.update-profit-percent')
</body>
</html>
