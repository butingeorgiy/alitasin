<section id="promoCodeInfoSection" class="my-10 pb-6 border-b border-gray-200">
    <div class="container mx-auto px-5">
        <p class="mb-4 text-black text-2xl font-bold text-black">{{ __('short-phrases.promo-code-info') }}<span class="text-blue">.</span></p>

        <div class="grid gap-5 {{ isset($subPartnerProfitPercent) ? 'grid-cols-4' : 'grid-cols-3' }}">
            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.promo-code') }}:</p>
                <p class="text-center font-semibold select-text">{{ $promoCode }}</p>
            </div>

            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.sale-percent') }}:</p>
                <p class="text-center font-semibold">{{ $salePercent }} %</p>
            </div>

            <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.profit-percent') }}:</p>
                <p class="text-center font-semibold">{{ $profitPercent }} %</p>
            </div>

            @if($subPartnerProfitPercent ?? false)
                <div class="flex flex-col px-5 py-3 bg-white rounded border border-gray-200">
                    <p class="mb-1 text-sm text-center text-gray-800 font-medium">{{ __('short-phrases.sub-partner-profit-percent') }}:</p>
                    <p class="text-center font-semibold">{{ $subPartnerProfitPercent }} %</p>
                </div>
            @endif
        </div>
    </div>
</section>