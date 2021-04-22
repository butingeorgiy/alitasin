<header class="bg-white">
    <div class="container flex mx-auto px-5 py-4">
        <a href="{{ request()->is('admin/*') ? route('admin-index') : route('index') }}" class="mr-auto text-xl font-bold">Ali Tour<span class="text-blue">.</span></a>
        <div class="flex items-center">
            @if(\App\Facades\Auth::check())
                @if(!request()->is('admin/*', 'profile/*'))
                    @if(in_array(\App\Facades\Auth::user()->account_type_id, ['1', '2']))
                        <a href="{{ route('profile-index') }}" class="text-black hover:underline">
                            {{ __('buttons.move-to-cabinet') }}
                        </a>
                    @else
                        <a href="{{ route('admin-index') }}" class="text-black hover:underline">
                            {{ __('buttons.admin-panel') }}
                        </a>
                    @endif
                @endif
                <a href="{{ route('logout') }}" class="logout-button ml-8 text-red hover:underline">{{ __('buttons.exit') }}</a>
            @else
                <div class="show-login-popup-button mr-8 text-black hover:underline">{{ __('buttons.login') }}</div>
                <div class="show-reg-popup-button text-black hover:underline">{{ __('buttons.reg') }}</div>
            @endif
                <select class="language-switch-select ml-8 cursor-pointer" name="language">
                    @foreach(['ru', 'en', 'tr'] as $lang)
                        <option value="{{ $lang }}" {{ App::getLocale() === $lang ? 'selected' : '' }}>{{ ucfirst($lang) }}</option>
                    @endforeach
                </select>
        </div>
    </div>
</header>
