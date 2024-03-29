<?php

namespace App\Http\Controllers;

use App\Facades\Auth;
use App\Models\Region;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\Tour;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
            $region->image = route('get-image', [
                'dir' => 'region_pictures',
                'file' => 'region-' . $region->id . '-s.jpg'
            ]);
        }

        $tours = Tour::with(['title', 'description', 'images', 'type', 'filters'])->limit(15)->get();
        $filterCounter = [];
        $user = Auth::check(['1']) ? Auth::user() : null;

        foreach ($tours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $tour->image = asset('storage/tour_pictures/' . $image->link);
                }
            }

            foreach ($tour->filters as $filter) {
                if (isset($filterCounter[$filter->id])) {
                    $filterCounter[$filter->id]++;
                } else {
                    $filterCounter[$filter->id] = 1;
                }
            }

            if (!$user) {
                $tour->is_favorite = '0';
                continue;
            }

            $tour->is_favorite = $user->favoriteTours->contains($tour) ? '1' : '0';
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
            $vehicles[$i]['image'] = asset('storage/vehicle_pictures/' . 'vehicle-s-' . $vehicle['id'] . '.png');
        }

        return view('index', compact('regions', 'tours', 'filterCounter', 'vehicles'));
    }

    /**
     * @return RedirectResponse
     */
    public function adminIndex(): RedirectResponse
    {
        $user = Auth::user();

        if (in_array($user->account_type_id, ['3', '5'])) {
            return redirect()->route('tours');
        } else if ($user->account_type_id === '4') {
            return redirect()->route('reserves');
        }

        return redirect()->route('index');
    }

    /**
     * @return RedirectResponse
     */
    public function profileIndex(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->account_type_id === '1') {
            return redirect()->route('client-profile');
        } else if ($user->account_type_id === '2') {
            return redirect()->route('partner-profile');
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
                        'dir' => 'tour_pictures',
                        'file' => $image->link
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
            $region['image'] = asset('storage/region_pictures/' . 'region-' . $region['id'] . '-s.jpg');
        }

        return view('region', compact('tours', 'regions', 'currentRegion', 'filterCounter', 'popularTours'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showTour($id)
    {
        $tour = Tour::with(['title', 'description', 'region', 'additions'])->findOrFail($id);
        $mainImage = null;

        foreach ($tour->images as $image) {
            if ($image->isMain()) {
                $mainImage = asset('storage/tour_pictures/' . $image->link);
                continue;
            }

            $image->data = asset('storage/tour_pictures/' . $image->link);
        }

        $user = null;

        if (Auth::check(['1'])) {
            $user = Auth::user();
            $recentViewed = $user->recentViewed;

            if (!$recentViewed->contains($tour)) {
                if (count($recentViewed) >= 5) {
                    $user->recentViewed()->detach(
                        $user->recentViewed()->orderBy('created_at')
                            ->take(count($recentViewed) - 4)->get()->pluck('id')->toArray()
                    );
                }

                $user->recentViewed()->attach($tour->id);
            }
        }

        foreach ($tour->additions as $addition) {
            $addition->title = $addition[App::getLocale() . '_title'];
            $addition->description = $addition->getOriginal('pivot_' . \App::getLocale() . '_description');
            $addition->is_include = $addition->getOriginal('pivot_is_include');
        }

        $tour->additions = $tour->additions->groupBy('is_include')->toArray();

        return view('tour', compact('tour', 'mainImage', 'user'));
    }

    public function showClientProfile()
    {
        $user = Auth::user();

        if (Storage::exists('profile_pictures/' . $user->id . '.jpg')) {
            $user->profile = asset('storage/profile_pictures/' . $user->id . '.jpg');
        }

        $recentViewed = $user->recentViewed;

        foreach ($recentViewed as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $tour->image = asset('storage/tour_pictures/' . $image->link);
                }
            }
        }

        $reservedTours = $user->reservedTours()->withPivot('id')->get();

        foreach ($reservedTours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $tour->image = asset('storage/tour_pictures/' . $image->link);
                }
            }
        }

        $favoriteTours = $user->favoriteTours()->with(['title', 'description', 'images', 'type', 'filters'])->get();

        foreach ($favoriteTours as $tour) {
            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $tour->image = asset('storage/tour_pictures/' . $image->link);
                }
            }
        }

        return view('profile.client', compact('user', 'recentViewed', 'reservedTours', 'favoriteTours'));
    }

    public function showPartnerProfile()
    {
        /** @var User|null $user */
        $user = Auth::user();

        if (Storage::exists('profile_pictures/' . $user->id . '.jpg')) {
            $user->profile = asset('storage/profile_pictures/' . $user->id . '.jpg');
        }

        $reservations = $user->attractedReservations()->get();

        /** @var Reservation $reservation */
        foreach ($reservations as $reservation) {
            $tickets = [];

            /** @var Ticket $item */
            foreach ($reservation->tickets()->withPivot(['amount', 'percent_from_init_cost'])->get() as $item) {
                $tickets[] = [
                    'title' => $item->name,
                    'amount' => $item->getOriginal('pivot_amount'),
                    'price' => $reservation->tour_init_price * $item->getOriginal('pivot_percent_from_init_cost') / 100
                ];
            }

            $details = [
                'hotel-name' => $reservation->hotel_name ?: 'Ничего не указано',
                'communication-type' => $reservation->communication_type ?: 'Ничего не указано',
                'date' => $reservation->getOriginal('date'),
                'time' => $reservation->getOriginal('time') ?: 'Ничего не указано',
                'user-name' => $reservation->user->full_name,
                'user-email' => $reservation->user->email,
                'user-phone' => $reservation->user->phone,
                'total-cost' => $reservation->costWithSale(),
                'tickets' => $tickets,
                'partner-profit' => $reservation->costWithSale() * $user->profit_percent / 100
            ];

            if ($reservation->isUsedPromoCode()) {
                $details['promo-code'] = [
                    'code' => $reservation->promoCode->code,
                    'percent' => $reservation->promoCodeSalePercent()
                ];
            } else {
                $details['promo-code'] = null;
            }

            $reservation['details'] = $details;
        }

        return view('profile.partner', compact('user', 'reservations'));
    }

    public function showVehicles(Request $request)
    {
        if (!$request->has('vehicle_type_id')) {
            return redirect()->route('vehicles', [
                'vehicle_type_id' => 1
            ]);
        }

        if (!VehicleType::find($request->input('vehicle_type_id'))) {
            abort(404);
        }

        $vehicles = Vehicle::where('type_id', $request->input('vehicle_type_id'));

        if ($request->has('region_id')) {
            $vehicles = $vehicles->where('region_id', $request->input('region_id'));
        }

        if (Auth::check(['5'])) {
            $vehicles = $vehicles->withTrashed()->get();
        } else {
            $vehicles = $vehicles->get();
        }

        return view('vehicles', compact('vehicles'));
    }

    public function showTransfers()
    {
        return view('transfers');
    }
}
