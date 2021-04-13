<section id="reviewsSliderSection" class="mb-10 pb-4 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <p class="ml-12 mb-2 text-black text-2xl font-bold text-black">{{ __('short-phrases.clients-reviews') }}<span class="text-blue">.</span></p>


        <div class="swiper-container -mx-3">
            <div class="swiper-wrapper -mx-2 px-5 py-2">
                @for($i = 1; $i <= 4; $i++)
                    <div class="swiper-slide p-3 shadow rounded-xl">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 mr-4 rounded-full bg-blue bg-center bg-no-repeat bg-cover"></div>
                            <p class="text-black font-bold">George</p>
                        </div>
                        <p class="text-black font-medium leading-5">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>
