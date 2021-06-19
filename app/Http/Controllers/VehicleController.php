<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function showCreateForm()
    {
        return view('admin.create-vehicle');
    }

    public function showEditForm($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        foreach ($vehicle->params as $param) {
            $param->name = $param[\App::getLocale() . '_name'];
            $param->en_value = $param->getOriginal('pivot_en_value');
            $param->ru_value = $param->getOriginal('pivot_ru_value');
            $param->tr_value = $param->getOriginal('pivot_tr_value');
            $param->ua_value = $param->getOriginal('pivot_ua_value');
        }

        return view('admin.edit-vehicle', compact('vehicle'));
    }
}
