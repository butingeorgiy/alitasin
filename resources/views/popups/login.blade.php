<div id="loginPopup" class="fixed hidden w-screen h-screen top-0 left-0 flex justify-center items-center z-50 bg-black bg-opacity-60">
    <div class="popup flex flex-col relative top-0 top-80 p-5 sm:p-10 bg-white rounded-xl duration-300">
        <div class="flex items-center mb-8">
            <p class="mr-auto text-2xl text-black font-bold tracking-wider">{{ __('short-phrases.enter-into-account') }}</p>

            <svg class="close-popup-button min-w-6 min-h-6 w-6 h-6 text-gray-300 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <label class="flex items-center mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md focus-within:bg-white focus-within:border-blue">
            <svg class="min-w-5 min-h-5 w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" color="#A0A3BD"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>

            <span class="flex flex-col w-full">
                <span class="text-sm text-gray-300 tracking-wider">{{ __('short-phrases.email') }}</span>
                <input type="email" name="email"
                       class="w-60 text-black placeholder-black bg-gray-100 tracking-wider focus:bg-white"
                       required
                       placeholder="example@mail.com">
            </span>
        </label>

        <label class="flex items-center mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md focus-within:bg-white focus-within:border-blue">
            <svg class="min-w-5 min-h-5 w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" color="#A0A3BD"
                      d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            <span class="flex flex-col w-full">
                <span class="text-sm text-gray-300 tracking-wider">{{ __('short-phrases.password') }}</span>
                <input type="password" name="password"
                       class="w-60 text-black placeholder-black bg-gray-100 tracking-wider focus:bg-white"
                       required
                       placeholder="••••••••••••••••">
            </span>
        </label>

        <div class="error-message hidden flex items-center mb-2 text-red font-medium">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm tracking-wider"></span>
        </div>

        <div class="login-button flex justify-center items-center py-3 text-sm text-white font-medium bg-blue rounded-md tracking-wider cursor-pointer">
            <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('buttons.login') }}
        </div>
    </div>
</div>
