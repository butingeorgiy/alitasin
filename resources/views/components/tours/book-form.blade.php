<section id="bookTourSection" class="mb-10">
    <div class="container mx-auto px-5">
        <p class="mb-8 text-2xl text-center text-black font-bold text-black">{{ __('short-phrases.book-tour') }}<span
                class="text-blue">.</span></p>

        <form class="book-tour-form pb-5 border-b border-gray-700" data-init-cost="{{ $tour->price }}">
            <div class="flex flex-col md:flex-row items-start">
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-y-4 gap-x-10 w-full md:mr-10">
                    <label class="flex flex-col col-span-1">
                        <span class="mb-1 font-semibold">{{ __('short-phrases.hotel') }}</span>
                        <input type="text"
                               name="hotel_name"
                               maxlength="64"
                               placeholder="{{ __('short-phrases.enter-hotel') }}"
                               class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow-sm rounded-md">
                    </label>

                    <label class="flex flex-col col-span-1">
                        <span class="mb-1 font-semibold">{{ __('short-phrases.hotel-room') }}</span>
                        <input type="text"
                               name="hotel_room_number"
                               maxlength="64"
                               placeholder="{{ __('short-phrases.enter-hotel-room-number') }}"
                               class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow-sm rounded-md">
                    </label>

                    <label class="flex flex-col col-span-1">
                        <span class="mb-1 font-semibold">{{ __('short-phrases.location-region') }}</span>
                        <select name="region_id"
                                class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow-sm rounded-md cursor-pointer">
                            <option value="">{{ __('short-phrases.select-location-region') }}</option>
                            @foreach(\App\Models\Region::all() as $region)
                                <option value="{{ $region->id }}">{{ $region->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="flex flex-col col-span-1">
                        <span class="mb-1 font-semibold">{{ __('short-phrases.promo-code') }}</span>
                        <span
                            class="promo-code flex items-center w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow-sm rounded-md">
                            <input type="text"
                                   name="promo_code"
                                   placeholder="{{ __('short-phrases.if-have') }}"
                                   class="w-full text-sm text-gray-400 placeholder-gray-400">
                            <span
                                class="check-promo-code-button text-sm text-blue cursor-pointer whitespace-nowrap hover:underline">{{ __('buttons.accept') }}</span>
                            <span class="active hidden text-sm text-green-500 whitespace-nowrap"></span>
                            <span
                                class="reset-button hidden ml-2 text-sm text-red cursor-pointer hover:underline">{{ __('buttons.reset') }}</span>
                        </span>
                    </label>

                    <label class="flex flex-col col-span-1">
                        <span class="mb-1 font-semibold">{{ __('short-phrases.convenient-way-communication') }}</span>
                        <select name="communication_type"
                                class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow-sm rounded-md cursor-pointer">
                            <option value="">{{ __('short-phrases.select-way') }}</option>
                            <option value="What's App">What's App</option>
                            <option value="Telegram">Telegram</option>
                            <option value="Viber">Viber</option>
                        </select>
                    </label>

                    <label class="flex flex-col col-span-1">
                        <span class="mb-1 font-semibold">{{ __('short-phrases.available-time') }}</span>
                        <select name="time"
                                class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow-sm rounded-md cursor-pointer">
                            <option value="">{{ __('short-phrases.select-time') }}</option>
                            @foreach($tour->available_time as $time)
                                <option value="{{ $time }}">{{ $time }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="flex flex-col col-span-full mt-5 pb-5 border-t border-gray-700">
                        @foreach(\App\Models\Ticket::all() as $ticket)
                            <div class="ticket-item flex items-center py-3 border-b border-gray-200"
                                 data-ticket-id="{{ $ticket->id }}"
                                 data-ticket-cost="{{ $ticket->getCost($tour->price) }}">
                                <span class="mr-auto text-black">{{ $ticket->name }}</span>
                                <span
                                    class="relative top-0.5 mr-10 text-black font-semibold">$ {{ $ticket->getCost($tour->price) }}</span>
                                <span class="flex items-center">
                                    <svg class="minus-ticket-button min-w-6 min-h-6 w-6 h-6 cursor-pointer opacity-50 cursor-not-allowed"
                                        viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M29.2917 4.625H7.70833C6.00546 4.625 4.625 6.00546 4.625 7.70833V29.2917C4.625 30.9945 6.00546 32.375 7.70833 32.375H29.2917C30.9945
                                                 32.375 32.375 30.9945 32.375 29.2917V7.70833C32.375 6.00546 30.9945 4.625 29.2917 4.625Z"
                                              stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M12.3333 18.5H24.6666" stroke="#0094FF" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <span class="tickets-amount relative top-0.5 mx-2 text-gray-600">0</span>
                                    <svg class="plus-ticket-button min-w-6 min-h-6 w-6 h-6 cursor-pointer"
                                         viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M29.2917 4.625H7.70833C6.00546 4.625 4.625 6.00546 4.625 7.70833V29.2917C4.625 30.9945 6.00546 32.375 7.70833
                                                 32.375H29.2917C30.9945 32.375 32.375 30.9945 32.375 29.2917V7.70833C32.375 6.00546 30.9945 4.625 29.2917 4.625Z"
                                              stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                        <path d="M18.5 12.3333V24.6667" stroke="#0094FF" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M12.3333 18.5H24.6666" stroke="#0094FF" stroke-width="2"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-full md:w-auto">
                    <div class="date-picker-container flex justify-center mb-5 mt-3 md:mt-0">
                        <input type="text" hidden name="tour_date" class="ml-auto border border-black"
                               data-allow-days="{{ $tour->getOriginal('conducted_at') }}">
                    </div>

                    <div class="flex items-end px-4 pt-4 pb-3 bg-white shadow-sm rounded-md">
                        <span class="relative -top-0.5 mr-4 text-black font-light">{{ __('short-phrases.total-cost') }}:</span>
                        <span class="text-3xl text-blue font-bold">$<span class="relative -right-1 total-cost">0</span></span>
                    </div>
                </div>
            </div>
        </form>

        <div class="error-message hidden flex items-center mt-4 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span></span>
        </div>

        <div class="success-message hidden flex items-center mt-4 px-4 py-3 text-green-500 font-medium bg-green-200 rounded-md">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span></span>
        </div>

        <form class="general-info-form flex flex-col items-center mt-8" data-is-auth="{{ $user ? '1' : '0' }}">
            <input type="text"
                   name="first_name"
                   {{ $user ? 'readonly' : '' }}
                   value="{{ $user ? $user->first_name : '' }}"
                   placeholder="{{ __('short-phrases.enter-first-name') }}"
                   class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md {{ $user ? ' cursor-not-allowed' : '' }}">

            <input type="text"
                   name="email"
                   {{ $user ? 'readonly' : '' }}
                   value="{{ $user ? $user->email : '' }}"
                   placeholder="{{ __('short-phrases.enter-email') }}"
                   class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md {{ $user ? ' cursor-not-allowed' : '' }}">

            <input type="text"
                   name="phone"
                   {{ $user ? 'readonly' : '' }}
                   value="{{ $user ? $user->phone : '' }}"
                   placeholder="{{ __('short-phrases.enter-phone') }}"
                   class="w-80 mb-3 px-4 py-3 text-sm text-gray-600 placeholder-gray-400 border border-gray-200 bg-white rounded-md {{ $user ? ' cursor-not-allowed' : '' }}">

            <div class="save-book-button w-80 bg-blue">
                <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('buttons.book-now') }}</span>
            </div>
        </form>
    </div>
</section>
