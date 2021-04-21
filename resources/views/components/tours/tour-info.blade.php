<section id="tourInfoSection" class="mt-6 mb-12">
    <div class="container mx-auto px-5">
        <div class="grid grid-cols-4 grid-row-2 gap-4 h-60 sm:h-96 mb-4">
            <div class="col-span-4 md:col-span-2 row-span-2 bg-cover bg-center bg-no-repeat shadow rounded-md"
                 style="background-image: url({{ $mainImage }})"></div>

            @php

                /**
                 * @var $tour
                 */
                $images = $tour->images->where('is_main', '0')->values();
                $imageCount = count($images);

                if ($imageCount > 4) {
                    $imageCount = 4;
                }

                switch ($imageCount) {
                    case 1:
                        $imageCellClasses = ['col-span-full md:col-span-2 row-span-2'];
                        break;
                    case 2:
                        $imageCellClasses = [
                            'col-span-2',
                            'col-span-2'
                        ];
                        break;
                    case 3:
                        $imageCellClasses = [
                            'col-span-1',
                            'col-span-1',
                            'col-span-2'
                        ];
                        break;
                    case 4:
                        $imageCellClasses = [
                            'col-span-1',
                            'col-span-1',
                            'col-span-1',
                            'col-span-1'
                        ];
                        break;
                    default:
                        $imageCellClasses = [];
                }

            @endphp

            @foreach($images as $i => $image)
                <div class="{{ $imageCellClasses[$i] ?? '' }} hidden sm:block bg-cover bg-center bg-no-repeat shadow rounded-md"
                     style="background-image: url({{ $image['data'] }})"></div>
            @endforeach

        </div>

        @if(count($images) > 0)
            <div class="block sm:hidden swiper-container -ml-1 mb-2">
                <div class="swiper-wrapper pl-1 pb-2">
                    @foreach($images as $i => $image)
                        <div class="swiper-slide w-72 h-32 bg-cover bg-center bg-no-repeat shadow rounded-md"
                             style="background-image: url({{ $image['data'] }})"></div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-md">
            <div class="flex flex-col lg:flex-row px-4 py-5 border-b border-gray-200">
                <div class="mb-6 lg:mb-0 mr-auto">
                    <p class="mb-3 text-xl text-black font-bold">{{ $tour->title[App::getLocale()] }}</p>
                    <div class="flex items-center">
                        <div class="min-w-5 min-w-5 w-5 h-5 mr-1 bg-contain bg-no-repeat bg-center"
                             style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                        <div class="min-w-5 min-w-5 w-5 h-5 mr-1 bg-contain bg-no-repeat bg-center"
                             style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                        <div class="min-w-5 min-w-5 w-5 h-5 mr-1 bg-contain bg-no-repeat bg-center"
                             style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                        <div class="min-w-5 min-w-5 w-5 h-5 mr-1 bg-contain bg-no-repeat bg-center"
                             style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                        <div class="min-w-5 min-w-5 w-5 h-5 mr-2 bg-contain bg-no-repeat bg-center"
                             style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                        <p class="relative top-0.5 text-black font-medium leading-none">5.0</p>
                    </div>
                </div>

                <div class="flex lg:flex-col items-end self-start lg:ml-20 mb-2 lg:mb-0">
                    <p class="relative left-1 lg:left-0 mb-auto mr-3 lg:mr-0 text-4xl text-black font-extrabold tracking-wider">
                        <span class="relative -left-1 text-blue">$</span>{{ $tour->price }}
                    </p>
                    <p class="mb-1.5 lg:mb-0 text-sm text-gray-500 font-medium whitespace-nowrap">{{ __('short-phrases.per-one-person') }}</p>
                </div>
                <a href="#bookTourSection" class="book-tour-button">{{ __('buttons.book-now') }}</a>
            </div>

            <div class="flex flex-wrap px-4 pt-5 pb-3 border-b border-gray-200">
                @if($tour->duration)
                    <div class="flex items-center mr-5 mb-2 text-gray-500">
                        <svg class="min-w-5 min-h-5 w-5 h-5 mr-2" viewBox="0 0 22 22" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M11 1C16.5228 1 21 5.47715 21 11C21 16.5228 16.5228 21 11
                            21C5.47715 21 1 16.5228 1 11C1 6.89936 3.46819 3.3752 7 1.83209M11 5V11L15 13"
                                  stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="relative -bottom-0.5">{{ $tour->duration }}</p>
                    </div>
                @endif

                <div class="flex items-center mr-5 mb-2 text-gray-500">
                    <svg class="min-w-5 min-h-5 w-5 h-5 mr-2" viewBox="0 0 22 18" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.3 9.22C11.8336 8.75813 12.2616 8.18688 12.5549 7.54502C12.8482 6.90316 13 6.20571 13 5.5C13
                        4.17392 12.4732 2.90215 11.5355 1.96447C10.5979 1.02678 9.32608 0.5 8 0.5C6.67392 0.5 5.40215 1.02678
                        4.46447 1.96447C3.52678 2.90215 3 4.17392 3 5.5C2.99999 6.20571 3.1518 6.90316 3.44513 7.54502C3.73845
                        8.18688 4.16642 8.75813 4.7 9.22C3.30014 9.85388 2.11247 10.8775 1.27898 12.1685C0.445495 13.4596 0.00147185
                        14.9633 0 16.5C0 16.7652 0.105357 17.0196 0.292893 17.2071C0.48043 17.3946 0.734784 17.5 1 17.5C1.26522
                        17.5 1.51957 17.3946 1.70711 17.2071C1.89464 17.0196 2 16.7652 2 16.5C2 14.9087 2.63214 13.3826 3.75736
                        12.2574C4.88258 11.1321 6.4087 10.5 8 10.5C9.5913 10.5 11.1174 11.1321 12.2426 12.2574C13.3679 13.3826
                        14 14.9087 14 16.5C14 16.7652 14.1054 17.0196 14.2929 17.2071C14.4804 17.3946 14.7348 17.5 15 17.5C15.2652
                        17.5 15.5196 17.3946 15.7071 17.2071C15.8946 17.0196 16 16.7652 16 16.5C15.9985 14.9633 15.5545 13.4596
                        14.721 12.1685C13.8875 10.8775 12.6999 9.85388 11.3 9.22ZM8 8.5C7.40666 8.5 6.82664 8.32405 6.33329 7.99441C5.83994
                        7.66476 5.45542 7.19623 5.22836 6.64805C5.0013 6.09987 4.94189 5.49667 5.05764 4.91473C5.1734 4.33279
                        5.45912 3.79824 5.87868 3.37868C6.29824 2.95912 6.83279 2.6734 7.41473 2.55764C7.99667 2.44189 8.59987
                        2.5013 9.14805 2.72836C9.69623 2.95542 10.1648 3.33994 10.4944 3.83329C10.8241 4.32664 11 4.90666 11
                        5.5C11 6.29565 10.6839 7.05871 10.1213 7.62132C9.55871 8.18393 8.79565 8.5 8 8.5ZM17.74 8.82C18.38 8.09933
                        18.798 7.20905 18.9438 6.25634C19.0896 5.30362 18.9569 4.32907 18.5618 3.45C18.1666 2.57093 17.5258 1.8248
                        16.7165 1.30142C15.9071 0.77805 14.9638 0.499742 14 0.5C13.7348 0.5 13.4804 0.605357 13.2929 0.792893C13.1054
                        0.98043 13 1.23478 13 1.5C13 1.76522 13.1054 2.01957 13.2929 2.20711C13.4804 2.39464 13.7348 2.5 14 2.5C14.7956
                        2.5 15.5587 2.81607 16.1213 3.37868C16.6839 3.94129 17 4.70435 17 5.5C16.9986 6.02524 16.8593 6.5409 16.5961
                        6.99542C16.3328 7.44994 15.9549 7.82738 15.5 8.09C15.3517 8.17552 15.2279 8.29766 15.1404 8.44474C15.0528 8.59182 15.0045
                        8.7589 15 8.93C14.9958 9.09976 15.0349 9.2678 15.1137 9.41826C15.1924 9.56872 15.3081 9.69665 15.45 9.79L15.84 10.05L15.97 10.12C17.1754
                        10.6917 18.1923 11.596 18.901 12.7263C19.6096 13.8566 19.9805 15.1659 19.97 16.5C19.97 16.7652 20.0754 17.0196 20.2629 17.2071C20.4504
                        17.3946 20.7048 17.5 20.97 17.5C21.2352 17.5 21.4896 17.3946 21.6771 17.2071C21.8646 17.0196 21.97 16.7652 21.97 16.5C21.9782 14.9654
                        21.5938 13.4543 20.8535 12.1101C20.1131 10.7659 19.0413 9.63331 17.74 8.82Z" fill="#747474"/>
                    </svg>
                    <p class="relative -bottom-0.5">{{ $tour->type->name }}</p>
                </div>

                <div class="flex items-center mr-5 mb-2 text-gray-500">
                    <svg class="min-w-5 min-h-5 w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761
                        1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="#747474" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path
                            d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z"
                            stroke="#747474" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p class="relative -bottom-0.5">{{ $tour->region->name }}</p>
                </div>

                <div class="flex items-center mb-2 text-gray-500">
                    <svg class="min-w-5 min-h-5 w-5 h-5 mr-2" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                 17C4 17.2652 4.10536 17.5196 4.29289 17.7071C4.48043 17.8946 4.73478 18 5 18Z" fill="#747474"/>
                    </svg>
                    <p class="relative -bottom-0.5">
                        @foreach($tour->conducted_at as $i => $day)
                            {{ __('short-phrases.' . $day . '-shorten') . (count($tour->conducted_at) - 1 > $i ? ', ' : '') }}
                        @endforeach
                    </p>
                </div>

            </div>
            <div class="px-4 py-5">
                <p class="mb-2 text-lg text-black font-bold">{{ __('short-phrases.tour-description') }}:</p>
                <div class="text-gray-600 whitespace-pre-wrap">{{ $tour->description[App::getLocale()] }}</div>
            </div>
        </div>
    </div>
</section>
