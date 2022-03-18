<!doctype html>
<html lang='{{ app()->getLocale() }}'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport'
          content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <script type='text/javascript' src='{{ asset('js/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('css/index.css') }}'>
    <link rel="icon" href="{{ asset('images/favicon.ico') }}">
    <title>{{ __('page-titles.property') }}</title>
</head>
<body>
    @include('components.general.header')
    @include('components.general.hero', ['title' => __('short-phrases.property'), 'image' => asset('images/main-sections-bg-hotels.jpg')])
    @include('components.index.global-search', ['bottomBorder' => true])

    <section id="propertyTypesSection" class="mb-4 pb-4 sm:pb-6">
        <div class="container mx-auto px-5">
            {{--            <p class="mb-4 text-black">{{ __('short-phrases.vehicle-region-warning') }}</p>--}}

            <div class="flex flex-col sm:flex-row sm:items-center text-xl">
                <div class="flex mb-5 sm:mb-0">
                    <span class="font-semibold">{{ __('short-phrases.choose-region') }}:&nbsp;&nbsp;</span>
                    <select class="placeholder-gray-800 text-blue bg-white font-semibold cursor-pointer"
                            name="region_id">
                        <option value="">{{ __('short-phrases.any') }}</option>
                        @foreach(App\Models\Region::all() as $region)
                            <option value="{{ $region->id }}" {{ (string) $region->id === request()->input('region_id', '') ? 'selected' : '' }}>
                                {{ $region->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex">
                    <span class="font-semibold">{{ __('short-phrases.choose-type') }}:&nbsp;&nbsp;</span>
                    <select class="placeholder-gray-800 text-blue bg-white font-semibold cursor-pointer"
                            name="type_id">
                        <option value="">{{ __('short-phrases.any') }}</option>
                        @foreach(App\Models\PropertyType::all() as $type)
                            <option value="{{ $type->id }}" {{ (string) $type->id === request()->input('type_id', '') ? 'selected' : '' }}>
                                {{ $type->getLocaleName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </section>

    <section id="propertySection" class="pb-10">
        <div class="container flex flex-col mx-auto px-5">
            @php /** @var App\Models\Property $property */ @endphp
            @forelse($propertyItems as $property)
                <div class="property-item grid grid-cols-12 mb-5 last:mb-0 bg-gray-1200 rounded-md shadow"
                     data-id="{{ $property->id }}"
                     data-title="{{ $property->getLocaleTitle() }}">
                    <div class="col-span-full lg:col-span-5 relative flex flex-col items-center px-8 sm:px-16 pt-8 sm:pt-12 lg:pb-12 lg:border-r border-gray-1300">
                        <div class="show-property-gallery-btn w-full h-44 bg-contain bg-center bg-no-repeat cursor-pointer"
                             data-images="{{ json_encode($property->getAllImagesUrl()) }}"
                             style="background-image: url({{ $property->getPreviewImage() }})">
                            <svg class="absolute min-h-6 min-w-6 h-6 w-6 bottom-5 right-5 text-blue"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0
                                  0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                            </svg>
                        </div>
                        @if(App\Facades\Auth::check(['5']))
                            <div class="flex absolute bottom-4">
                                <a href="{{ route('edit-property', ['id' => $property->id]) }}"
                                   target="_blank"
                                   class="mr-5 text-sm text-gray-600 cursor-pointer hover:underline">{{ __('buttons.edit') }}</a>

                                @if($property->trashed())
                                    <p class="restore-property-button text-sm text-gray-600 cursor-pointer hover:underline">{{ __('short-phrases.restore') }}</p>
                                @else
                                    <p class="delete-property-button text-sm text-gray-600 cursor-pointer hover:underline">{{ __('buttons.delete') }}</p>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="col-span-full lg:col-span-7 flex flex-col px-6 sm:px-8 py-6">
                        <p class="mb-4 text-2xl text-black font-medium">{{ $property->getLocaleTitle() }}</p>
                        <div class="flex flex-wrap mb-auto">
                            <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600">{{ __('short-phrases.region') }}:&nbsp;
                                <span class="text-black font-semibold">{{ $property->region->name }}</span>
                            </p>

                            <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600">{{ __('short-phrases.property-type') }}:&nbsp;
                                <span class="text-black font-semibold">{{ $property->type->getLocaleName() }}</span>
                            </p>

                            @foreach($property->params as $param)
                                <p class="mr-5 last:mr-0 mb-3 text-sm text-gray-600">{{ $param->getLocaleName() }}:&nbsp;<span
                                            class="text-black font-semibold">{{ $param->pivot[App::getLocale() . '_value'] }}</span>
                                </p>
                            @endforeach
                        </div>
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-end mt-5">
                            <p class="mb-2 sm:mb-0 text-xl text-black font-medium">
                                $ {{ number_format($property->cost, 2, '.', ' ') }}
                                @if($property->unit)
                                    <span class="text-gray-600">/ {{ $property->unit->getLocaleName() }}</span>
                                @endif
                            </p>
                            <div class="show-property-order-button px-16 py-2 text-white text-center text-semibold bg-black rounded cursor-pointer">{{ __('short-phrases.order') }}</div>
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
    @include('popups.property-order')

    <!-- Widgets -->
    @include('widgets.click-to-call')
</body>
</html>
