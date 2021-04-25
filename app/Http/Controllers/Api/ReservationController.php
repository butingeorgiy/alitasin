<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use Exception;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Update reservation's status
     *
     * @param Request $request
     * @param $reservationId
     * @return array
     * @throws Exception
     */
    public function updateStatus(Request $request, $reservationId): array
    {
        if (!$reservation = Reservation::find($reservationId)) {
            throw new Exception(__('messages.reservation-not-found'));
        }

        if (!$status = ReservationStatus::find($request->input('reservation_status_id'))) {
            throw new Exception(__('messages.reservation-status-not-found'));
        }

        $reservation->status()->associate($status);

        if (!$reservation->save()) {
            throw new Exception(__('messages.updating-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.updating-success')
        ];
    }
}
