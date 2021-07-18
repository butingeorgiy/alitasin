<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Reservation;
use App\Models\Ticket;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ReservationController extends Controller
{
    /**
     * Show all reservations
     *
     * @return Application|Factory|View
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

        $reservations = Reservation::with(['tour', 'user', 'promoCode', 'status'])
            ->where('manager_id', $user->id);

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

        $totalAmount = $reservations->count();
        $reservations = $reservations->limit($request->input('limit', 15))->get();

        /** @var Reservation $reservation */
        foreach ($reservations as $reservation) {
            $tickets = [];

            /** @var Ticket $item */
            foreach ($reservation->tickets()->withPivot(['amount', 'percent_from_init_cost'])->get() as $item) {
                $tickets[] = [
                    'title' => $item->name,
                    'amount' => $item->getOriginal('pivot_amount'),
                    'price' => $reservation->tour_init_price * $item->getOriginal('pivot_percent_from_init_cost') / 100
                ];
            }

            $details = [
                'hotel-name' => $reservation->hotel_name ?: 'Ничего не указано',
                'communication-type' => $reservation->communication_type ?: 'Ничего не указано',
                'date' => $reservation->getOriginal('date'),
                'time' => $reservation->getOriginal('time') ?: 'Ничего не указано',
                'user-name' => $reservation->user->full_name,
                'user-email' => $reservation->user->email,
                'user-phone' => $reservation->user->phone,
                'total-cost' => $reservation->costWithSale(),
                'tickets' => $tickets
            ];

            if ($reservation->isUsedPromoCode()) {
                $details['promo-code'] = [
                    'code' => $reservation->promoCode->code,
                    'percent' => $reservation->promoCodeSalePercent()
                ];
            } else {
                $details['promo-code'] = null;
            }

            $reservation['details'] = $details;
        }

        return view('admin.reserves', compact('user', 'reservations', 'dateRange', 'totalAmount'));
    }
}
