<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AirportRequest;
use App\Models\Airport;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Get all airports.
     *
     * @return Airport[]|Collection
     */
    public function getAll(Request $request)
    {
        if ($request->input('with_deleted') !== '1') {
            return Airport::all();
        }

        return Airport::withTrashed()->get();
    }

    /**
     * Create a new airport.
     *
     * @param AirportRequest $request
     * @return array
     * @throws Exception
     */
    public function create(AirportRequest $request): array
    {
        $airport = new Airport($request->only('en_name', 'ru_name', 'tr_name', 'ua_name'));

        if (!$airport->save()) {
            throw new Exception(__('messages.airport-creation-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.airport-created-successfully')
        ];
    }

    /**
     * Update airport.
     *
     * @param AirportRequest $request
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update(AirportRequest $request, $id): array
    {
        if (!$airport = Airport::find($id)) {
            throw new Exception(__('messages.airport-not-found'));
        }

        if ($airport->en_name !== $request->input('en_name')) {
            $airport->en_name = $request->input('en_name');
        }

        if ($airport->ru_name !== $request->input('ru_name')) {
            $airport->ru_name = $request->input('ru_name');
        }

        if ($airport->tr_name !== $request->input('tr_name')) {
            $airport->tr_name = $request->input('tr_name');
        }

        if ($airport->ua_name !== $request->input('ua_name')) {
            $airport->ua_name = $request->input('ua_name');
        }

        if (!$airport->save()) {
            throw new Exception(__('messages.updating-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Delete airport.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        if (!$airport = Airport::find($id)) {
            throw new Exception(__('messages.airport-not-found'));
        }

        if (!$airport->delete()) {
            throw new Exception(__('messages.airport-deleting-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.airport-deleting-success')
        ];
    }

    /**
     * Restore airport.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function restore($id): array
    {
        if (!$airport = Airport::onlyTrashed()->find($id)) {
            throw new Exception(__('messages.airport-not-found'));
        }

        if (!$airport->restore()) {
            throw new Exception(__('messages.airport-restoring-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.airport-restoring-success')
        ];
    }
}
