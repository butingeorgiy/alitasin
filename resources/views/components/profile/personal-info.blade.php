<section id="personalInfoSection" class="my-10 pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <p class="ml-5 mb-4 text-black text-2xl font-bold text-black">{{ __('short-phrases.personal-info') }}<span class="text-blue">.</span></p>
        <div class="grid lg:grid-cols-2">
            <div class="flex flex-col px-5 py-5 col-span-1 bg-white rounded-md shadow">
                <form class="personal-info-form grid sm:grid-cols-2 gap-5 mb-2">
                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.first-name') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" name="first_name" value="{{ $user->first_name }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                            <svg class="min-w-4 min-h-4 w-4 h-4 ml-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 4.1917C16.0006 4.08642 15.9804 3.98206 15.9406 3.8846C15.9008 3.78714 15.8421 3.69849 15.768 3.62374L12.376
                                      0.231996C12.3012 0.157856 12.2126 0.0992007 12.1151 0.0593919C12.0176 0.0195832 11.9133 -0.000595299 11.808 1.33704e-05C11.7027
                                      -0.000595299 11.5983 0.0195832 11.5009 0.0593919C11.4034 0.0992007 11.3147 0.157856 11.24 0.231996L8.976 2.49583L0.232013
                                      11.2392C0.157868 11.3139 0.0992079 11.4026 0.0593963 11.5C0.0195847 11.5975 -0.000595342 11.7019 1.33714e-05 11.8071V15.1989C1.33714e-05
                                      15.411 0.0842987 15.6145 0.234328 15.7645C0.384356 15.9145 0.587839 15.9988 0.800012 15.9988H4.19201C4.30395 16.0049 4.41592 15.9874
                                      4.52066 15.9474C4.6254 15.9075 4.72057 15.8459 4.8 15.7668L13.496 7.02349L15.768 4.79965C15.841 4.72213 15.9005 4.63289
                                      15.944 4.53568C15.9517 4.47191 15.9517 4.40745 15.944 4.34369C15.9477 4.30645 15.9477 4.26893 15.944 4.2317L16
                                      4.1917ZM3.86401 14.3989H1.60001V12.1351L9.544 4.1917L11.808 6.45553L3.86401 14.3989ZM12.936 5.32762L10.672 3.06378L11.808
                                      1.93587L14.064 4.1917L12.936 5.32762Z" fill="#979797"/>
                            </svg>
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.last-name') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" name="last_name" value="{{ $user->last_name }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                            <svg class="min-w-4 min-h-4 w-4 h-4 ml-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 4.1917C16.0006 4.08642 15.9804 3.98206 15.9406 3.8846C15.9008 3.78714 15.8421 3.69849 15.768 3.62374L12.376
                                      0.231996C12.3012 0.157856 12.2126 0.0992007 12.1151 0.0593919C12.0176 0.0195832 11.9133 -0.000595299 11.808 1.33704e-05C11.7027
                                      -0.000595299 11.5983 0.0195832 11.5009 0.0593919C11.4034 0.0992007 11.3147 0.157856 11.24 0.231996L8.976 2.49583L0.232013
                                      11.2392C0.157868 11.3139 0.0992079 11.4026 0.0593963 11.5C0.0195847 11.5975 -0.000595342 11.7019 1.33714e-05 11.8071V15.1989C1.33714e-05
                                      15.411 0.0842987 15.6145 0.234328 15.7645C0.384356 15.9145 0.587839 15.9988 0.800012 15.9988H4.19201C4.30395 16.0049 4.41592 15.9874
                                      4.52066 15.9474C4.6254 15.9075 4.72057 15.8459 4.8 15.7668L13.496 7.02349L15.768 4.79965C15.841 4.72213 15.9005 4.63289
                                      15.944 4.53568C15.9517 4.47191 15.9517 4.40745 15.944 4.34369C15.9477 4.30645 15.9477 4.26893 15.944 4.2317L16
                                      4.1917ZM3.86401 14.3989H1.60001V12.1351L9.544 4.1917L11.808 6.45553L3.86401 14.3989ZM12.936 5.32762L10.672 3.06378L11.808
                                      1.93587L14.064 4.1917L12.936 5.32762Z" fill="#979797"/>
                            </svg>
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.phone') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <span class="mr-1 text-sm text-black font-semibold">+</span>
                            <input class="mr-auto text-sm text-black font-semibold" type="text" name="phone" value="{{ $user->phone }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                            <svg class="min-w-4 min-h-4 w-4 h-4 ml-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 4.1917C16.0006 4.08642 15.9804 3.98206 15.9406 3.8846C15.9008 3.78714 15.8421 3.69849 15.768 3.62374L12.376
                                      0.231996C12.3012 0.157856 12.2126 0.0992007 12.1151 0.0593919C12.0176 0.0195832 11.9133 -0.000595299 11.808 1.33704e-05C11.7027
                                      -0.000595299 11.5983 0.0195832 11.5009 0.0593919C11.4034 0.0992007 11.3147 0.157856 11.24 0.231996L8.976 2.49583L0.232013
                                      11.2392C0.157868 11.3139 0.0992079 11.4026 0.0593963 11.5C0.0195847 11.5975 -0.000595342 11.7019 1.33714e-05 11.8071V15.1989C1.33714e-05
                                      15.411 0.0842987 15.6145 0.234328 15.7645C0.384356 15.9145 0.587839 15.9988 0.800012 15.9988H4.19201C4.30395 16.0049 4.41592 15.9874
                                      4.52066 15.9474C4.6254 15.9075 4.72057 15.8459 4.8 15.7668L13.496 7.02349L15.768 4.79965C15.841 4.72213 15.9005 4.63289
                                      15.944 4.53568C15.9517 4.47191 15.9517 4.40745 15.944 4.34369C15.9477 4.30645 15.9477 4.26893 15.944 4.2317L16
                                      4.1917ZM3.86401 14.3989H1.60001V12.1351L9.544 4.1917L11.808 6.45553L3.86401 14.3989ZM12.936 5.32762L10.672 3.06378L11.808
                                      1.93587L14.064 4.1917L12.936 5.32762Z" fill="#979797"/>
                            </svg>
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.email') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="w-full mr-auto text-sm text-black font-semibold" type="text" name="email" value="{{ $user->email }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                            <svg class="min-w-4 min-h-4 w-4 h-4 ml-5" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 4.1917C16.0006 4.08642 15.9804 3.98206 15.9406 3.8846C15.9008 3.78714 15.8421 3.69849 15.768 3.62374L12.376
                                      0.231996C12.3012 0.157856 12.2126 0.0992007 12.1151 0.0593919C12.0176 0.0195832 11.9133 -0.000595299 11.808 1.33704e-05C11.7027
                                      -0.000595299 11.5983 0.0195832 11.5009 0.0593919C11.4034 0.0992007 11.3147 0.157856 11.24 0.231996L8.976 2.49583L0.232013
                                      11.2392C0.157868 11.3139 0.0992079 11.4026 0.0593963 11.5C0.0195847 11.5975 -0.000595342 11.7019 1.33714e-05 11.8071V15.1989C1.33714e-05
                                      15.411 0.0842987 15.6145 0.234328 15.7645C0.384356 15.9145 0.587839 15.9988 0.800012 15.9988H4.19201C4.30395 16.0049 4.41592 15.9874
                                      4.52066 15.9474C4.6254 15.9075 4.72057 15.8459 4.8 15.7668L13.496 7.02349L15.768 4.79965C15.841 4.72213 15.9005 4.63289
                                      15.944 4.53568C15.9517 4.47191 15.9517 4.40745 15.944 4.34369C15.9477 4.30645 15.9477 4.26893 15.944 4.2317L16
                                      4.1917ZM3.86401 14.3989H1.60001V12.1351L9.544 4.1917L11.808 6.45553L3.86401 14.3989ZM12.936 5.32762L10.672 3.06378L11.808
                                      1.93587L14.064 4.1917L12.936 5.32762Z" fill="#979797"/>
                            </svg>
                        </span>
                    </label>
                </form>

                <div class="error-message hidden flex items-center -mb-2 mt-2 px-4 py-3 text-red-600 font-medium bg-red-200 rounded-md">
                    <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span></span>
                </div>

                <div class="success-message hidden flex items-center -mb-2 mt-2 px-4 py-3 text-green-500 font-medium bg-green-200 rounded-md">
                    <svg class="min-h-5 min-w-5 h-5 w-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span></span>
                </div>

                <div class="save-personal-info-button mt-4 disabled bg-blue">
                    <svg class="animate-spin mr-3 h-5 w-5 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962
                      7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>{{ __('buttons.save') }}</span>
                </div>
            </div>
        </div>
    </div>
</section>
