<?php

/**
 * @var App\Models\User $partner
 */

?>

<div class="partners-item grid grid grid-cols-partners-table gap-5 px-8 py-4 border-b last:border-0 border-gray-200">
    <div class="flex">
        <div class="min-w-11 min-h-11 w-11 h-11 mr-6 bg-contain bg-center bg-no-repeat bg-blue rounded-full"></div>
        <div class="flex flex-col justify-center">
            <a href="{{ route('partner', $partner->id) }}" class="text-black font-semibold">{{ $partner->full_name }}</a>
            <p class="text-sm text-gray-600 font-light">{{ $partner->email }}</p>
        </div>
    </div>
    <div class="flex items-center">
        <p class="text-black font-semibold select-text">{{ $partner->promoCodes()->first()['code'] }}</p>
    </div>
    <div class="flex items-center">
        <p class="text-black font-semibold">$ {{ $partner->getTotalIncome() }}</p>
    </div>
    <div class="flex items-center">
        <p class="text-black font-semibold">$ {{ $partner->getTotalProfit() }}</p>
    </div>
    <div class="flex items-center">
        <p class="text-black font-semibold">$ {{ $partner->getPaymentAmount() }}</p>
    </div>
    <div class="relative flex items-center">
        @if($partner->trashed())
            <div class="flex justify-center w-14 py-1 text-sm text-white bg-red rounded-full" title="Неактивен">
                <svg class="min-w-4 min-h-4 w-4 h-4" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.05749 5.99936L11.7796 1.28477C11.9207 1.14363 12 0.952206 12 0.752604C12 0.553001 11.9207 0.361573 11.7796
                    0.220433C11.6384 0.079292 11.447 0 11.2474 0C11.0478 0 10.8564 0.079292 10.7152 0.220433L6.00064 4.94251L1.28605
                    0.220433C1.14491 0.079292 0.953486 1.77216e-07 0.753883 1.78703e-07C0.55428 1.80191e-07 0.362852 0.079292 0.221712
                    0.220433C0.0805711 0.361573 0.00127934 0.553001 0.00127934 0.752604C0.00127934 0.952206 0.0805711 1.14363 0.221712
                    1.28477L4.94379 5.99936L0.221712 10.7139C0.151459 10.7836 0.0956977 10.8665 0.0576447 10.9579C0.0195917 11.0492 0
                    11.1472 0 11.2461C0 11.3451 0.0195917 11.443 0.0576447 11.5344C0.0956977 11.6257 0.151459 11.7086 0.221712 11.7783C0.291391
                    11.8485 0.37429 11.9043 0.465628 11.9424C0.556966 11.9804 0.654935 12 0.753883 12C0.852831 12 0.950799 11.9804 1.04214
                    11.9424C1.13348 11.9043 1.21637 11.8485 1.28605 11.7783L6.00064 7.05621L10.7152 11.7783C10.7849 11.8485 10.8678 11.9043
                    10.9591 11.9424C11.0505 11.9804 11.1484 12 11.2474 12C11.3463 12 11.4443 11.9804 11.5357 11.9424C11.627 11.9043 11.7099
                    11.8485 11.7796 11.7783C11.8498 11.7086 11.9056 11.6257 11.9436 11.5344C11.9817 11.443 12.0013 11.3451 12.0013 11.2461C12.0013
                    11.1472 11.9817 11.0492 11.9436 10.9579C11.9056 10.8665 11.8498 10.7836 11.7796 10.7139L7.05749 5.99936Z" fill="white"/>
                </svg>
            </div>
        @else
            <div class="flex justify-center w-14 py-1 text-sm text-white bg-green-100 rounded-full" title="Активен">
                <svg class="min-w-5 min-h-5 w-5 h-5" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.7099 1.20998C14.617 1.11625 14.5064 1.04186 14.3845 0.991091C14.2627 0.940323 14.132 0.914185
                             13.9999 0.914185C13.8679 0.914185 13.7372 0.940323 13.6154 0.991091C13.4935 1.04186 13.3829 1.11625
                             13.29 1.20998L5.83995 8.66998L2.70995 5.52998C2.61343 5.43674 2.49949 5.36343 2.37463 5.31423C2.24978
                             5.26502 2.11645 5.24089 1.98227 5.24321C1.84809 5.24553 1.71568 5.27426 1.5926 5.32776C1.46953 5.38125
                             1.35819 5.45846 1.26495 5.55498C1.17171 5.6515 1.0984 5.76545 1.04919 5.8903C0.999989 6.01516 0.975859
                             6.14848 0.97818 6.28266C0.980502 6.41684 1.00923 6.54925 1.06272 6.67233C1.11622 6.79541 1.19343 6.90674
                             1.28995 6.99998L5.12995 10.84C5.22291 10.9337 5.33351 11.0081 5.45537 11.0589C5.57723 11.1096 5.70794
                             11.1358 5.83995 11.1358C5.97196 11.1358 6.10267 11.1096 6.22453 11.0589C6.34639 11.0081 6.45699 10.9337
                             6.54995 10.84L14.7099 2.67998C14.8115 2.58634 14.8925 2.47269 14.9479 2.34619C15.0033 2.21969 15.0319
                             2.08308 15.0319 1.94498C15.0319 1.80688 15.0033 1.67028 14.9479 1.54378C14.8925 1.41728 14.8115 1.30363
                             14.7099 1.20998Z" fill="white" />
                </svg>
            </div>
        @endif

        <div class="show-custom-dropdown-button relative -right-2 ml-auto cursor-pointer">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1
                                     10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM12 16C10.9 16 10 16.9 10 18C10 19.1 10.9 20 12 20C13.1 20
                                     14 19.1 14 18C14 16.9 13.1 16 12 16Z" fill="#C5C7CD" />
            </svg>
        </div>

        <!-- Drop down menu -->
        <div class="hidden custom-dropdown-container origin-top-right absolute -right-4 top-full z-10 w-56 rounded-md shadow-lg bg-white border border-gray-200 transition ease-out duration-100 transform opacity-0 scale-95"
             role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
            <div class="py-1 rounded-md overflow-hidden" role="none">
                @if($partner->trashed())
                    <div class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100"
                         data-option-name="restore" data-option-params="{{ json_encode(['id' => $partner->id]) }}">
                        {{ __('short-phrases.activate') }}
                    </div>
                @else
                    @if($partner->total_payment_amount < $partner->total_profit)
                        <div class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100"
                             data-option-name="make-payment" data-option-params="{{ json_encode(['id' => $partner->id]) }}">
                            {{ __('short-phrases.make-payment') }}
                        </div>
                    @endif
                    <div class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100"
                         data-option-name="delete" data-option-params="{{ json_encode(['id' => $partner->id]) }}">
                        {{ __('short-phrases.block') }}
                    </div>
                    <div class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100"
                         data-option-name="update-partner-profit-percent" data-option-params="{{ json_encode(['id' => $partner->id, 'current_value' => $partner->profit_percent, 'is_sub_partner_percent' => '0']) }}">
                        {{ __('short-phrases.update-partner-profit-percent-option') }}
                    </div>
                    @if($partner->isSubPartner())
                        <div class="custom-dropdown-option block px-4 py-2 text-sm text-black cursor-pointer hover:bg-gray-100"
                             data-option-name="update-partner-profit-percent" data-option-params="{{ json_encode(['id' => $partner->id, 'current_value' => $partner->sub_partners_profit_percent, 'is_sub_partner_percent' => '1']) }}">
                            {{ __('short-phrases.update-sub-partner-profit-percent-option') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
