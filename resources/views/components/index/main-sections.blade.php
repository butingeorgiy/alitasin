<section class="mb-10 border-b border-gray-200">
    <div class="container grid grid-cols-1 lg:grid-cols-3 gap-4 mx-auto px-5 pt-2 pb-6">
        <a href="#regionsSection" class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
            style="background-image: url({{ asset('images/main-sections-bg-tours.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-tours.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.tours') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-tours-description') }}</p>
            <p class="mt-auto font-semibold">{{ App\Models\Tour::count() }} {{ __('short-phrases.main-sections-tours-amount') }}</p>
        </a>

        <a href="{{ route('vehicles', ['vehicle_type_id' => 1]) }}" class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
            style="background-image: url({{ asset('images/main-sections-bg-cars-rental.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-cars.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.cars-rental') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-transport-description') }}</p>
            <p class="mt-auto font-semibold">{{ App\Models\Vehicle::where('type_id', 1)->count() }} {{ __('short-phrases.main-sections-cars-rental-amount') }}</p>
        </a>

        <a href="{{ route('vehicles', ['vehicle_type_id' => 3]) }}" class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
           style="background-image: url({{ asset('images/main-sections-bg-yachts-rental.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-yachts.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.yachts-rental') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-yachts-rental-description') }}</p>
            <p class="mt-auto font-semibold">{{ \App\Models\Vehicle::where('type_id', 3)->count() }} {{ __('short-phrases.main-sections-yachts-rental-amount') }}</p>
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

        <a href="{{ route('transfers') }}" class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
             style="background-image: url({{ asset('images/main-sections-bg-transfers.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-transfers.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.transfers') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-transfers-description') }}</p>
            <p class="mt-auto font-semibold">{{ App\Models\Transfer::count() }} {{ __('short-phrases.main-sections-property-amount') }}</p>
        </a>

        <div class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
             style="background-image: url({{ asset('images/main-sections-bg-medical-tourism.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-medical-tourism.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.medical-tourism') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-medical-tourism-description') }}</p>
            <p class="mt-auto font-semibold">0 {{ __('short-phrases.main-sections-property-amount') }}</p>
        </div>

        <div class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
             style="background-image: url({{ asset('images/main-sections-bg-shopping.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-shopping.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.shopping') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-shopping-description') }}</p>
            <p class="mt-auto font-semibold">0 {{ __('short-phrases.main-sections-property-amount') }}</p>
        </div>

        <div class="flex flex-col px-8 pt-8 pb-4 text-white bg-center bg-cover bg-no-repeat rounded-md"
             style="background-image: url({{ asset('images/main-sections-bg-individually-excursions.jpg') }})">
            <div class="self-end min-w-20 min-h-20 w-20 h-20 mb-3 bg-contain bg-center bg-no-repeat"
                 style="background-image: url({{ asset('images/main-sections-icon-individually-excursions.svg') }})"></div>
            <p class="mb-2 text-2xl font-bold">
                {{ __('short-phrases.individually-excursions') }}<span class="text-blue">.</span>
            </p>
            <p class="mb-6 text-sm font-light">{{ __('short-phrases.main-sections-personal-excursions-description') }}</p>
            <p class="mt-auto font-semibold">{{ App\Models\Tour::where('tour_type_id', 1)->count() }} {{ __('short-phrases.main-sections-tours-amount') }}</p>
        </div>
    </div>
</section>
