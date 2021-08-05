<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TransferDestinationRequest;
use App\Models\TransferDestination;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferDestinationController extends Controller
{
    /**
     * Get all destinations.
     *
     * @param Request $request
     * @return TransferDestination[]|Collection
     */
    public function getAll(Request $request)
    {
        if ($request->input('with_deleted') !== '1') {
            return TransferDestination::all();
        }

        return TransferDestination::withTrashed()->get();
    }

    /**
     * Create a new transfer destination.
     *
     * @param TransferDestinationRequest $request
     * @return array
     * @throws Exception
     */
    public function create(TransferDestinationRequest $request): array
    {
        $destination = new TransferDestination($request->only('en_name', 'ru_name', 'tr_name', 'ua_name'));

        if (!$destination->save()) {
            throw new Exception(__('messages.destination-creation-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.destination-created-successfully')
        ];
    }

    /**
     * Update destination.
     *
     * @param TransferDestinationRequest $request
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update(TransferDestinationRequest $request, $id): array
    {
        if (!$destination = TransferDestination::withTrashed()->find($id)) {
            throw new Exception(__('messages.destination-not-found'));
        }

        if ($destination->en_name !== $request->input('en_name')) {
            $destination->en_name = $request->input('en_name');
        }

        if ($destination->ru_name !== $request->input('ru_name')) {
            $destination->ru_name = $request->input('ru_name');
        }

        if ($destination->tr_name !== $request->input('tr_name')) {
            $destination->tr_name = $request->input('tr_name');
        }

        if ($destination->ua_name !== $request->input('ua_name')) {
            $destination->ua_name = $request->input('ua_name');
        }

        if (!$destination->save()) {
            throw new Exception(__('messages.updating-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Delete transfer destination.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        if (!$destination = TransferDestination::find($id)) {
            throw new Exception(__('messages.destination-not-found'));
        }

        if (!$destination->delete()) {
            throw new Exception(__('messages.destination-deleting-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.destination-deleting-success')
        ];
    }

    /**
     * Restore transfer destination.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function restore($id): array
    {
        if (!$destination = TransferDestination::onlyTrashed()->find($id)) {
            throw new Exception(__('messages.destination-not-found'));
        }

        if (!$destination->restore()) {
            throw new Exception(__('messages.destination-restoring-failed'));
        }

        return [
            'success' => true,
            'message' => __('messages.destination-restoring-success')
        ];
    }
}
