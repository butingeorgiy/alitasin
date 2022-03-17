<div id="vehicleOrderPopup" class="hidden fixed w-screen h-screen top-0 left-0 flex justify-center items-center z-50 bg-black bg-opacity-60">
    <div class="popup flex flex-col relative top-0 top-80 p-5 sm:p-10 bg-white rounded-xl duration-300" style="width: 500px">
        <div class="flex items-center mb-4">
            <p class="mr-auto text-2xl text-black font-bold tracking-wider">{{ __('short-phrases.order-vehicle') }}</p>
            <svg class="close-popup-button min-w-6 min-h-6 w-6 h-6 text-gray-300 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <div class="mb-1">
            <span class="text-gray-500 font-medium">{{ __('short-phrases.chosen-vehicle') }}:</span>&nbsp;&nbsp;
            <span class="chosen-vehicle"></span>
        </div>

        <div class="mb-4">
            <span class="text-gray-500 font-medium">ТС доступно в:</span>&nbsp;&nbsp;
            <span class="available-region">Мармарис</span>
        </div>

        <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
            <input type="text" name="user_name" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                   placeholder="{{ __('short-phrases.enter-first-name') }}" value="{{ App\Facades\Auth::check() ? \App\Facades\Auth::user()->first_name : null }}">
        </label>

        <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
            <input type="text" name="user_phone" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                   placeholder="{{ __('short-phrases.enter-phone') }}" value="{{ App\Facades\Auth::check() ? \App\Facades\Auth::user()->phone : null }}">
        </label>

        <label class="mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md cursor-pointer">
            <input type="text" name="location_region" class="w-full text-black placeholder-black tracking-wider bg-gray-100"
                   placeholder="{{ __('short-phrases.region-of-your-location') }}">
        </label>

        <label class="flex items-center mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md">
            <input type="text" name="promo_code" class="w-full mr-3 text-black placeholder-black tracking-wider bg-gray-100"
                   placeholder="{{ __('short-phrases.promo-code') }}">

            <span class="check-promo-code-button text-sm text-blue font-semibold cursor-pointer whitespace-nowrap hover:underline">{{ __('buttons.accept') }}</span>
            <span class="hidden active mr-2 text-sm text-green-500 whitespace-nowrap"></span>
            <span class="hidden reset-button text-sm text-blue whitespace-nowrap cursor-pointer">{{ __('buttons.reset') }}</span>
        </label>

        <p class="font-light">{{ __('short-phrases.total-cost') }}:
            <span class="old-price hidden mr-1 text-base text-gray-500 line-through"></span>
            <span class="total-price text-xl text-blue font-semibold">$ 100</span>
            / {{ __('short-phrases.day') }}
        </p>

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

        <div class="send-vehicle-order-button flex justify-center items-center mt-8 py-3 text-sm text-white font-medium bg-blue rounded-md tracking-wider cursor-pointer">
            <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('short-phrases.order') }}
        </div>
    </div>
</div>
