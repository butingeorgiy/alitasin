<a href="{{ route('tour', $tour->id) }}" target="{{ $isAdmin ? '_blank' : '_self' }}" class="tour-card flex flex-col shadow rounded-md">
    <div class="flex justify-end items-start p-3 bg-center bg-cover bg-no-repeat bg-gray-50 rounded-md"
         style="height: 180px; background-image: url({{ $tour->image }})">
        @if($isAdmin)
            <div class="move-to-update-page flex justify-center items-center w-8 h-8 mr-2 bg-white rounded-full cursor-pointer" data-tour-id="{{ $tour->id }}">
                <svg class="min-w-4 min-h-4 w-4 h-4" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 4.1917C16.0006 4.08642 15.9804 3.98206 15.9406 3.8846C15.9008 3.78714 15.8421 3.69849 15.768 3.62374L12.376
                                      0.231996C12.3012 0.157856 12.2126 0.0992007 12.1151 0.0593919C12.0176 0.0195832 11.9133 -0.000595299 11.808 1.33704e-05C11.7027
                                      -0.000595299 11.5983 0.0195832 11.5009 0.0593919C11.4034 0.0992007 11.3147 0.157856 11.24 0.231996L8.976 2.49583L0.232013
                                      11.2392C0.157868 11.3139 0.0992079 11.4026 0.0593963 11.5C0.0195847 11.5975 -0.000595342 11.7019 1.33714e-05 11.8071V15.1989C1.33714e-05
                                      15.411 0.0842987 15.6145 0.234328 15.7645C0.384356 15.9145 0.587839 15.9988 0.800012 15.9988H4.19201C4.30395 16.0049 4.41592 15.9874
                                      4.52066 15.9474C4.6254 15.9075 4.72057 15.8459 4.8 15.7668L13.496 7.02349L15.768 4.79965C15.841 4.72213 15.9005 4.63289
                                      15.944 4.53568C15.9517 4.47191 15.9517 4.40745 15.944 4.34369C15.9477 4.30645 15.9477 4.26893 15.944 4.2317L16
                                      4.1917ZM3.86401 14.3989H1.60001V12.1351L9.544 4.1917L11.808 6.45553L3.86401 14.3989ZM12.936 5.32762L10.672 3.06378L11.808
                                      1.93587L14.064 4.1917L12.936 5.32762Z" fill="#5C5C5C"/>
                </svg>
            </div>

            <div class="delete-tour-button flex justify-center items-center w-8 h-8 bg-white rounded-full cursor-pointer" data-tour-id="{{ $tour->id }}">
                <svg class="min-w-4 min-h-4 w-4 h-4" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.625 5.25H4.375H18.375" stroke="#FF3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 5.25V3.5C7 3.03587 7.18437 2.59075 7.51256 2.26256C7.84075 1.93437 8.28587 1.75 8.75 1.75H12.25C12.7141 1.75 13.1592 1.93437 13.4874
                             2.26256C13.8156 2.59075 14 3.03587 14 3.5V5.25M16.625 5.25V17.5C16.625 17.9641 16.4406 18.4092 16.1124 18.7374C15.7842 19.0656 15.3391 19.25 14.875
                             19.25H6.125C5.66087 19.25 5.21575 19.0656 4.88756 18.7374C4.55937 18.4092 4.375 17.9641 4.375 17.5V5.25H16.625Z"
                          stroke="#FF3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12.25 9.625V14.875" stroke="#FF3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.75 9.625V14.875" stroke="#FF3D3D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        @else
            <div class="flex justify-center items-center w-8 h-8 bg-white rounded-full cursor-pointer">
                <svg class="min-w-5 min-h-5 w-5 h-5" viewBox="0 0 21 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.4998 3.76675L9.61235 2.86746C8.74862 1.99218 7.57715 1.50045 6.35566 1.50045C5.13416 1.50045 3.96269 1.99218 3.09897
                2.86746C2.23524 3.74274 1.75 4.92987 1.75 6.1677C1.75 9.58687 6.99955 15.5 10.4998 15.5C14 15.5 19.2498 9.58641 19.2498 6.16725C19.2498
                 4.92942 18.7645 3.74228 17.9008 2.867C17.0371 1.99173 15.8656 1.5 14.6441 1.5C13.7927 1.5 12.9655 1.73892 12.25 2.18012"
                          stroke="#5C5C5C" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        @endif
    </div>
    <div class="flex flex-col px-4 pb-2 h-full" style="flex: 1">
        <div class="flex items-center py-3 text-xs 2xl:text-sm text-blue font-semibold">
            <div class="flex items-center mr-4">
                <svg class="min-w-5 min-w-5 w-5 h-5 mr-2" viewBox="0 0 21 21" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0)">
                        <path
                            d="M14 2.73877C14.7529 2.93153 15.4202 3.36938 15.8967 3.98329C16.3732 4.5972 16.6319
                                        5.35225 16.6319 6.12939C16.6319 6.90654 16.3732 7.66159 15.8967 8.2755C15.4202 8.88941 14.7529 9.32726 14 9.52002"
                            stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path
                            d="M7.875 9.625C9.808 9.625 11.375 8.058 11.375 6.125C11.375 4.192 9.808 2.625 7.875
                                        2.625C5.942 2.625 4.375 4.192 4.375 6.125C4.375 8.058 5.942 9.625 7.875 9.625Z"
                            stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path
                            d="M11.3751 18.4994C12.5896 18.2807 13.5525 17.9476 14.0001 17.5C14.063 16.9339 14.0001 16.0416
                                        14.0001 16.0416C14.0001 15.2681 13.6314 14.5262 12.975 13.9792C10.9022 12.2519 3.97308 12.2519
                                        1.90025 13.9792C1.24387 14.5262 0.87512 15.2681 0.87512 16.0416C0.87512 16.0416 0.812228 16.9339
                                        0.87512 17.5C1.32274 17.9476 2.2856 18.2807 3.50012 18.4994"
                            stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                        <path
                            d="M17.5 18.4994C18.7145 18.2808 19.6774 17.9476 20.125 17.5C20.1879 16.934 20.125 16.0417 20.125
                                        16.0417C20.125 15.2681 19.7563 14.5263 19.0999 13.9793C18.714 13.6577 18.1598 13.396 17.5 13.1942"
                            stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </g>
                    <defs>
                        <clipPath id="clip0">
                            <rect width="21" height="21" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
                <span>{{ $tour->type->name }}</span>
            </div>

            @if($tour->duration)
                <div class="flex items-center">
                    <svg class="min-w-5 min-w-5 w-5 h-5 mr-2" width="21" height="21" viewBox="0 0 21 21"
                         fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.5 1.75C15.3325 1.75 19.25 5.66751 19.25 10.5C19.25 15.3325 15.3325 19.25 10.5 19.25C5.66751
                                            19.25 1.75 15.3325 1.75 10.5C1.75 6.91194 3.90967 3.8283 7 2.47808M10.5 5.25V10.5L14 12.25"
                            stroke="#0094FF" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"/>
                    </svg>
                    <span>{{ $tour->duration }}</span>
                </div>
            @endif
        </div>

        <p class="mb-2 text-black font-bold leading-5">{{ $tour->title[App::getLocale()] }}</p>
        <p class="mb-4 text-sm text-gray-600 leading-5">{{ \Illuminate\Support\Str::limit($tour->description[App::getLocale()]) }}</p>

        <div class="flex items-end" style="flex: 1">
            <p class="mr-auto text-3xl text-black font-bold">${{ $tour->price }}</p>
            <div class="flex flex-col items-end pb-0.5">
                <div class="flex mb-1">
                    <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center"
                         style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                    <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center"
                         style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                    <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center"
                         style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                    <div class="min-w-4 min-w-4 w-4 h-4 mr-1 bg-contain bg-no-repeat bg-center"
                         style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                    <div class="min-w-4 min-w-4 w-4 h-4 bg-contain bg-no-repeat bg-center"
                         style="background-image: url({{ asset('images/active-start.svg') }})"></div>
                </div>
                <span class="text-sm text-gray-600 font-medium hover:underline">{{ __('short-phrases.reviews') }}
                    (0)</span>
            </div>
        </div>
    </div>
</a>
