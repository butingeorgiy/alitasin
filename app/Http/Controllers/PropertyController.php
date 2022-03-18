<?php

namespace App\Http\Controllers;

use App;
use App\Models\Property;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PropertyController extends Controller
{
    /**
     * Show property creating form.
     *
     * @return Application|Factory|View
     */
    public function showCreateForm()
    {
        return view('admin.create-property');
    }

    public function showEditForm($id)
    {
        /** @var Property $property */
        $property = Property::withTrashed()->findOrFail($id);

        foreach ($property->params as $param) {
            $param->name = $param[App::getLocale() . '_name'];
            $param->en_value = $param->getOriginal('pivot_en_value');
            $param->ru_value = $param->getOriginal('pivot_ru_value');
            $param->tr_value = $param->getOriginal('pivot_tr_value');
            $param->ua_value = $param->getOriginal('pivot_ua_value');
        }

        return view('admin.edit-property', compact('property'));
    }
}
