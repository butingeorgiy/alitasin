<section id="regionsSection" class="mb-10 border-b border-gray-200">
    <div class="container mx-auto px-5 pb-6">
        <p class="mb-2 sm:mb-4 lg:text-center text-black text-2xl font-bold text-black">{{ __('short-phrases.tours-around-turkey') }}<span class="text-blue">.</span></p>
        <div class="hidden sm:grid grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($regions as $region)
                <a href="#" class="region-card relative top-0 flex justify-center items-center text-white text-3xl font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md duration-300 hover:shadow-xl"
                   style="height: 180px; background-image: url({{ $region->image }})">
                    {{ $region->name }}
                </a>
            @endforeach
        </div>

        <div class="block sm:hidden swiper-container -mx-3">
            <div class="swiper-wrapper -mx-2 px-5 py-2">
                @foreach($regions as $region)
                    <a href="#" class="swiper-slide relative flex justify-center items-center w-72 text-white text-3xl font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md"
                       style="height: 180px; background-image: url({{ $region->image }})">
                        {{ $region->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
