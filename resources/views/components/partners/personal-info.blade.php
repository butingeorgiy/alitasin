<section id="personalPartnerInfoSection" class="my-10 pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <p class="ml-5 mb-4 text-black text-2xl font-bold text-black">{{ __('short-phrases.personal-info') }}<span class="text-blue">.</span></p>
        <div class="grid lg:grid-cols-2">
            <div class="flex flex-col px-5 py-5 col-span-1 bg-white rounded-md shadow">
                <div class="personal-info-form grid sm:grid-cols-2 gap-5 mb-2">
                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.first-name') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="first_name" value="{{ $partner->first_name }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.last-name') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="last_name" value="{{ $partner->last_name }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.phone') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="phone" value="{{ $partner->phone }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>

                    <label class="col-span-1">
                        <span class="mb-3 text-sm text-gray-500">{{ __('short-phrases.email') }}</span>
                        <span class="flex items-center pb-1 border-b border-black cursor-pointer">
                            <input class="w-full mr-auto text-sm text-black font-semibold" type="text" readonly
                                   name="email" value="{{ $partner->email }}" placeholder="{{ __('short-phrases.nothing-entered') }}">
                        </span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</section>
