<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Tour;
use Illuminate\Support\Facades\Storage;

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
        $user = Auth::user();

        if (Storage::exists('profile_pictures/' . $user->id . '.jpg')) {
            $user->profile = route('get-image', [
                'dir' => 'profile_pictures',
                'file' => $user->id . '.jpg'
            ]);
        }

        $tours = Tour::with(['title', 'description', 'images', 'type', 'filters'])->limit(15)->get();
        $filterCounter = [];

        foreach ($tours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $tour->image = route('get-image', [
                        'dir' => 'tour_pictures',
                        'file' => $image->link
                    ]);
                }
            }

            foreach ($tour->filters as $filter) {
                if (isset($filterCounter[$filter->id])) {
                    $filterCounter[$filter->id]++;
                } else {
                    $filterCounter[$filter->id] = 1;
                }
            }
        }

        return view('admin.tours', compact('user', 'tours', 'filterCounter'));
    }
}
