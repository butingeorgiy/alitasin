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
    <title>{{ __('short-phrases.transfers') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.profile-hero')

    <section id="editTransfersSection" class="mt-10 mb-10">
        <div class="container mx-auto px-5">
            <div class="flex items-center mb-8">
                <p class="text-black text-2xl font-bold text-black">{{ __('short-phrases.transfers-editing') }}<span class="text-blue">.</span></p>
            </div>

            <div class="grid grid-cols-2 gap-10">
                <div class="flex flex-col">
                    <p class="mb-2 font-medium leading-5">{{ __('short-phrases.choose-airport') }}:</p>
                    <div class="flex items-center">
                        <input id="airportSelect"
                               type="text"
                               name="airport"
                               autocomplete="off"
                               class="w-full mt-auto mr-5"
                               placeholder="{{ __('short-phrases.search') }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="create airport-manage-button min-w-6 min-h-6 w-6 h-6 mr-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="update airport-manage-button disabled min-w-6 min-h-6 w-6 h-6 mr-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="delete airport-manage-button disabled min-w-6 min-h-6 w-6 h-6 text-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden restore airport-manage-button min-w-6 min-h-6 w-6 h-6 mr-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col">
                    <p class="mb-2 font-medium leading-5">{{ __('short-phrases.choose-destination') }}:</p>
                    <div class="flex items-center">
                        <input id="destinationSelect"
                               type="text"
                               name="destination"
                               autocomplete="off"
                               class="w-full mt-auto mr-5"
                               placeholder="{{ __('short-phrases.search') }}">

                        <svg xmlns="http://www.w3.org/2000/svg" class="create destination-manage-button min-w-6 min-h-6 w-6 h-6 mr-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="update destination-manage-button disabled min-w-6 min-h-6 w-6 h-6 mr-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="delete destination-manage-button disabled min-w-6 min-h-6 w-6 h-6 text-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>

                        <svg xmlns="http://www.w3.org/2000/svg" class="hidden restore destination-manage-button min-w-6 min-h-6 w-6 h-6 mr-4 text-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components.general.footer')

    @include('popups.airport')
    @include('popups.destination')
</body>
</html>
