<div id="createPartnerPopup" class="hidden fixed w-screen h-screen top-0 left-0 flex justify-center items-center z-50 bg-black bg-opacity-60">
    <div class="popup flex flex-col relative top-0 top-80 p-5 sm:p-10 bg-white rounded-xl duration-300" style="width: 500px">
        <div class="flex items-center mb-8">
            <p class="mr-auto text-2xl text-black font-bold tracking-wider">{{ __('short-phrases.add-partner') }}</p>
            <svg class="close-popup-button min-w-6 min-h-6 w-6 h-6 text-gray-300 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <div class="flex flex-col overflow-y-scroll hide-scrollbar" style="max-height: 320px">
            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="text" name="first_name" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.first-name') }}">
            </label>

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="text" name="last_name" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.last-name') . ' (' . __('short-phrases.unnecessary') . ')' }}">
            </label>

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="email" name="phone" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.phone')  }}">
            </label>

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="email" name="email" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.email')  }}">
            </label>

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="number" name="profit_percent" min="0" max="100" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.profit-percent')  }}">
            </label>

            @if(!request()->is('admin/partners'))
                <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                    <input type="number" name="sub_partner_profit_percent" min="0" max="100" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                           placeholder="{{ __('short-phrases.sub-partner-profit-percent')  }}">
                </label>
            @endif

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="text" name="promo_code" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.promo-code')  }}">
            </label>

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="number" name="sale_percent" min="0" max="100" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.sale-percent')  }}">
            </label>

            <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="password" name="password" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.password')  }}">
            </label>

            <label class="px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
                <input type="password" name="password_confirmation" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                       placeholder="{{ __('short-phrases.password-confirmation')  }}">
            </label>
        </div>

        <div class="error-message hidden flex items-center -mb-4 mt-6 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span></span>
        </div>

        <div class="success-message hidden flex items-center -mb-4 mt-6 px-4 py-3 text-green-500 font-medium bg-green-200 rounded-md">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span></span>
        </div>

        <div class="save-partner-button flex justify-center items-center mt-8 py-3 text-sm text-white font-medium bg-blue rounded-md tracking-wider cursor-pointer">
            <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('buttons.save') }}
        </div>
    </div>
</div>
