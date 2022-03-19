<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Tour;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TourController extends Controller
{
    /**
     * Show creation form.
     *
     * @return Application|Factory|View
     */
    public function showCreateForm(): Application|Factory|View
    {
        return view('admin.create-tour');
    }

    /**
     * Show editing form.
     *
     * @param $id
     *
     * @return Application|Factory|View
     */
    public function showEditForm($id): Application|Factory|View
    {
        /** @var Tour $tour */
        $tour = Tour::with(['title', 'description', 'images', 'type', 'manager', 'region', 'filters', 'additions'])->findOrFail($id);

        foreach ($tour->additions as $addition) {
            $addition->title = $addition[app()->getLocale() . '_title'];
            $addition->en_description = $addition->getOriginal('pivot_en_description');
            $addition->ru_description = $addition->getOriginal('pivot_ru_description');
            $addition->tr_description = $addition->getOriginal('pivot_tr_description');
            $addition->ua_description = $addition->getOriginal('pivot_ua_description');
            $addition->is_include = $addition->getOriginal('pivot_is_include');
        }

        $tour->additions = $tour->additions->groupBy('is_include')->toArray();

        return view('admin.edit-tour', compact('tour'));
    }

    /**
     * Show all tours.
     *
     * @return Application|Factory|View
     */
    public function showAll(): Application|Factory|View
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
