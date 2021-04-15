<?php

namespace App\Http\Controllers;

use App\Models\Tour;

class TourController extends Controller
{
    /**
     * Show creation form
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreateForm()
    {
        return view('admin.create-tour');
    }

    /**
     * Show editing form
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditForm($id)
    {
        $tour = Tour::with(['title', 'description', 'images', 'type', 'manager', 'region', 'filters'])->findOrFail($id);

        return view('admin.edit-tour', compact('tour'));
    }

    public function showAll()
    {
        return view('admin.tours');
    }
}
