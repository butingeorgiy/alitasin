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
    <title>{{ __('page-titles.create-tour') }}</title>
</head>
<body class="bg-gray-50">
@include('components.general.header')

<div class="mt-12 pb-12">
    <form id="createTourForm" class="container mx-auto px-5">
        <div>
            <p class="mb-2 font-semibold">{{ __('short-phrases.choose-images') }}</p>
            <div class="grid grid-cols-5 gap-5">
                @for($i = 1; $i <= 5; $i++)
                    <label class="image-item">
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
                            <span
                                class="text-center text-sm text-black font-light leading-4">{{ __('short-phrases.choose-image') }}</span>
                        </span>
                        <span class="remove-image-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5
                                      7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </span>
                        <input hidden type="file" name="image-{{ $i }}" accept="image/jpeg,image/jpg,image/png">
                    </label>
                @endfor
            </div>
        </div>

        <div class="mt-12">
            <p class="mb-2 font-semibold">{{ __('short-phrases.en-title') }}</p>
            <input type="text"
                   name="en_title"
                   class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                   maxlength="256"
                   placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">

            <p class="mb-2 font-semibold">{{ __('short-phrases.ru-title') }}</p>
            <input type="text"
                   name="ru_title"
                   class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                   maxlength="256"
                   placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">

            <p class="mb-2 font-semibold">{{ __('short-phrases.tr-title') }}</p>
            <input type="text"
                   name="tr_title"
                   class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                   maxlength="256"
                   placeholder="{{ __('short-phrases.max-allowed-characters') }} - 256">
        </div>

        <div class="mt-12">
            <p class="mb-2 font-semibold">{{ __('short-phrases.en-description') }}</p>
            <textarea
                class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                name="en_description"
                rows="6"
                maxlength="2048"
                placeholder="{{ __('short-phrases.max-allowed-characters') }} - 2048"></textarea>

            <p class="mb-2 font-semibold">{{ __('short-phrases.ru-description') }}</p>
            <textarea
                class="w-full mb-5 px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                name="ru_description"
                rows="6"
                maxlength="2048"
                placeholder="{{ __('short-phrases.max-allowed-characters') }} - 2048"></textarea>

            <p class="mb-2 font-semibold">{{ __('short-phrases.tr-description') }}</p>
            <textarea
                class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                name="tr_description"
                rows="6"
                maxlength="2048"
                placeholder="{{ __('short-phrases.max-allowed-characters') }} - 2048"></textarea>
        </div>

        <div class="grid grid-cols-3 gap-5 mt-12">
            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.price') }}, $</p>
                <input type="text"
                       name="price"
                       class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       placeholder="{{ __('short-phrases.per-one-person') }}">
            </div>

            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.conducted-days') }}</p>
                <select name="conduct_at" multiple placeholder="{{ __('short-phrases.search') }}">
                    <option value="mon">{{ __('short-phrases.monday') }}</option>
                    <option value="tue">{{ __('short-phrases.tuesday') }}</option>
                    <option value="wed">{{ __('short-phrases.wednesday') }}</option>
                    <option value="thu">{{ __('short-phrases.thursday') }}</option>
                    <option value="fri">{{ __('short-phrases.friday') }}</option>
                    <option value="sat">{{ __('short-phrases.saturday') }}</option>
                    <option value="sun">{{ __('short-phrases.sunday') }}</option>
                </select>
            </div>

            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.tour-types') }}</p>
                <select name="tour_type_id"
                        class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md cursor-pointer">
                    <option value="">{{ __('short-phrases.choose-type') }}</option>
                    @foreach(\App\Models\TourType::all() as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5 mt-6">
            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.region') }}</p>
                <select name="region_id"
                        class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md cursor-pointer">
                    <option value="">{{ __('short-phrases.choose-region') }}</option>
                    @foreach(\App\Models\Region::all() as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.manager') }}</p>
                <select name="manager_id"
                        class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md cursor-pointer">
                    <option value="">@lang('short-phrases.choose-manager')</option>
                    @foreach(\App\Models\User::managers()->get() as $manager)
                        <option value="{{ $manager->id }}">{{ $manager->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.address') }}</p>
                <input type="text"
                       name="address"
                       maxlength="256"
                       class="w-full px-4 py-3 text-sm text-gray-400 placeholder-gray-400 bg-white shadow rounded-md"
                       placeholder="{{ __('short-phrases.departure-place') }}">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-5 mt-6">
            <div>
                <p class="mb-2 font-semibold">{{ __('short-phrases.duration') }} ({{ __('short-phrases.unnecessary') }})</p>
                <div class="w-full flex items-center mb-5 px-4 py-3 text-sm bg-white shadow rounded-md">
                    <input type="text"
                           name="duration"
                           class="mr-3 text-gray-400 placeholder-gray-400"
                           style="flex: 1"
                           placeholder="{{ __('short-phrases.amount') }}">
                    <select name="duration-mode" class="cursor-pointer">
                        <option value="h">{{ __('short-phrases.hours') }}</option>
                        <option value="d">{{ __('short-phrases.days') }}</option>
                    </select>
                </div>
            </div>

            <div class="col-span-2">
                <p class="mb-2 font-semibold">{{ __('short-phrases.filters') }}</p>
                <select name="filters" multiple placeholder="{{ __('short-phrases.search') }}">
                    @foreach(\App\Models\Filter::all() as $filter)
                        <option value="{{ $filter->id }}">{{ $filter->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="error-message hidden flex items-center px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span></span>
        </div>

        <div class="success-message hidden flex items-center px-4 py-3 text-green-500 font-medium bg-green-200 rounded-md">
            <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span></span>
        </div>

        <div class="save-tour-button bg-green-600">
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
</body>
</html>
