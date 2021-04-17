<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Region;
use App\Models\Tour;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
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

        $vehicles = [
            [
                'id' => 1,
                'brand' => 'Lamborghini',
                'model' => 'Aventador',
                'price' => 150
            ],
            [
                'id' => 2,
                'brand' => 'Mercedes',
                'model' => 'AMG V2',
                'price' => 150
            ],
            [
                'id' => 3,
                'brand' => 'AUDI',
                'model' => 'RS 7',
                'price' => 150
            ],
            [
                'id' => 4,
                'brand' => 'Mercedes',
                'model' => 'AMG V2',
                'price' => 150
            ],
            [
                'id' => 5,
                'brand' => 'AUDI',
                'model' => 'A7',
                'price' => 150
            ],
            [
                'id' => 6,
                'brand' => 'BMW',
                'model' => 'M3',
                'price' => 150
            ],
            [
                'id' => 7,
                'brand' => 'Mercedes',
                'model' => 'E3 V8',
                'price' => 150
            ],
            [
                'id' => 8,
                'brand' => 'Mercedes',
                'model' => 'AMG V2',
                'price' => 150
            ]
        ];

        foreach ($vehicles as $i => $vehicle) {
            $path = 'vehicle_pictures/vehicle-s-' . $vehicle['id'] . '.png';

            if (Storage::exists($path)) {
                $vehicles[$i]['image'] = 'data:image/jpg;base64,' . base64_encode(Storage::get($path));
            } else {
                $vehicles[$i]['image'] = null;
            }
        }

        return view('index', compact('regions', 'tours', 'filterCounter', 'vehicles'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminIndex()
    {
        $user = Auth::user();

        if ($user->account_type_id === '5') {
            return redirect()->route('create-form-tour');
        }

        return redirect()->route('index');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegion($id)
    {
        $currentRegion = Region::findOrFail($id);

        $tours = Tour::with(['title', 'description', 'images', 'type', 'filters'])
            ->where('region_id', $id)->limit(15)->get();
        $filterCounter = [];
        $popularTours = [];

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
                if ($filter->id === 1) {
                    $popularTours[] = $tour;
                }

                if (isset($filterCounter[$filter->id])) {
                    $filterCounter[$filter->id]++;
                } else {
                    $filterCounter[$filter->id] = 1;
                }
            }
        }


        $regions = Region::where('id', '!=', $id)->get();

        foreach ($regions as $region) {
            $path = 'region_pictures/region-' . $region->id . '-s.jpg';

            if (Storage::exists($path)) {
                $region->image = 'data:image/jpg;base64,' . base64_encode(Storage::get($path));
            }
        }

        return view('region', compact('tours', 'regions', 'currentRegion', 'filterCounter', 'popularTours'));
    }
}
