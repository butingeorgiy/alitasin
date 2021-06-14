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

        return view('admin.edit-vehicle', compact('vehicle'));
    }
}
