<section id="promoCodeStatisticSection" class="my-10 pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <p class="mb-4 text-black text-2xl font-bold text-black">{{ __('short-phrases.statistic') }}<span class="text-blue">.</span></p>

        <div class="grid gap-5 grid-cols-4">
            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200"
                 title="{{ __('page-titles.reserves') }}: {{ $attractedReservations }}; {{ __('short-phrases.transfers') }}: {{  $attractedTransfers}}; {{ __('page-titles.vehicles') }}: {{ $attractedVehicles }}">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.attracted') }}:</p>
                <p class="text-center font-semibold">
                    {{ $attractedReservations + $attractedTransfers + $attractedVehicles }}
                </p>
            </div>

            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.income') }}:</p>
                <p class="text-center font-semibold">$ {{ $income }}</p>
            </div>

            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.earned') }}:</p>
                <p class="text-center font-semibold">$ {{ $earned }}</p>
            </div>

            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.payed') }}:</p>
                <p class="text-center font-semibold">$ {{ $payed }}</p>
            </div>
        </div>
    </div>
</section>