<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function showCreateForm()
    {
        return view('admin.create-vehicle');
    }
}
