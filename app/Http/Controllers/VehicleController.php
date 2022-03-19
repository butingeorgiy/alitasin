<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class VehicleController extends Controller
{
    /**
     * Show vehicle creation form.
     *
     * @return Application|Factory|View
     */
    public function showCreateForm(): Application|Factory|View
    {
        return view('admin.create-vehicle');
    }

    /**
     * Show vehicle editing form.
     *
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function showEditForm($id): Application|Factory|View
    {
        /** @var Vehicle $vehicle */
        $vehicle = Vehicle::withTrashed()->findOrFail($id);

        foreach ($vehicle->params as $param) {
            $param->name = $param[app()->getLocale() . '_name'];
            $param->en_value = $param->getOriginal('pivot_en_value');
            $param->ru_value = $param->getOriginal('pivot_ru_value');
            $param->tr_value = $param->getOriginal('pivot_tr_value');
            $param->ua_value = $param->getOriginal('pivot_ua_value');
        }

        return view('admin.edit-vehicle', compact('vehicle'));
    }
}
