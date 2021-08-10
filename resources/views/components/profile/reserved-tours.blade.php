@if(count($reservedTours) > 0)
    <section id="toursSliderSection" class="mt-4 mb-10 pb-4 border-b border-gray-200">
        <div class="container mx-auto px-5">
            <p class="mb-2 text-black text-2xl font-bold text-black">
                {{ __('short-phrases.reserved-tours') }}<span class="text-blue">.</span>
            </p>
            <div class="swiper-container -ml-1">
                <div class="swiper-wrapper pl-1 py-2">
                    @foreach($reservedTours as $tour)
                        <a href="{{ asset('storage/tickets/' . $tour->getOriginal('pivot_id') . '.pdf') }}" class="swiper-slide flex flex-col relative w-72 h-auto p-3 bg-cover bg-center bg-no-repeat shadow rounded-md"
                           style="background-image: url({{ $tour->image }})">
                            <div class="absolute w-full h-full z-0 -ml-3 -mt-3 bg-black bg-opacity-30 rounded-md"></div>
                            <div class="flex items-center self-start z-10 mb-16 px-3 pt-0.5 text-sm text-black font-bold bg-white rounded-full">
                                <span class="text-yellow">$</span>&nbsp;{{ $tour->price }}
                            </div>
                            <p class="z-10 mt-auto text-white font-medium leading-5">{{ __('short-phrases.reservation') . ' № ' . $tour->getOriginal('pivot_id') . ' — ' . $tour->title[App::getLocale()] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
