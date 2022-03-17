<section id="personalPartnerInfoSection" class="my-10 pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <p class="ml-5 mb-4 text-black text-2xl font-bold text-black">{{ __('short-phrases.personal-info') }}<span class="text-blue">.</span></p>
        <div class="grid lg:grid-cols-2">
            <div class="flex flex-col px-5 py-5 col-span-1 bg-white rounded-md shadow">
                <div class="personal-info-form grid sm:grid-cols-2 gap-5 mb-2">
                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.first-name') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="first_name" value="{{ $partner->first_name }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.last-name') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="last_name" value="{{ $partner->last_name }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.phone') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="phone" value="{{ $partner->phone }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.email') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="w-full mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="email" value="{{ $partner->email }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                </div>

                <div class="error-message hidden flex items-center -mb-2 mt-2 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
                    <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span></span>
                </div>

                <div class="success-message hidden flex items-center -mb-2 mt-2 px-4 py-3 text-green-500 font-medium bg-green-200 rounded-md">
                    <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span></span>
                </div>

                <div class="save-personal-info-button mt-4 bg-blue disabled">
                    <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>{{ __('buttons.save') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
