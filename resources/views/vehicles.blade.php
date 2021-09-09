<!doctype html>
<html lang='{{ App::getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('css/index.css') }}'>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ __('page-titles.vehicles') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.hero', ['title' => __('short-phrases.transport-rental'), 'image' => asset('images/vehicles-hero-bg.png')])
    @include('components.index.global-search', ['bottomBorder' => true])

    <section id="vehicleTypesSection" class="mb-10 pb-4 sm:pb-6 border-b border-gray-200">
        <div class="container mx-auto px-5">
            <div class="flex items-center mb-6">
                <span class="text-gray-900 font-medium">Выберите регион:&nbsp;&nbsp;</span>
                <select class="text-gray-800 placeholder-gray-800 bg-white cursor-pointer" name="region_id">
                    <option value="">Любой</option>
                    @foreach(App\Models\Region::all() as $region)
                        <option value="{{ $region->id }}" {{ (string) $region->id === request()->input('region_id', '') ? 'selected' : '' }}>
                            {{ $region->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-2 sm:mb-4">
                <p class="inline text-black text-2xl font-bold text-black">{{ __('short-phrases.vehicle-categories') }}<span class="text-blue">.</span></p>
            </div>

            <div class="hidden sm:grid grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach(App\Models\VehicleType::all() as $item)
                    <a href="{{ route('vehicles', ['vehicle_type_id' => $item->id]) }}"
                       class="flex justify-center items-center text-white text-3xl font-semibold tracking-wide bg-cover bg-center bg-no-repeat shadow rounded-md
                       {{ (int) request()->input('vehicle_type_id') === $item->id ? 'underline' : ''  }}"
                       style="height: 180px; background-image: url({{ $item->image }})">
                        <span>{{ $item->name }}</span>
                    </a>
                @endforeach
            </div>

            <div class="block sm:hidden swiper-container -mx-3">
                <div class="swiper-wrapper -mx-2 px-5 py-2">
                    @foreach(App\Models\VehicleType::all() as $item)
                        <a href="{{ route('vehicles', ['vehicle_type_id' => $item->id]) }}"
                           class="swiper-slide relative flex justify-center items-center w-72 text-white text-3xl font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md
                           {{ (int) request()->input('vehicle_type_id') === $item->id ? 'underline' : ''  }}"
                           style="height: 180px; background-image: url({{ $item->image }})">{{ $item->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="vehicleSection" class="pb-10">
        <div class="container flex flex-col mx-auto px-5">
            @php /** @var App\Models\Vehicle $vehicle */ @endphp
            @forelse($vehicles as $vehicle)
                <div class="vehicle-item grid grid-cols-12 mb-5 last:mb-0 bg-gray-1200 rounded-md shadow" data-id="{{ $vehicle->id }}" data-title="{{ $vehicle->brand }} ({{ $vehicle->model  }})">
                    <div class="col-span-full lg:col-span-5 flex flex-col items-center px-8 sm:px-16 pt-8 sm:pt-12 lg:pb-4 lg:border-r border-gray-1300">
                        <div class="w-full h-44 mb-8 bg-contain bg-center bg-no-repeat" style="background-image: url({{ $vehicle->main_image }})"></div>
                        <p class="show-vehicle-gallery-btn mt-auto text-sm text-gray-500 hover:underline cursor-pointer" data-images="{{ json_encode($vehicle->getAllImagesUrl()) }}">{{ __('buttons.show-all') }}</p>
                    </div>
                    <div class="col-span-full lg:col-span-7 flex flex-col px-6 sm:px-8 py-6">
                        <p class="mb-4 text-2xl text-black font-medium">{{ $vehicle->brand }}&nbsp;<span class="text-gray-600">{{ $vehicle->model }}</span></p>
                        <div class="flex flex-wrap mb-auto">
                            @foreach($vehicle->params as $param)
                            <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600">{{ $param->name }}:&nbsp;<span class="text-black font-semibold">{{ $param->pivot[App::getLocale() . '_value'] }}</span></p>
                            @endforeach
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mt-5">
                            <p class="mb-2 sm:mb-0 text-xl text-black font-medium">$ {{ $vehicle->cost }}&nbsp;<span class="text-gray-600">/ {{ __('short-phrases.day') }}</span></p>
                            <div class="show-vehicle-order-button px-16 py-2 text-white text-center text-semibold bg-black rounded cursor-pointer">{{ __('short-phrases.order') }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __('short-phrases.empty-list') }}</p>
            @endforelse
        </div>
    </section>

    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.login')
    @include('popups.reg')
    @include('popups.vehicle-order')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>
