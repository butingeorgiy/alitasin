<section id="regionsSection" class="mb-10">
    <div class="container mx-auto px-5">
        <p class="mb-4 text-center text-black text-2xl font-bold text-black">{{ __('short-phrases.tours-around-turkey') }}<span class="text-blue">.</span></p>
        <div class="grid grid-cols-3 gap-4">
            @foreach($regions as $region)
                <a href="#" class="region-card relative top-0 flex justify-center items-center text-white text-3xl font-bold tracking-wide bg-center bg-cover bg-no-repeat rounded-md duration-300 hover:shadow-xl"
                   style="height: 180px; background-image: url({{ $region->image }})">
                    {{ $region->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>
