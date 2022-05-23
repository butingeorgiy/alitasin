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
    <title>{{ __('short-phrases.partnership') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.hero', ['title' => __('short-phrases.partnership')])

    <section id="partnershipSection" class="mt-10 mb-6 sm:pb-6">
        <div class="container mx-auto px-5">
            <h1 class="mb-4 text-2xl font-bold">
                <?php

                if (app()->getLocale() === 'ru') {
                    echo 'Система партнёров в Alitasin' . '<span class="text-blue">.</span>';
                } else if (app()->getLocale() === 'en') {
                    echo 'Partner system in Alitasin' . '<span class="text-blue">.</span>';
                } else if (app()->getLocale() === 'tr') {
                    echo 'Alitasin\'de partner sistemi' . '<span class="text-blue">.</span>';
                } else if (app()->getLocale() === 'ua') {
                    echo 'Партнерська система в Alitasin' . '<span class="text-blue">.</span>';
                }

                ?>
            </h1>

            <ul class="list-disc">
                <li class="mb-2">
                    <?php

                    if (app()->getLocale() === 'ru') {
                        echo 'Мы разработали систему партнёров, которая позволит любому желающему стать частью команды Alitasin.';
                    } else if (app()->getLocale() === 'en') {
                        echo 'We have designed a partner system that will allow anyone to become part of the Alitasin team.';
                    } else if (app()->getLocale() === 'tr') {
                        echo 'Herkesin Alitaşin ekibinin bir parçası olmasına izin verecek bir ortak sistemi tasarladık.';
                    } else if (app()->getLocale() === 'ua') {
                        echo 'Ми розробили партнерську систему, яка дозволить будь-кому стати частиною команди Alitasin.';
                    }

                    ?>
                </li>

                <li class="mb-2">
                    <?php

                    if (app()->getLocale() === 'ru') {
                        echo 'Зарегистрируйтесь в качестве партнёра и делитесь своим промо кодом с людьми. С каждого привлеченного клиента вы будете получать доход от 5% и выше.';
                    } else if (app()->getLocale() === 'en') {
                        echo 'Register as partner and share your promo code with anyone. From each person you attract you receive income of 5% and above.';
                    } else if (app()->getLocale() === 'tr') {
                        echo 'Ortak olarak kaydolun ve promosyon kodunuzu herkesle paylaşın. Çektiğiniz her kişiden %5 ve üzeri gelir elde edersiniz.';
                    } else if (app()->getLocale() === 'ua') {
                        echo 'Зареєструйтеся як партнер і поділіться своїм промо-кодом з будь-ким. Від кожної залученої людини ви отримуєте дохід від 5% і вище.';
                    }

                    ?>
                </li>

                <li class="mb-2">
                    <?php

                    if (app()->getLocale() === 'ru') {
                        echo 'Более того, вы можете привлекать других партнёров, с которых вы будете получать пассивный доход.';
                    } else if (app()->getLocale() === 'en') {
                        echo 'Moreover, you can attract other partners from whom you will receive passive income.';
                    } else if (app()->getLocale() === 'tr') {
                        echo 'Ayrıca, pasif gelir elde edeceğiniz diğer ortakları da çekebilirsiniz.';
                    } else if (app()->getLocale() === 'ua') {
                        echo 'Більш того, ви можете залучити інших партнерів, від яких будете отримувати пасивний дохід.';
                    }

                    ?>
                </li>

                <li>
                    <?php

                    if (app()->getLocale() === 'ru') {
                        echo 'P.S. вступить в нашу команду можно прямо сейчас и абсолютно бесплатно.';
                    } else if (app()->getLocale() === 'en') {
                        echo 'P.S. you can join our team right now and absolutely free.';
                    } else if (app()->getLocale() === 'tr') {
                        echo 'P.S. ekibimize hemen ve tamamen ücretsiz katılabilirsiniz.';
                    } else if (app()->getLocale() === 'ua') {
                        echo 'P.S. ви можете зробити нашу команду правом на сьогоднішній день і абсолютно безкоштовно.';
                    }

                    ?>
                </li>
            </ul>

            <h2 class="mt-10 mb-6 text-center text-xl font-bold">
                <?php

                if (app()->getLocale() === 'ru') {
                    echo 'Хочу стать' .  '<span class="text-blue"> партнёром.</span>';
                } else if (app()->getLocale() === 'en') {
                    echo 'Wish to become a' .  '<span class="text-blue"> partner.</span>';
                } else if (app()->getLocale() === 'tr') {
                    echo 'Ortak olmak' .  '<span class="text-blue"> dileğiyle.</span>';
                } else if (app()->getLocale() === 'ua') {
                    echo 'Бажання стати' .  '<span class="text-blue"> партнером.</span>';
                }

                ?>
            </h2>

            <div class="flex flex-col items-center">
                <form class="flex flex-col w-80">
                    <input type="text"
                           name="first_name"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.enter-first-name') }}"
                           autocomplete="off">

                    <input type="email"
                           name="email"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.enter-email') }}"
                           autocomplete="off">

                    <input type="text"
                           name="phone"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.enter-phone') }}"
                           autocomplete="off">

                    <input type="text"
                           name="city"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.enter-city') }}"
                           autocomplete="off">

                    <input type="text"
                           name="promo_code"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.promo-code') }}"
                           autocomplete="off">

                    <input type="text"
                           name="partner_code"
                           class="w-80 mb-1 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.partner-promo-code') }} ({{ __('short-phrases.if-have') }})"
                           autocomplete="off">

                    <p class="mb-5 text-sm text-gray-600 font-light">
                        <?php

                        if (app()->getLocale() === 'ru') {
                            echo 'Если вы хотите зарегистрироваться под каким-либо партнёром, то укажите его промо-код здесь.';
                        } else if (app()->getLocale() === 'en') {
                            echo 'If you want to register under specific partner, then enter his / her promo code here.';
                        } else if (app()->getLocale() === 'tr') {
                            echo 'Belirli bir ortak altında kaydolmak istiyorsanız, promosyon kodunu buraya girin.';
                        } else if (app()->getLocale() === 'ua') {
                            echo 'Якщо ви хочете зареєструватися під певним партнером, то введіть тут його промокод.';
                        }

                        ?>
                    </p>

                    <input type="password"
                           name="password"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.password') }}"
                           autocomplete="off">

                    <input type="password"
                           name="password_confirmation"
                           class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md"
                           placeholder="{{ __('short-phrases.confirm-password') }}"
                           autocomplete="off">

                    <div class="hidden error-message flex items-center mb-4 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
                        <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Some error...</span>
                    </div>

                    <div class="send-partner-reg-button w-80 bg-blue">
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