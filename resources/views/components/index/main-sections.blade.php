<section class="mb-10 border-b border-gray-200">
    <div class="container grid grid-cols-1 lg:grid-cols-3 gap-4 mx-auto px-5 pt-2 pb-6">
        <a href="#toursSection" class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
            style="background-image: url({{ asset('images/main-sections-bg-tours.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-tours.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.tours') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-tours-description') }}</p>
            <p class="mt-auto font-semibold">{{ \App\Models\Tour::count() }} {{ __('short-phrases.main-sections-tours-amount') }}</p>
        </a>

        <a href="{{ route('vehicles') }}" class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
            style="background-image: url({{ asset('images/main-sections-bg-transport.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-transport.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.transport-rental') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-transport-description') }}</p>
            <p class="mt-auto font-semibold">{{ \App\Models\Vehicle::count() }} {{ __('short-phrases.main-sections-transport-amount') }}</p>
        </a>

        <div class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
            style="background-image: url({{ asset('images/main-sections-bg-hotels.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-hotels.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.property') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-property-description') }}</p>
            <p class="mt-auto font-semibold">0 {{ __('short-phrases.main-sections-property-amount') }}</p>
        </div>
    </div>
</section>
