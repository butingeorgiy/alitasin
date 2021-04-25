<div id="regPopup" class="fixed hidden w-screen h-screen top-0 left-0 flex justify-center items-center z-50 bg-black bg-opacity-60">
    <div class="popup flex flex-col relative top-0 top-80 p-5 sm:p-10 bg-white rounded-xl duration-300">
        <div class="flex items-center mb-8">
            <p class="mr-auto text-2xl text-black font-bold tracking-wider">{{ __('short-phrases.registration') }}</p>

            <svg class="close-popup-button min-w-6 min-h-6 w-6 h-6 text-gray-300 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <label class="flex items-center mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md focus-within:bg-white focus-within:border-blue">
            <svg class="min-w-5 min-h-5 w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 11C14.2091 11 16 9.20914 16 7C16 4.79086 14.2091 3 12 3C9.79086 3 8 4.79086 8 7C8 9.20914 9.79086 11 12 11Z"
                      stroke="#A0A3BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16.0319 21.1421C17.4199 20.8922 18.5204 20.5115 19.0319 19.9999C19.1038 19.353 19.0319 18.3332 19.0319 18.3332C19.0319
                      17.4492 18.6105 16.6013 17.8604 15.9762C15.4914 14.0021 7.57247 14.0021 5.20352 15.9762C4.45337 16.6013 4.03195 17.4492 4.03195
                      18.3332C4.03195 18.3332 3.96007 19.353 4.03195 19.9999C4.54351 20.5115 5.64392 20.8922 7.03194 21.1421"
                      stroke="#A0A3BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>


            <span class="flex flex-col w-full">
                <span class="text-sm text-gray-300 tracking-wider">{{ __('short-phrases.first-name') }}</span>
                <input type="text" name="first_name"
                       class="w-60 text-black placeholder-black bg-gray-100 tracking-wider focus:bg-white"
                       required
                       placeholder="John">
            </span>
        </label>

        <label class="flex items-center mb-4 px-3 py-2 border-2 border-gray-100 bg-gray-100 rounded-md focus-within:bg-white focus-within:border-blue">
            <svg class="min-w-5 min-h-5 w-5 h-5 mr-3" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.09006 9.9101L9.36005 8.6401C9.62892 8.36821 9.81421 8.02494 9.89396 7.65098C9.97372 7.27701 9.9446 6.88802 9.81006 6.5301C9.47151
                      5.62282 9.23668 4.68016 9.11005 3.7201C9.04213 3.23954 8.80179 2.80008 8.43382 2.48363C8.06585 2.16718 7.59536 1.99532 7.11006 2.0001H4.11006C3.8324
                      2.00036 3.55783 2.05843 3.30385 2.17062C3.04986 2.28281 2.82202 2.44665 2.63482 2.65172C2.44763 2.85679 2.30518 3.09859 2.21656 3.36172C2.12793
                      3.62486 2.09507 3.90356 2.12006 4.1801C2.4483 7.27109 3.50003 10.2413 5.19006 12.8501C6.72539 15.2663 8.77388 17.3148 11.1901 18.8501C13.7871
                      20.5342 16.7429 21.5857 19.8201 21.9201C20.0974 21.9452 20.377 21.912 20.6408 21.8228C20.9046 21.7336 21.1469 21.5902 21.3521 21.402C21.5574 21.2137
                      21.721 20.9846 21.8326 20.7294C21.9441 20.4743 22.0012 20.1986 22.0001 19.9201V16.9201C22.0122 16.4297 21.8437 15.9519 21.5266 15.5776C21.2095 15.2033
                      20.7658 14.9586 20.2801 14.8901C19.32 14.7635 18.3773 14.5286 17.4701 14.1901C17.1121 14.0556 16.7231 14.0264 16.3492 14.1062C15.9752 14.1859 15.6319
                      14.3712 15.3601 14.6401L14.0901 15.9101" stroke="#A0A3BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>


            <span class="flex flex-col w-full">
                <span class="text-sm text-gray-300 tracking-wider">{{ __('short-phrases.phone') }}</span>
                <input type="text" name="phone"
                       class="w-60 text-black placeholder-black bg-gray-100 tracking-wider focus:bg-white"
                       required
                       placeholder="98 (000) 000 0000">
            </span>
        </label>

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

        <div class="error-message hidden flex items-center mb-2 text-red font-medium">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm tracking-wider"></span>
        </div>

        <div class="create-account-button flex justify-center items-center py-3 text-sm text-white font-medium bg-blue rounded-md tracking-wider cursor-pointer">
            <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor"
                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            {{ __('buttons.create-account') }}
        </div>
    </div>
</div>
