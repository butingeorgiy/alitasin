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
    <title>{{ __('page-titles.edit-property') }}</title>
</head>
<body class="bg-gray-50">
    @include('components.general.header')

    <div class="mt-6 pb-12">
        <form id="editPropertyForm" class="container mx-auto px-5">
            @if($property->trashed())
                <div class="flex items-center mb-6 px-4 py-3 text-yellow font-medium bg-yellow bg-opacity-20 rounded-md">
                    <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p>Данная недвижимость скрыта на сайте! <span
                                class="restore-property-button cursor-pointer underline">Нажмите</span>, чтобы снова
                        появилось на сайте</p>
                </div>
            @endif

            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.choose-images') }}</p>
                <div class="grid grid-cols-5 gap-5">
                    <?php
                    /**
                     * @var App\Models\Property $property
                     */

                    $images = $property->images->sortByDesc('is_main')->values();
                    ?>
                    @for($i = 1; $i <= 5; $i++)
                        @if(isset($images[$i-1]))
                            <label class="image-item filled"
                                   style="background-image: url({{ asset('storage/property_pictures/' . $images[$i-1]->image) }})"
                                   data-image-id="{{ $images[$i-1]->id }}">
                                @if($i !== 1)
                                    <div class="make-image-main-button absolute -bottom-6
                                                text-sm text-gray-600 font-light hover:underline">
                                        {{ __('buttons.make-main') }}
                                    </div>
                                @endif
                                @else
                                    <label class="image-item">
                                        @endif
                                        <span class="empty flex flex-col items-center">
                                <svg class="w-12 h-12 mb-3" viewBox="0 0 83 83" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                            d="M70.375 33.25C69.281 33.25 68.2318 33.6846 67.4582 34.4582C66.6846 35.2318 66.25 36.281
                                                66.25 37.375V51.3175L60.145 45.2125C57.9894 43.0739 55.0759 41.8738 52.0394 41.8738C49.0029
                                                41.8738 46.0894 43.0739 43.9338 45.2125L41.0463 48.1412L30.8162 37.87C28.6606 35.7314 25.7471
                                                34.5313 22.7106 34.5313C19.6741 34.5313 16.7606 35.7314 14.605 37.87L8.5 44.0162V20.875C8.5
                                                19.781 8.9346 18.7318 9.70819 17.9582C10.4818 17.1846 11.531 16.75 12.625 16.75H45.625C46.719
                                                16.75 47.7682 16.3154 48.5418 15.5418C49.3154 14.7682 49.75 13.719 49.75 12.625C49.75 11.531
                                                49.3154 10.4818 48.5418 9.70819C47.7682 8.9346 46.719 8.5 45.625 8.5H12.625C9.34295 8.5 6.19532
                                                9.80379 3.87455 12.1246C1.55379 14.4453 0.25 17.5929 0.25 20.875V71.2825C0.26087 74.3205 1.47254
                                                77.231 3.62076 79.3792C5.76898 81.5275 8.67948 82.7391 11.7175 82.75H63.0325C64.1503 82.7411 65.2613
                                                82.5744 66.3325 82.255C68.7144 81.5869 70.8114 80.1558 72.3016 78.1812C73.7919 76.2066 74.5932
                                                73.7976 74.5825 71.3237V37.375C74.5826 36.8263 74.4732 36.2831 74.2608 35.7771C74.0484 35.2712
                                                73.7371 34.8128 73.3453 34.4286C72.9535 34.0445 72.4889 33.7424 71.9789 33.54C71.4689 33.3376
                                                70.9236 33.239 70.375 33.25ZM12.625 74.5C11.531 74.5 10.4818 74.0654 9.70819 73.2918C8.9346 72.5182
                                                8.5 71.469 8.5 70.375V55.6488L20.4212 43.7275C21.0241 43.128 21.8398 42.7915 22.69 42.7915C23.5402
                                                42.7915 24.3559 43.128 24.9587 43.7275L55.7725 74.5H12.625ZM66.25 70.375C66.2235 71.1738 65.9656
                                                71.9476 65.5075 72.6025L46.8625 53.875L49.7913 50.9875C50.087 50.6857 50.44 50.4459 50.8295
                                                50.2822C51.2191 50.1185 51.6374 50.0342 52.06 50.0342C52.4826 50.0342 52.9009 50.1185 53.2905
                                                50.2822C53.68 50.4459 54.033 50.6857 54.3287 50.9875L66.25 62.9912V70.375ZM78.625 8.5H74.5V4.375C74.5
                                                3.28098 74.0654 2.23177 73.2918 1.45818C72.5182 0.684597 71.469 0.25 70.375 0.25C69.281 0.25
                                                68.2318 0.684597 67.4582 1.45818C66.6846 2.23177 66.25 3.28098 66.25 4.375V8.5H62.125C61.031
                                                8.5 59.9818 8.9346 59.2082 9.70819C58.4346 10.4818 58 11.531 58 12.625C58 13.719 58.4346 14.7682
                                                59.2082 15.5418C59.9818 16.3154 61.031 16.75 62.125 16.75H66.25V20.875C66.25 21.969 66.6846
                                                23.0182 67.4582 23.7918C68.2318 24.5654 69.281 25 70.375 25C71.469 25 72.5182 24.5654 73.2918
                                                23.7918C74.0654 23.0182 74.5 21.969 74.5 20.875V16.75H78.625C79.719 16.75 80.7682 16.3154 81.5418
                                                15.5418C82.3154 14.7682 82.75 13.719 82.75 12.625C82.75 11.531 82.3154 10.4818 81.5418 9.70819C80.7682
                                                8.9346 79.719 8.5 78.625 8.5Z"
                                            fill="#231F20"/>
                                </svg>
                                <span class="text-center text-sm text-black font-light leading-4">{{ __('short-phrases.choose-image') }}</span>
                            </span>
                                        @if($i !== 1)
                                            <span class="remove-image-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5
                                              7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </span>
                                        @endif
                                        <input hidden type="file" name="image-{{ $i }}"
                                               accept="image/jpeg,image/jpg,image/png">
                                    </label>
                            @endfor
                </div>
            </div>

            <div class="mt-12">
                <p class="mb-2 font-semibold">{{ __('short-phrases.en-title') }}</p>
                <input type="text"
                       name="en_title"
                       class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       value="{{ $property->title->en }}"
                       maxlength="256"
                       placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">

                <p class="mb-2 font-semibold">{{ __('short-phrases.ru-title') }}</p>
                <input type="text"
                       name="ru_title"
                       class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       value="{{ $property->title->ru }}"
                       maxlength="256"
                       placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">

                <p class="mb-2 font-semibold">{{ __('short-phrases.tr-title') }}</p>
                <input type="text"
                       name="tr_title"
                       class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       value="{{ $property->title->tr }}"
                       maxlength="256"
                       placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">

                <p class="mb-2 font-semibold">{{ __('short-phrases.ua-title') }}</p>
                <input type="text"
                       name="ua_title"
                       class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       value="{{ $property->title->ua }}"
                       maxlength="256"
                       placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">
            </div>

            <div class="mt-12">
                <p class="mb-2 font-semibold">{{ __('short-phrases.en-description') }}</p>
                <div id="en-description-editor">{!! $property->description->en !!}</div>

                <p class="mt-5 mb-2 font-semibold">{{ __('short-phrases.ru-description') }}</p>
                <div id="ru-description-editor">{!! $property->description->ru !!}</div>

                <p class="mt-5 mb-2 font-semibold">{{ __('short-phrases.tr-description') }}</p>
                <div id="tr-description-editor">{!! $property->description->tr !!}</div>

                <p class="mt-5 mb-2 font-semibold">{{ __('short-phrases.ua-description') }}</p>
                <div id="ua-description-editor">{!! $property->description->ua !!}</div>
            </div>

            <div class="mt-12">
                <p class="mb-2 font-semibold">{{ __('short-phrases.region') }}</p>
                <select name="region_id"
                        class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md cursor-pointer">
                    <option value="">{{ __('short-phrases.choose-region') }}</option>
                    @foreach(App\Models\Region::all() as $region)
                        <option value="{{ $region->id }}" {{ $property->region_id === $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                    @endforeach
                </select>

                <p class="mb-2 font-semibold">{{ __('short-phrases.property-type') }}</p>
                <select name="type_id"
                        class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md cursor-pointer">
                    <option value="">{{ __('short-phrases.choose-type') }}</option>
                    @foreach(App\Models\PropertyType::all() as $type)
                        <option value="{{ $type->id }}" {{ $property->type_id === $type->id ? 'selected' : '' }}>{{ $type->getLocaleName() }}</option>
                    @endforeach
                </select>

                <p class="mb-2 font-semibold">{{ __('short-phrases.cost-unit') }}</p>
                <select name="cost_unit_id"
                        class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md cursor-pointer">
                    <option value="">{{ __('short-phrases.nothing-chosen') }}</option>
                    @php

                    if ($property->unit) {
                        $unitId = $property->unit->id;
                    } else {
                        $unitId = null;
                    }

                    @endphp

                    @foreach(App\Models\CostUnit::all() as $unit)
                        <option value="{{ $unit->id }}" {{ $unitId === $unit->id ? 'selected' : '' }}>{{ $unit->getLocaleName() }}</option>
                    @endforeach
                </select>

                <p class="mb-2 font-semibold">{{ __('short-phrases.price') }}, $</p>
                <input type="text"
                       name="cost"
                       class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       value="{{ $property->cost }}"
                       placeholder="{{ __('short-phrases.enter-price') }}">
            </div>

            <div class="grid grid-cols-2 gap-5 mt-12">
                <div class="flex flex-col">
                    <div class="flex items-center mb-2">
                        <p class="mr-4 font-semibold">{{ __('short-phrases.parameters') }}
                            ({{ __('short-phrases.unnecessary') }})</p>
                        <span class="open-param-popup-button text-sm text-blue cursor-pointer whitespace-nowrap hover:underline">{{ __('buttons.add') }}</span>
                    </div>
                    <div class="params-container" data-params="{{ json_encode($property->params) }}">
                        @forelse($property->params as $param)
                            <div class="flex items-start ml-2 mb-3 last:mb-0">
                                <svg class="relative top-1 min-w-4 w-4 mr-3" viewBox="0 0 15 11" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7319 0.295798C13.639 0.20207 13.5284 0.127675 13.4065 0.0769067C13.2846 0.026138 13.1539 0 13.0219 0C12.8899 0 12.7592 0.026138
                                      12.6373 0.0769067C12.5155 0.127675 12.4049 0.20207 12.3119 0.295798L4.86192 7.7558L1.73192 4.6158C1.6354 4.52256 1.52146 4.44925 1.3966
                                      4.40004C1.27175 4.35084 1.13843 4.32671 1.00424 4.32903C0.870064 4.33135 0.737655 4.36008 0.614576 4.41357C0.491498 4.46706 0.380161
                                      4.54428 0.286922 4.6408C0.193684 4.73732 0.12037 4.85126 0.0711659 4.97612C0.0219619 5.10097 -0.00216855 5.2343 0.000152918 5.36848C0.00247438
                                      5.50266 0.0312022 5.63507 0.0846957 5.75814C0.138189 5.88122 0.215401 5.99256 0.311922 6.0858L4.15192 9.9258C4.24489 10.0195 4.35549 10.0939
                                      4.47735 10.1447C4.59921 10.1955 4.72991 10.2216 4.86192 10.2216C4.99393 10.2216 5.12464 10.1955 5.2465 10.1447C5.36836 10.0939 5.47896
                                      10.0195 5.57192 9.9258L13.7319 1.7658C13.8334 1.67216 13.9144 1.5585 13.9698 1.432C14.0252 1.30551 14.0539 1.1689 14.0539 1.0308C14.0539
                                      0.892697 14.0252 0.756092 13.9698 0.629592C13.9144 0.503092 13.8334 0.389441 13.7319 0.295798V0.295798Z"
                                          fill="#0094FF"/>
                                </svg>
                                <div class="flex flex-col">
                                    <div class="flex items-center">
                                        <p class="mr-5 text-black font-medium">{{ $param->name }}</p>
                                        <span class="edit-param-button mr-2 text-sm text-gray-500 cursor-pointer whitespace-nowrap hover:underline"
                                              data-param="{{ json_encode($param) }}">{{ __('buttons.edit') }}</span>
                                        <span class="dettach-param-button text-sm text-red-500 cursor-pointer whitespace-nowrap hover:underline"
                                              data-id="{{ $param['id'] }}">{{ __('buttons.delete') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-400 italic">
                                        En:&nbsp;&nbsp;{{ $param->getOriginal('pivot_en_value') ?: 'Ничего не указано' }}</p>
                                    <p class="text-sm text-gray-400 italic">
                                        Ru:&nbsp;&nbsp;{{ $param->getOriginal('pivot_ru_value') ?: 'Ничего не указано' }}</p>
                                    <p class="text-sm text-gray-400 italic">
                                        Tr:&nbsp;&nbsp;{{ $param->getOriginal('pivot_tr_value') ?: 'Ничего не указано' }}</p>
                                    <p class="text-sm text-gray-400 italic">
                                        Ua:&nbsp;&nbsp;{{ $param->getOriginal('pivot_ua_value') ?: 'Ничего не указано' }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-black font-light italic">{{ __('short-phrases.empty-list') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="error-message hidden flex items-center mt-6 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
                <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span></span>
            </div>

            <div class="success-message hidden flex items-center mt-6 px-4 py-3 text-green-500 font-medium bg-green-200 rounded-md">
                <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span></span>
            </div>

            <div class="save-property-button mt-6 bg-green-600">
                <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                              7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ __('buttons.save') }}</span>
            </div>
        </form>
    </div>

    @include('popups.parameter')
</body>
</html>
