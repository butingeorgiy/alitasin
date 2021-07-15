<section id="transferFormSection" class="pt-6 sm:pt-10 pb-10 bg-gray-50">
    <div class="container mx-auto px-5 lg:px-18 xl:px-36">
        <div>
            <div class="grid sm:grid-cols-3 gap-3 sm:gap-0 mb-8">
                @foreach(App\Models\TransferType::all() as $index => $type)
                    <div class="transfer-type-tab-item {{ $index === 0 ? 'active' : '' }}"
                         data-type-id="{{ $type['id'] }}">{{ $type['name'] }}</div>
                @endforeach
            </div>

            <div class="grid sm:grid-cols-2 gap-5 sm:gap-10 mb-5 sm:mb-8">
                <div class="flex flex-col">
                    <p class="mb-2 font-semibold leading-5">{{ __('short-phrases.choose-airport') }}:</p>
                    <input id="airportSelect"
                           type="text"
                           name="airport"
                           autocomplete="off"
                           class="mt-auto"
                           placeholder="{{ __('short-phrases.search') }}">
                </div>

                <div class="flex flex-col">
                    <p class="mb-2 font-semibold leading-5">{{ __('short-phrases.choose-destination') }}:</p>
                    <input id="destinationSelect"
                           type="text"
                           name="destination"
                           autocomplete="off"
                           class="mt-auto"
                           placeholder="{{ __('short-phrases.search') }}">
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-5 sm:gap-10 mb-4">
                <div class="flex flex-col">
                    <p class="mb-2 font-semibold leading-5">{{ __('short-phrases.departure-date-and-time') }}:</p>
                    <div class="flex items-center w-full mt-auto px-4 py-3 bg-white shadow rounded-md">
                        <input type="text"
                               name="departure"
                               class="w-full text-sm text-gray-400 placeholder-gray-400 cursor-pointer"
                               placeholder="{{ __('short-phrases.to-choose') }}"
                               autocomplete="off">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="hidden clear-button min-w-5 w-5 min-h-5 h-5 ml-4 text-gray-400 cursor-pointer"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414
                                  1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414
                                  10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col">
                    <p class="mb-2 font-semibold leading-5">{{ __('short-phrases.arrival-date-and-time') }}:</p>
                    <div class="flex items-center w-full mt-auto px-4 py-3 bg-white shadow rounded-md">
                        <input type="text"
                               name="arrival"
                               class="w-full text-sm text-gray-400 placeholder-gray-400 cursor-pointer"
                               placeholder="{{ __('short-phrases.to-choose') }}"
                               autocomplete="off">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="hidden clear-button min-w-5 w-5 min-h-5 h-5 ml-4 text-gray-400 cursor-pointer"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414
                                  1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414
                                  10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col">
                    <p class="mb-2 font-semibold leading-5">{{ __('short-phrases.necessary-capacity') }}:</p>
                    <div class="mt-auto">
                        @foreach(App\Models\TransferCapacity::all() as $index => $item)
                            <label class="flex items-center mb-1 last:mb-0 cursor-pointer">
                                <input type="radio"
                                       name="capacity"
                                       {{ $index === 0 ? 'checked' : '' }}
                                       class="form-radio mr-4 text-blue focus:ring-blue"
                                       value="{{ $item['id'] }}">
                                {{ $item['name'] }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="hidden transfer-cost-wrapper mt-8">
                <p class="text-black font-light">
                    {{ __('short-phrases.transfer-cost') }}:
                    <span class="text-3xl text-blue font-bold">$<span class="relative -right-1 transfer-cost">0</span></span>
                </p>
            </div>

            <div class="hidden error-message flex items-center mt-6 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
                <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span></span>
            </div>

            <div class="calculate-transfer-cost mt-6 bg-green-600">
                <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('short-phrases.calculate-cost') }}</span>
            </div>

            <div class="hidden show-transfer-request-popup mt-6 bg-blue">
                <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('short-phrases.order-transfer') }}</span>
            </div>
        </div>
    </div>
</section>