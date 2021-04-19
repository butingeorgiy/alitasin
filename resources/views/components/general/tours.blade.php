<section id="toursSection" class="mb-10 pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <div class="flex justify-between items-center lg:justify-center mb-4">
            <p class="inline text-black text-2xl font-bold text-black">{{ __('short-phrases.all-tours') }}<span class="text-blue">.</span></p>
            @if(count($tours) > 0)
                <span class="show-filters-button block lg:hidden px-5 py-1 text-sm text-blue border-2 border-blue rounded-md cursor-pointer">{{ __('short-phrases.filters') }}</span>
            @endif
        </div>
        <div class="flex items-start relative">
            <div class="left-side hidden lg:block absolute lg:relative right-0 z-10 mr-0 lg:mr-5">
                <div class="filters mb-0 lg:mb-5 bg-white shadow rounded-md">
                    <div class="flex flex-col py-4">
                        <p class="mb-3 px-3 text-xl text-black font-bold">{{ __('short-phrases.filters') }}</p>
                        <div class="flex flex-wrap mb-4 px-3 pb-4 gap-2 border-b border-gray-200">
                            @foreach(\App\Models\Filter::all() as $filter)
                                <div class="filter-item" data-filter-id="{{ $filter->id }}">
                                    <span
                                        class="text-blue">{{ $filterCounter[$filter->id] ?? 0 }}</span>&nbsp;&nbsp;{{ $filter->name }}
                                </div>
                            @endforeach
                            {{--                            <div--}}
                            {{--                                class="inline px-3 py-1 text-sm border border-black text-white bg-black rounded-full cursor-pointer">--}}
                            {{--                                {{ __('buttons.show-all') }}--}}
                            {{--                            </div>--}}
                        </div>

                        <p class="mb-3 px-3 text-xl text-black font-bold">{{ __('short-phrases.price') }}</p>
                        <div class="flex items-center mb-4 px-3 pb-4 border-b border-gray-200">
                            <svg class="min-w-5 min-w-5 w-5 h-5 mr-3" viewBox="0 0 19 23" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 7.5V13.2695L8.617 20.8796C8.78171 21.0445 8.9773 21.1754 9.1926
                                    21.2646C9.40789 21.3539 9.63866 21.3999 9.87172 21.3999C10.1048 21.3999
                                    10.3356 21.3539 10.5509 21.2646C10.7661 21.1754 10.9617 21.0445 11.1264
                                    20.8796L17.4843 14.5201C17.8146 14.1877 18 13.7381 18 13.2695C18 12.8008
                                    17.8146 12.3512 17.4843 12.0189L9.86729 4.39986H6M5.01 8.39986C5.01 8.39986
                                    5.00276 8.40262 5 8.39986C2.00001 5.39987 2.00001 -0.600156 7 1.39986"
                                    stroke="#0094FF"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                            <input type="text" name="price_from"
                                   class="w-20 px-2 py-1 text-sm text-center text-gray-600 placeholder-gray-600 border-2 border-black rounded-full"
                                   placeholder="{{ __('short-phrases.from') }}">
                            <div class="w-6 mx-4 border-b-2 border-black"></div>
                            <input type="text" name="price_to"
                                   class="w-20 px-2 py-1 text-sm text-center text-gray-600 placeholder-gray-600 border-2 border-black rounded-full"
                                   placeholder="{{ __('short-phrases.to') }}">
                        </div>

{{--                        <p class="mb-3 px-3 text-xl text-black font-bold">{{ __('short-phrases.date') }}</p>--}}
{{--                        <div class="flex items-center mb-4 px-3 pb-4 border-b border-gray-200">--}}
{{--                            <svg class="min-w-5 min-w-5 w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none"--}}
{{--                                 xmlns="http://www.w3.org/2000/svg">--}}
{{--                                <path--}}
{{--                                    d="M6 10H21V6C21 4.89543 20.1046 4 19 4H5C3.89543 4 3 4.89543 3 6V20C3--}}
{{--                                    21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13M17 18H13"--}}
{{--                                    stroke="#0094FF"--}}
{{--                                    stroke-width="2"--}}
{{--                                    stroke-linecap="round"--}}
{{--                                    stroke-linejoin="round"--}}
{{--                                />--}}
{{--                                <path d="M16 1V4" stroke="#0094FF" stroke-width="2" stroke-linecap="round"--}}
{{--                                      stroke-linejoin="round"/>--}}
{{--                                <path d="M8 1V4" stroke="#0094FF" stroke-width="2" stroke-linecap="round"--}}
{{--                                      stroke-linejoin="round"/>--}}
{{--                            </svg>--}}
{{--                            <input type="text" name="date_from"--}}
{{--                                   class="w-24 px-2 py-1 text-sm text-center text-gray-600 placeholder-gray-600 border-2 border-black rounded-full cursor-pointer"--}}
{{--                                   placeholder="{{ __('short-phrases.from') }}" readonly>--}}
{{--                            <div class="w-6 mx-4 border-b-2 border-black"></div>--}}
{{--                            <input type="text" name="date_to"--}}
{{--                                   class="w-24 px-2 py-1 text-sm text-center text-gray-600 placeholder-gray-600 border-2 border-black rounded-full cursor-pointer"--}}
{{--                                   placeholder="{{ __('short-phrases.to') }}" readonly>--}}
{{--                        </div>--}}

                        <p class="mb-3 px-3 text-xl text-black font-bold">{{ __('short-phrases.tour-types') }}</p>
                        <div class="flex flex-wrap mb-4 px-3 pb-4 gap-2 border-b border-gray-200">
                            @foreach(\App\Models\TourType::all() as $type)
                                <div
                                    class="type-items inline px-3 py-1 text-sm border-2 border-gray-600 rounded-full cursor-pointer"
                                    data-type-id="{{ $type->id }}">
                                    {{ $type->name }}
                                </div>
                            @endforeach
                        </div>

                        <button
                            class="reset-filters-button self-center text-sm text-gray-600 hover:underline cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed disabled:no-underline"
                            disabled>{{ __('buttons.reset-filters') }}</button>
                    </div>
                </div>
                <div class="hidden lg:block p-3 bg-gray-100 shadow rounded-md">
                    <p class="mb-3 text-black font-semibold leading-5">{{ __('short-phrases.connect-with-us-title') }}</p>
                    <a href="#" class="flex justify-center items-center mb-2 py-2 text-white font-semibold rounded-md"
                       style="background-color: #77E75B">
                        <svg class="min-w-5 min-w-5 w-5 h-5 mr-3" viewBox="0 0 33 33" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M28.1798 4.79746C26.6601 3.27055 24.8503 2.06 22.8559 1.23637C20.8615 0.412736 18.7223 -0.00751629
                                16.5631 0.000101744C7.51548 0.000101744 0.141861 7.33845 0.133573 16.3474C0.133573 19.2329 0.89186
                                22.0399 2.32349 24.5252L0.000976562 33L8.71092 30.7271C11.1205 32.0325 13.8199 32.7167 16.5631
                                32.7174H16.5714C25.6211 32.7174 32.9927 25.3791 33.001 16.3619C33.003 14.2128 32.5779 12.0846 31.7501
                                10.0999C30.9224 8.11513 29.7082 6.31305 28.1778 4.79746H28.1798ZM16.5631 29.9496C14.1163 29.9504
                                11.7144 29.2949 9.61009 28.0521L9.11285 27.7551L3.94573 29.1039L5.32556 24.0859L5.00236 23.5682C3.63455
                                21.4033 2.91116 18.8967 2.91603 16.3392C2.91603 8.86057 9.04241 2.75972 16.5714 2.75972C18.3651 2.75652
                                20.1416 3.10678 21.7987 3.79033C23.4557 4.47387 24.9604 5.47718 26.2261 6.74239C27.4962 8.00268 28.5031
                                9.50082 29.1887 11.1504C29.8742 12.8 30.225 14.5684 30.2206 16.3536C30.2123 23.859 24.0859 29.9496 16.5631
                                29.9496ZM24.0528 19.7732C23.6446 19.569 21.6287 18.5811 21.2496 18.4409C20.8725 18.3068 20.597 18.2367
                                20.3276 18.645C20.0521 19.0514 19.2648 19.9774 19.0286 20.2435C18.7924 20.5178 18.5479 20.5487 18.1377
                                20.3466C17.7296 20.1404 16.4057 19.7114 14.8394 18.315C13.617 17.2322 12.7986 15.8916 12.5541 15.4853C12.318
                                15.0769 12.5314 14.8583 12.7365 14.6541C12.9167 14.4726 13.1446 14.1756 13.3497 13.9405C13.5569 13.7054
                                13.6253 13.5321 13.76 13.2599C13.8946 12.9835 13.8304 12.7484 13.7289 12.5442C13.6253 12.34 12.8069 10.3249
                                12.4609 9.51232C12.1294 8.71001 11.7917 8.82139 11.539 8.81107C11.3028 8.79664 11.0272 8.79664 10.7517
                                8.79664C10.5436 8.80178 10.3388 8.8497 10.1502 8.93736C9.9616 9.02503 9.79323 9.15056 9.65567 9.30607C9.2786
                                9.71445 8.22404 10.7024 8.22404 12.7174C8.22404 14.7325 9.69503 16.6692 9.90222 16.9435C10.1053 17.2178
                                12.7903 21.3407 16.9112 23.1145C17.8849 23.5373 18.6515 23.7868 19.2503 23.9766C20.2344 24.2901 21.1232
                                24.2427 21.8318 24.1416C22.6191 24.022 24.2579 23.1516 24.6039 22.1967C24.9436 21.2397 24.9436 20.4229
                                24.8401 20.2517C24.7385 20.0785 24.463 19.9774 24.0528 19.7732Z"
                                fill="white"/>
                        </svg>
                        WhatsApp
                    </a>
                    <a href="#" class="flex justify-center items-center mb-2 py-2 text-white font-semibold rounded-md"
                       style="background-color: #3CA3E6">
                        <svg class="min-w-5 min-w-5 w-5 h-5 mr-3" viewBox="0 0 33 29" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M30.0918 0.161049L0.667101 12.0792C-0.288938 12.4042 -0.182711 13.8127 0.773328 14.1377L8.20918
                                16.5214L11.1835 26.0559C11.396 26.8143 12.352 27.031 12.8832 26.4892L17.2384 22.3721L25.5241 28.5478C26.1615
                                28.9812 27.0113 28.6562 27.2237 27.8977L32.96 2.76136C33.2786 0.919474 31.6852 -0.48903 30.0918 0.161049ZM12.8832
                                18.3633L11.9271 23.9973L9.80258 16.1963L30.5168 2.32798L12.8832 18.3633Z"
                                fill="white"/>
                        </svg>
                        Telegram
                    </a>
                    <a href="#" class="flex justify-center items-center py-2 text-white font-semibold rounded-md"
                       style="background-color: #7527F5">
                        <svg class="min-w-5 min-w-5 w-5 h-5 mr-3" viewBox="0 0 29 29" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.82 2.312C15.9328 2.32025 16.0373 2.3285 16.1253 2.34088C22.3169 3.29375 25.1645 6.22662 25.9524 12.4664C25.9661
                                12.5722 25.9689 12.7015 25.9703 12.8376C25.9785 13.3258 25.995 14.3405 27.084 14.3611H27.117C27.4594 14.3611 27.7303
                                14.258 27.9255 14.0545C28.2638 13.7011 28.2418 13.1745 28.2211 12.751C28.217 12.6465 28.2129 12.5489 28.2129 12.4622C28.2926
                                6.08225 22.7679 0.294875 16.3934 0.080375C16.3659 0.080375 16.3411 0.080375 16.3164 0.0845C16.2913 0.0876649 16.266
                                0.0890434 16.2408 0.0886251C16.1761 0.0886251 16.0991 0.0831251 16.0153 0.0776251C15.9163 0.0707501 15.8021 0.0625 15.6853
                                0.0625C14.6705 0.0625 14.478 0.784375 14.4533 1.21475C14.3969 2.20888 15.358 2.279 15.82 2.312ZM25.654 20.5308C25.5212
                                20.4298 25.3896 20.3271 25.2594 20.2228C24.5829 19.6783 23.8638 19.1777 23.1694 18.6924L22.7363 18.3899C21.8453 17.7642
                                21.045 17.4604 20.2888 17.4604C19.2685 17.4604 18.3803 18.0241 17.646 19.1337C17.3215 19.626 16.9269 19.8652 16.4415 19.8652C16.1044
                                19.8535 15.7736 19.7705 15.4708 19.6219C12.597 18.3184 10.5428 16.3191 9.36851 13.6805C8.80064 12.4045 8.98489 11.5713
                                9.98314 10.892C10.551 10.507 11.6056 9.79063 11.5328 8.417C11.4475 6.85913 8.00864 2.169 6.55939 1.63687C5.93984 1.41088
                                5.26072 1.40894 4.63989 1.63138C2.97476 2.191 1.78126 3.1755 1.18314 4.47487C0.605638 5.73163 0.633138 7.207 1.25739
                                8.7415C3.06551 13.1786 5.60651 17.0479 8.81164 20.2406C11.948 23.366 15.8035 25.9249 20.2695 27.8485C20.6724 28.0217 21.0945
                                28.1166 21.4039 28.1854C21.5084 28.2087 21.5991 28.2294 21.6651 28.2472C21.7015 28.257 21.7389 28.2621 21.7765 28.2624H21.8123C23.9133
                                28.2624 26.4364 26.3429 27.2105 24.1552C27.8898 22.2385 26.6495 21.2911 25.654 20.5308ZM16.7495 7.38163C16.3906 7.38987
                                15.6413 7.40912 15.3786 8.17087C15.2549 8.52837 15.27 8.83638 15.4226 9.09075C15.6454 9.462 16.073 9.5775 16.4608 9.64075C17.8701
                                9.86625 18.5948 10.6445 18.7391 12.0924C18.8065 12.7661 19.2616 13.2378 19.8433 13.2378C19.8874 13.2377 19.9315 13.2349
                                19.9753 13.2295C20.6765 13.147 21.0161 12.6314 20.9859 11.6978C20.9969 10.7242 20.4881 9.61875 19.6205 8.73875C18.7515 7.856
                                17.7038 7.35825 16.7495 7.38163Z"
                                fill="white"/>
                        </svg>
                        Viber
                    </a>
                </div>
            </div>
            <div class="tours-container w-full grid sm:grid-cols-2 xl:grid-cols-3 gap-5">
                @forelse($tours as $tour)
                    @include('components.tours.tour-card', compact('tour'))
                @empty
                    <p class="lg:m-3 text-xl text-gray-600 font-light">{{ __('messages.no-results') }}</p>
                @endforelse
            </div>
        </div>



        <div class="show-more-tours-button mt-6 bg-blue {{ count($tours) < 15 ? 'disabled' : '' }}">
            <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>{{ __('buttons.show-more') }}</span>
        </div>
    </div>
</section>
