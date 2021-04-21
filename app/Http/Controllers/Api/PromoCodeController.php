<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PromoCode;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function get(Request $request)
    {
        $code = $request->input('code');

        if (!$code) {
            throw new \Exception(__('messages.promo-code-required'));
        }

        $promoCode = PromoCode::where('code', $code)->select('id', 'sale_percent')->get()->first();

        if (!$promoCode) {
            throw new \Exception(__('messages.promo-code-not-found'));
        }

        return $promoCode;
    }
}
