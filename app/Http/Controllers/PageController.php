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

        $tours = Tour::with(['title', 'description', 'images', 'type'])->limit(15)->get();

        foreach ($tours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $path = 'tour_pictures/' . $image->link;

                    if (Storage::exists($path)) {
                        $tour->image = 'data:image/jpg;base64,' . base64_encode(Storage::get($path));
                    }
                }
            }
        }

        return view('index', compact('regions', 'tours'));
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
