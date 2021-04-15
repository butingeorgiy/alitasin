<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Region;
use App\Models\Tour;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function showIndex()
    {
        $regions = Region::where('show_at_index_page', '1')->get();

        foreach ($regions as $region) {
            $path = 'region_pictures/region-' . $region->id . '-s.jpg';

            if (Storage::exists($path)) {
                $region->image = 'data:image/jpg;base64,' . base64_encode(Storage::get($path));
            }
        }

        $tours = Tour::with(['title', 'description', 'images', 'type', 'filters'])->limit(15)->get();
        $filterCounter = [];

        foreach ($tours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $path = 'tour_pictures/' . $image->link;

                    if (Storage::exists($path)) {
                        $tour->image = 'data:image/jpg;base64,' . base64_encode(Storage::get($path));
                    }
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

        return view('index', compact('regions', 'tours', 'filterCounter'));
    }

    public function adminIndex()
    {
        $user = Auth::user();

        if ($user->account_type_id === '5') {
            return redirect()->route('create-form-tour');
        }

        return redirect()->route('index');
    }
}
