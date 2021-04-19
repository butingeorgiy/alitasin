<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Region;
use App\Models\Tour;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function showIndex()
    {
        $regions = collect(Region::where('show_at_index_page', '1')->get())->random(6);

        foreach ($regions as $region) {
            $region->image = route('get-image', [
                'fileName' => 'region-' . $region->id . '-s.jpg',
                'entity' => 'region'
            ]);
        }

        $tours = Tour::with(['title', 'description', 'images', 'type', 'filters'])->limit(15)->get();
        $filterCounter = [];

        foreach ($tours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $tour->image = route('get-image', ['fileName' => $image->link, 'entity' => 'tour']);
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
            $vehicles[$i]['image'] = route('get-image', [
                'fileName' => 'vehicle-s-' . $vehicle['id'] . '.png',
                'entity' => 'vehicle'
            ]);
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
                    $tour->image = route('get-image', [
                        'fileName' => $image->link,
                        'entity' => 'tour'
                    ]);
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


        $regions = collect(Region::where('id', '!=', $id)->get())->random(6)->shuffle();

        foreach ($regions as $region) {
            $region['image'] = route('get-image', [
                'fileName' => 'region-' . $region['id'] . '-s.jpg',
                'entity' => 'region'
            ]);
        }

        return view('region', compact('tours', 'regions', 'currentRegion', 'filterCounter', 'popularTours'));
    }

    public function showTour($id)
    {
        $tour = Tour::findOrFail($id);
        $mainImage = null;

        foreach ($tour->images as $image) {
            if ($image->isMain()) {
                $mainImage = route('get-image', ['fileName' => $image->link, 'entity' => 'tour']);
                continue;
            }

            $image->data = route('get-image', ['fileName' => $image->link, 'entity' => 'tour']);
        }

        return view('tour', compact('tour', 'mainImage'));
    }
}
