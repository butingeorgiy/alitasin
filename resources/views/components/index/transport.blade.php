<section id="transportSection" class="mb-10 pb-4 sm:pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <div class="flex justify-between items-center lg:justify-center mb-2 sm:mb-4">
            <p class="inline text-black text-2xl font-bold text-black">{{ __('short-phrases.transport') }}<span class="text-blue">.</span></p>
            <a class="block sm:hidden px-5 py-1 text-sm text-blue border-2 border-blue rounded-md cursor-pointer">{{ __('buttons.show-all') }}</a>
        </div>

        <div class="hidden sm:grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($vehicles as $vehicle)
                <div class="flex flex-col px-3 pt-5 pb-3 bg-gray-100 shadow rounded-md">
                    <div class="w-44 h-20 self-center mb-4 bg-contain bg-center bg-no-repeat" style="background-image: url({{ $vehicle['image'] }})"></div>
                    <div class="flex items-end mt-auto text-sm font-medium">
                        <p class="mr-auto leading-4 text-black">{{ $vehicle['brand'] }} <span class="text-gray-600 font-light">{{ $vehicle['model'] }}</span></p>
                        <p class="whitespace-nowrap">$ {{ $vehicle['price'] }} / <span class="text-gray-600 font-light">{{ __('short-phrases.day') }}</span></p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="block sm:hidden swiper-container -mx-3">
            <div class="swiper-wrapper -mx-2 px-5 py-2">
                @foreach($vehicles as $vehicle)
                    <div class="swiper-slide flex flex-col w-72 px-3 pt-5 pb-3 bg-gray-100 shadow rounded-md">
                        <div class="w-44 h-20 self-center mb-4 bg-contain bg-center bg-no-repeat" style="background-image: url({{ $vehicle['image'] }})"></div>
                        <div class="flex items-end mt-auto text-sm font-medium">
                            <p class="mr-auto leading-4 text-black">{{ $vehicle['brand'] }} <span class="text-gray-600 font-light">{{ $vehicle['model'] }}</span></p>
                            <p class="whitespace-nowrap">$ {{ $vehicle['price'] }} / <span class="text-gray-600 font-light">{{ __('short-phrases.day') }}</span></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
