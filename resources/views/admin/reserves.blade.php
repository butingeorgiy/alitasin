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
    <title>{{ __('page-titles.reserves') }}</title>
</head>
<body class="bg-gray-50">
    @include('components.general.header')
    @include('components.general.profile-hero')
    <section id="reservesSection" class="mt-10 mb-10">
        <div class="container mx-auto px-5">
            <p class="mb-3 text-black text-2xl font-bold text-black">{{ __('short-phrases.reserves') }}<span class="text-blue">.</span></p>

            <div class="reserves-container bg-white border border-gray-200 rounded-md">
                <!-- Reserve table header  -->
                <div class="reserves-filters grid grid-cols-reserve-table gap-5 py-4 px-8">
                    <label class="flex items-center">
                        <svg class="min-w-4 min-h-4 w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761
                        1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#4B506D" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path
                                d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z"
                                stroke="#4B506D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span class="text-sm text-gray-900 font-medium">{{ __('short-phrases.excursion') }}:&nbsp;&nbsp;</span>
                        <select class="text-sm text-gray-800 placeholder-gray-800 cursor-pointer" name="tour_id">
                            <option value="">{{ __('short-phrases.all-tours') }}</option>
                            @foreach(App\Models\Tour::byManager($user->id)->get() as $tour)
                                <option value="{{ $tour->id }}" title="{{ $tour->title[App::getLocale()] }}" {{ (string) $tour->id === request()->input('tour_id', '') ? 'selected' : '' }}>
                                    {{ \Illuminate\Support\Str::limit($tour->title[App::getLocale()], 50) }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label class="flex items-center">
                        <svg class="min-w-4 min-h-4 w-4 h-4 mr-1" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10 18C10.1978 18 10.3911 17.9414 10.5556 17.8315C10.72 17.7216 10.8482 17.5654 10.9239 17.3827C10.9996 17.2 11.0194 16.9989 10.9808 16.8049C10.9422
                                 16.6109 10.847 16.4327 10.7071 16.2929C10.5673 16.153 10.3891 16.0578 10.1951 16.0192C10.0011 15.9806 9.80004 16.0004 9.61732 16.0761C9.43459 16.1518 9.27841
                                 16.28 9.16853 16.4444C9.05865 16.6089 9 16.8022 9 17C9 17.2652 9.10536 17.5196 9.29289 17.7071C9.48043 17.8946 9.73478 18 10 18ZM15 18C15.1978 18 15.3911
                                 17.9414 15.5556 17.8315C15.72 17.7216 15.8482 17.5654 15.9239 17.3827C15.9996 17.2 16.0194 16.9989 15.9808 16.8049C15.9422 16.6109 15.847 16.4327 15.7071
                                 16.2929C15.5673 16.153 15.3891 16.0578 15.1951 16.0192C15.0011 15.9806 14.8 16.0004 14.6173 16.0761C14.4346 16.1518 14.2784 16.28 14.1685 16.4444C14.0586
                                 16.6089 14 16.8022 14 17C14 17.2652 14.1054 17.5196 14.2929 17.7071C14.4804 17.8946 14.7348 18 15 18ZM15 14C15.1978 14 15.3911 13.9414 15.5556 13.8315C15.72
                                 13.7216 15.8482 13.5654 15.9239 13.3827C15.9996 13.2 16.0194 12.9989 15.9808 12.8049C15.9422 12.6109 15.847 12.4327 15.7071 12.2929C15.5673 12.153 15.3891
                                 12.0578 15.1951 12.0192C15.0011 11.9806 14.8 12.0004 14.6173 12.0761C14.4346 12.1518 14.2784 12.28 14.1685 12.4444C14.0586 12.6089 14 12.8022 14 13C14 13.2652
                                 14.1054 13.5196 14.2929 13.7071C14.4804 13.8946 14.7348 14 15 14ZM10 14C10.1978 14 10.3911 13.9414 10.5556 13.8315C10.72 13.7216 10.8482 13.5654 10.9239
                                 13.3827C10.9996 13.2 11.0194 12.9989 10.9808 12.8049C10.9422 12.6109 10.847 12.4327 10.7071 12.2929C10.5673 12.153 10.3891 12.0578 10.1951 12.0192C10.0011 11.9806
                                 9.80004 12.0004 9.61732 12.0761C9.43459 12.1518 9.27841 12.28 9.16853 12.4444C9.05865 12.6089 9 12.8022 9 13C9 13.2652 9.10536 13.5196 9.29289 13.7071C9.48043
                                 13.8946 9.73478 14 10 14ZM17 2H16V1C16 0.734784 15.8946 0.48043 15.7071 0.292893C15.5196 0.105357 15.2652 0 15 0C14.7348 0 14.4804 0.105357 14.2929 0.292893C14.1054
                                 0.48043 14 0.734784 14 1V2H6V1C6 0.734784 5.89464 0.48043 5.70711 0.292893C5.51957 0.105357 5.26522 0 5 0C4.73478 0 4.48043 0.105357 4.29289 0.292893C4.10536
                                 0.48043 4 0.734784 4 1V2H3C2.20435 2 1.44129 2.31607 0.87868 2.87868C0.316071 3.44129 0 4.20435 0 5V19C0 19.7956 0.316071 20.5587 0.87868 21.1213C1.44129 21.6839
                                 2.20435 22 3 22H17C17.7956 22 18.5587 21.6839 19.1213 21.1213C19.6839 20.5587 20 19.7956 20 19V5C20 4.20435 19.6839 3.44129 19.1213 2.87868C18.5587 2.31607
                                 17.7956 2 17 2ZM18 19C18 19.2652 17.8946 19.5196 17.7071 19.7071C17.5196 19.8946 17.2652 20 17 20H3C2.73478 20 2.48043 19.8946 2.29289 19.7071C2.10536 19.5196
                                 2 19.2652 2 19V10H18V19ZM18 8H2V5C2 4.73478 2.10536 4.48043 2.29289 4.29289C2.48043 4.10536 2.73478 4 3 4H4V5C4 5.26522 4.10536 5.51957 4.29289 5.70711C4.48043
                                 5.89464 4.73478 6 5 6C5.26522 6 5.51957 5.89464 5.70711 5.70711C5.89464 5.51957 6 5.26522 6 5V4H14V5C14 5.26522 14.1054 5.51957 14.2929 5.70711C14.4804 5.89464
                                 14.7348 6 15 6C15.2652 6 15.5196 5.89464 15.7071 5.70711C15.8946 5.51957 16 5.26522 16 5V4H17C17.2652 4 17.5196 4.10536 17.7071 4.29289C17.8946 4.48043 18 4.73478
                                 18 5V8ZM5 14C5.19778 14 5.39112 13.9414 5.55557 13.8315C5.72002 13.7216 5.84819 13.5654 5.92388 13.3827C5.99957 13.2 6.01937 12.9989 5.98079 12.8049C5.9422 12.6109
                                 5.84696 12.4327 5.70711 12.2929C5.56725 12.153 5.38907 12.0578 5.19509 12.0192C5.00111 11.9806 4.80004 12.0004 4.61732 12.0761C4.43459 12.1518 4.27841 12.28 4.16853
                                 12.4444C4.05865 12.6089 4 12.8022 4 13C4 13.2652 4.10536 13.5196 4.29289 13.7071C4.48043 13.8946 4.73478 14 5 14ZM5 18C5.19778 18 5.39112 17.9414 5.55557
                                 17.8315C5.72002 17.7216 5.84819 17.5654 5.92388 17.3827C5.99957 17.2 6.01937 16.9989 5.98079 16.8049C5.9422 16.6109 5.84696 16.4327 5.70711 16.2929C5.56725 16.153
                                 5.38907 16.0578 5.19509 16.0192C5.00111 15.9806 4.80004 16.0004 4.61732 16.0761C4.43459 16.1518 4.27841 16.28 4.16853 16.4444C4.05865 16.6089 4 16.8022 4
                                 17C4 17.2652 4.10536 17.5196 4.29289 17.7071C4.48043 17.8946 4.73478 18 5 18Z" fill="#4B506D"/>
                        </svg>
                        <span class="text-sm text-gray-900 font-medium whitespace-nowrap">{{ __('short-phrases.date') }}:&nbsp;&nbsp;</span>
                        <input class="text-sm text-gray-800 placeholder-gray-800 cursor-pointer" data-value="{{ json_encode($dateRange) }}"
                               type="text" name="date" readonly placeholder="{{ __('short-phrases.select-date') }}">
                    </label>
                </div>
                @if(count($reservations) > 0)
                    <div class="grid grid-cols-reserve-table gap-5 px-8 pt-3 pb-1 border-b border-gray-200">
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-offered-by') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-tour') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-offered-at') }}</div>
                        <div class="text-sm text-gray-800 font-medium">{{ __('short-phrases.reserves-title-status') }}</div>
                    </div>
                @endif
                <!-- Reserve table items  -->
                @foreach($reservations as $reservation)
                    @include('components.reserve.reserves-table-item', compact('reservation'))
                @endforeach
                <!-- Reserve table footer  -->
                <div class="px-8 py-4 {{ count($reservations) === 0 ? 'border-t border-gray-200' : '' }}">
                    <div class="flex">
                        <span class="text-sm text-gray-900 font-medium">Найдено записей:&nbsp;&nbsp;</span>
                        <span class="text-sm text-gray-800">{{ count($reservations) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('components.general.footer')

    <!-- Popups -->
    @include('popups.update-reserve-status')
    @include('popups.reserve-details')
</body>
</html>
