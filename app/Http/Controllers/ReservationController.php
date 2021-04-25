<?php

namespace App\Http\Controllers;


use App\Facades\Auth;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /**
     * Show all reservations
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showAll(Request $request)
    {
        $user = Auth::user();

        if (Storage::exists('profile_pictures/' . $user->id . '.jpg')) {
            $user->profile = route('get-image', [
                'dir' => 'profile_pictures',
                'file' => $user->id . '.jpg'
            ]);
        }

        $reservations = Reservation::with(['tour', 'user', 'promoCode', 'status'])->where('manager_id', $user->id);

        // Filtering rows
        if ($request->input('tour_id')) {
            $reservations->where('tour_id', $request->input('tour_id'));
        }

        $dateRange = [];

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->input('date_min')) and
            preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->input('date_max'))) {
            $reservations->where('date', '>=', $request->input('date_min'))
                ->where('date', '<=', $request->input('date_max'));

            $dateRange = [
                Carbon::parse($request->input('date_min'))->format('d.m.y'),
                Carbon::parse($request->input('date_max'))->format('d.m.y')
            ];
        }

        if (preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $request->input('time'))) {
            $reservations->where(
                'time',
                '=',
                Carbon::parse($request->input('time'))->format('H:i:00')
            );
        }

        $reservations = $reservations->get();

        foreach ($reservations as $reservation) {
            $details = [
                'hotel-name' => $reservation->hotel_name ?: 'Ничего не указано',
                'communication-type' => $reservation->communication_type ?: 'Ничего не указано',
                'date' => $reservation->getOriginal('date'),
                'time' => $reservation->getOriginal('time') ?: 'Ничего не указано',
                'user-name' => $reservation->user->full_name,
                'user-email' => $reservation->user->email,
                'user-phone' => $reservation->user->phone,
                'total-cost' => $reservation->costWithSale()
            ];

            if ($reservation->isUsedPromoCode()) {
                $details['promo-code'] = [
                    'code' => $reservation->promoCode->code,
                    'percent' => $reservation->promoCodeSalePercent()
                ];
            } else {
                $details['promo-code'] = null;
            }

            $reservation->details = $details;
        }

        return view('admin.reserves', compact('user', 'reservations', 'dateRange'));
    }
}
