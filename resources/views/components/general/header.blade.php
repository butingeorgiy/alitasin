<header class="bg-white">
    <div class="container flex mx-auto px-5 py-4">
        <a href="{{ route('index') }}" class="mr-auto text-xl font-bold">Logo</a>
        <div class="flex items-center">
            @if(\App\Facades\Auth::check())
                <div class="logout-button text-base text-red hover:underline">{{ __('buttons.exit') }}</div>
            @else
                <div class="show-login-popup-button mr-8 text-base hover:underline">{{ __('buttons.login') }}</div>
                <a href="#" class="mr-8 text-base hover:underline">{{ __('buttons.reg') }}</a>
                <a href="#" class="text-base hover:underline">{{ __('buttons.about-us') }}</a>
            @endif
                <select class="language-switch-select ml-8 cursor-pointer" name="language">
                    @foreach(['ru', 'en', 'tr'] as $lang)
                        <option value="{{ $lang }}" {{ App::getLocale() === $lang ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                    @endforeach
                </select>
        </div>
    </div>
</header>
