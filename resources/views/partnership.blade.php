<!doctype html>
<html lang='{{ app()->getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('css/index.css') }}'>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ __('page-titles.property') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.hero', ['title' => __('short-phrases.partnership')])

    <section id="partnershipSection" class="mt-10 mb-6 sm:pb-6">
        <div class="container mx-auto px-5">
            <h1 class="mb-4 text-2xl font-bold">Система партнёров в Alitasin<span class="text-blue">.</span></h1>

            <p>Скоро тут появится детальное описание системы партнёров :)</p>

            <h2 class="mt-10 mb-6 text-center text-xl font-bold">Хочу стать <span class="text-blue">партнёром.</span></h2>

            <div class="flex flex-col items-center">
                <form class="flex flex-col w-80">
                    <input type="text"
                           name="first_name"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Ваше имя"
                           autocomplete="off">

                    <input type="email"
                           name="last_name"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Введите E-mail"
                           autocomplete="off">

                    <input type="text"
                           name="phone"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Ваш номер телефона"
                           autocomplete="off">

                    <input type="text"
                           name="city"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Ваш город"
                           autocomplete="off">

                    <input type="text"
                           name="promo_code"
                           class="w-80 mb-1 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Промо-код партнёра"
                           autocomplete="off">

                    <p class="mb-5 text-sm text-gray-600 font-light">Если вы хотите зарегистрироваться под каким-либо партнёром, то укажите его промо-код здесь.</p>

                    <input type="password"
                           name="password"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Придумайте пароль"
                           autocomplete="off">

                    <input type="password"
                           name="password_confirmation"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="Подтвердите пароль"
                           autocomplete="off">

                    <div class="error-message flex items-center mb-4 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
                        <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Some error...</span>
                    </div>

                    <div class="save-book-button w-80 bg-blue">
                        <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('buttons.create-account') }}</span>
                    </div>
                </form>
            </div>
        </div>
    </section>

    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.login')
    @include('popups.reg')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>