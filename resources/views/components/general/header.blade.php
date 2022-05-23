<header class="relative bg-white">
    <div class="container flex items-center mx-auto px-5 py-4">
        <a href="{{ request()->is('admin/*') ? route('admin-index') : route('index') }}" class="flex items-center mr-auto text-xl font-bold">
            <div class="min-w-10 min-h-10 w-10 h-10 mr-4 bg-contain bg-center bg-no-repeat" style="background-image: url({{ asset('images/logo.svg') }})"></div>
            Ali Tour<span class="text-blue">.</span>
        </a>
        <div class="hidden sm:flex items-center">
            <div class="relative flex flex-wrap group">
                <a href="/#regionsSection" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.tours') }}</a>

                <!-- Tours submenu -->
                <div class="hidden group-hover:block origin-top-right absolute left-0 top-full z-20 w-56 rounded-md shadow-lg bg-white border border-gray-200"
                     role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                    <div class="py-1 rounded-md overflow-hidden" role="none">
                        @foreach(App\Models\Region::all() as $region)
                            <a href="{{ route('region', $region->id) }}" class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100">
                                {{ $region->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <a href="{{ route('vehicles', ['vehicle_type_id' => 1]) }}" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.rental-cars') }}</a>
            <a href="{{ route('vehicles', ['vehicle_type_id' => 3]) }}" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.rental-yachts') }}</a>
            <a href="{{ route('transfers') }}" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.transfers') }}</a>
            <a href="{{ route('property') }}" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.property') }}</a>
            <a href="{{ route('partnership') }}" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.partnership') }}</a>
            <a href="/#contacts" class="mr-8 text-black font-medium hover:underline">{{ __('short-phrases.contacts') }}</a>
            @if(App\Facades\Auth::check())
                @if(!request()->is('admin/*', 'profile/*'))
                    @if(in_array(App\Facades\Auth::user()->account_type_id, ['1', '2']))
                        <a href="{{ route('profile-index') }}" class="text-black font-medium hover:underline">
                            {{ __('buttons.move-to-cabinet') }}
                        </a>
                    @else
                        <a href="{{ route('admin-index') }}" class="text-black font-medium hover:underline">
                            {{ __('buttons.admin-panel') }}
                        </a>
                    @endif
                @endif
                <a href="{{ route('logout') }}" class="ml-8 text-red font-medium hover:underline">{{ __('buttons.exit') }}</a>
            @else
                <div class="show-login-popup-button mr-8 text-black font-medium hover:underline cursor-pointer">{{ __('buttons.login') }}</div>
                <div class="show-reg-popup-button text-black font-medium hover:underline cursor-pointer">{{ __('buttons.reg') }}</div>
            @endif
                <select class="ml-8 cursor-pointer bg-white text-blue" name="language">
                    @foreach(['ru', 'en', 'tr', 'ua'] as $lang)
                        <option value="{{ $lang }}" {{ App::getLocale() === $lang ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                    @endforeach
                </select>
        </div>
        <div class="burger-menu-icon block sm:hidden cursor-pointer">
            <svg class="w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M20 18L14 18" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 6L10 6" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 12L4 12" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>

        <div class="mobile-menu hidden absolute top-full left-0 z-50 w-full pb-10 bg-white shadow-md transition-all duration-150 transform opacity-0 scale-95">
            <div class="grid grid-cols-2 gap-5 px-5 py-6 bg-gray-1000">
                @if(App\Facades\Auth::check())
                    @if(!request()->is('admin/*', 'profile/*'))
                        @if(in_array(App\Facades\Auth::user()->account_type_id, ['1', '2']))
                            <a href="{{ route('profile-index') }}" class="flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md">
                                {{ __('buttons.move-to-cabinet') }}
                            </a>
                        @else
                            <a href="{{ route('admin-index') }}" class="flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md">
                                {{ __('buttons.admin-panel') }}
                            </a>
                        @endif
                    @endif
                    <a href="{{ route('logout') }}" class="{{ request()->is('admin/*', 'profile/*') ? 'col-span-2' : '' }} flex justify-center px-3 py-1.5 text-sm text-red font-medium bg-white border border-gray-1100 rounded-md">{{ __('buttons.exit') }}</a>
                @else
                    <div class="show-login-popup-button close-after-click flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md">{{ __('buttons.login') }}</div>
                    <div class="show-reg-popup-button close-after-click flex justify-center px-3 py-1.5 text-sm text-black font-medium bg-white border border-gray-1100 rounded-md">{{ __('buttons.reg') }}</div>
                @endif
            </div>
            <div class="flex flex-col items-center mb-5 p-5">
                <a href="{{ route('index') }}" class="mb-4 text-sm text-black font-semibold">{{ __('short-phrases.main') }}</a>
                <a href="/#regionsSection" class="close-after-click mb-4 text-sm text-black font-semibold">{{ __('short-phrases.popular-regions') }}</a>
                <div class="flex flex-col mb-4 group">
                    <div class="flex items-center">
                        <p class="mr-3 text-sm text-black font-semibold">{{ __('short-phrases.tours') }}</p>
                        <svg width="11" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 1L5 5L9 1" stroke="#231F20" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>

                    <div class="hidden group-hover:flex flex-col mt-4">
                        @foreach(App\Models\Region::all() as $region)
                            <a href="{{ route('region', $region->id) }}" class="mb-4 text-sm text-center text-black font-medium">{{ $region->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('vehicles', ['vehicle_type_id' => 1]) }}" class="mb-4 text-sm text-black font-semibold">{{ __('short-phrases.cars-rental') }}</a>
                <a href="{{ route('vehicles', ['vehicle_type_id' => 3]) }}" class="mb-4 text-sm text-black font-semibold">{{ __('short-phrases.yachts-rental') }}</a>
                <a href="{{ route('transfers') }}" class="mb-4 text-sm text-black font-semibold">{{ __('short-phrases.transfers') }}</a>
                <a href="{{ route('property') }}" class="mb-4 text-sm text-black font-semibold">{{ __('short-phrases.property') }}</a>
                <a href="{{ route('partnership') }}" class="mb-4 text-sm text-black font-semibold">{{ __('short-phrases.partnership') }}</a>
                <a href="/#reviewsSliderSection" class="close-after-click mb-4 text-sm text-black font-semibold">{{ __('short-phrases.reviews') }}</a>
                <a href="/#contacts" class="close-after-click mb-4 text-sm text-black font-semibold">{{ __('short-phrases.contacts') }}</a>
                <select class="text-sm text-black font-semibold bg-white" name="language">
                    @foreach(['ru', 'en', 'tr', 'ua'] as $lang)
                        <option value="{{ $lang }}" {{ App::getLocale() === $lang ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-center">
                <a href="https://wa.me/+905350303054" target="_blank" class="w-8 h-8 bg-contain bg-center bg-no-repeat" style="background-image: url({{ asset('images/whatsapp-icon.svg') }})"></a>
                <a href="https://t.me/alitasin" target="_blank" class="w-8 h-8 mx-8 bg-contain bg-center bg-no-repeat" style="background-image: url({{ asset('images/telegram-icon.svg') }})"></a>
                <a href="viber://add?number=905350303054" class="w-8 h-8 bg-contain bg-center bg-no-repeat" style="background-image: url({{ asset('images/phone-icon.svg') }})"></a>
            </div>
        </div>
    </div>
</header>
