<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Facades\Reg;
use App\Http\Requests\TourRequest;
use App\Http\Requests\TourReserveRequest;
use App\Mail\TourReserved;
use App\Models\PromoCode;
use App\Models\Region;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Models\Tour;
use App\Models\TourDescription;
use App\Models\TourImage;
use App\Models\TourTitle;
use App\Models\TourType;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class TourController extends Controller
{
    /**
     * Create a new tour
     *
     * @param TourRequest $request
     * @return array
     * @throws Exception
     */
    public function create(TourRequest $request): array
    {
        // Region validation
        $region = Region::find($request->input('region_id'));

        if (!$region) {
            throw new Exception(__('messages.region-not-found'));
        }

        // Manager validation
        $manager = User::managers()->find($request->input('manager_id'));

        if (!$manager) {
            throw new Exception(__('messages.manager-not-found'));
        }

        // Tour type validation
        $tourType = TourType::find($request->input('tour_type_id'));

        if (!$tourType) {
            throw new Exception(__('messages.tour-type-not-found'));
        }

        // Images validation
        if (count($request->file()) === 0) {
            throw new Exception(__('messages.tour-must-have-image'));
        }

        if (count($request->file()) > 5) {
            throw new Exception(__('messages.tour-can-have-max-five-images'));
        }

        foreach ($request->file() as $file) {
            if ($file->getSize() > 2000000) {
                throw new Exception(__('messages.max-uploaded-file-size'));
            }

            if (!in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
                throw new Exception(__('messages.allowed-file-extensions'));
            }
        }

        // Filters validation
        $filters = json_decode($request->input('filters'));

        if (count($filters) === 0) {
            throw new Exception(__('messages.tour-filters-min'));
        }

        // Conducting days validation
        $days = json_decode($request->input('conducted_at'));

        if (count($days) === 0) {
            throw new Exception(__('messages.tour-conducted-at-min'));
        }

        foreach ($days as $day) {
            if (!in_array($day, ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'])) {
                throw new Exception(__('messages.week-day-invalid'));
            }
        }

        if ($request->has('additions')) {
            $additions = [];
            $parsedAdditions = json_decode($request->input('additions'));

            foreach ($parsedAdditions as $addition) {
                $additions[$addition->id] = [
                    'en_description' => $addition->en_description ?: null,
                    'ru_description' => $addition->ru_description ?: null,
                    'tr_description' => $addition->tr_description ?: null,
                    'ua_description' => $addition->ua_description ?: null,
                    'is_include' => $addition->is_include
                ];
            }
        }

        // Creating tour
        $tour = new Tour();

        $tourTitle = TourTitle::create([
            'ru' => $request->input('ru_title'),
            'en' => $request->input('en_title'),
            'tr' => $request->input('tr_title'),
            'ua' => $request->input('ua_title')
        ]);

        $tourDescription = TourDescription::create([
            'ru' => $request->input('ru_description'),
            'en' => $request->input('en_description'),
            'tr' => $request->input('tr_description'),
            'ua' => $request->input('ua_description')
        ]);

        $tour->title()->associate($tourTitle);
        $tour->description()->associate($tourDescription);
        $tour->region()->associate($region);
        $tour->manager()->associate($manager);
        $tour->type()->associate($tourType);
        $tour->price = $request->input('price');
        $tour->conducted_at = implode('~', $days);
        $tour->departure_time = $request->input('departure_time');
        $tour->check_out_time = $request->input('check_out_time');

        if ($request->has('duration')) {
            $tour->duration = $request->input('duration');
        }


        if (!$tour->save()) {
            throw new Exception(__('messages.tour-creation-failed'));
        }

        $tourImages = [];
        $i = 0;

        foreach ($request->file() as $file) {
            while (true) {
                $name = Str::random() . '.' . $file->extension();

                if (!Storage::exists('tour_pictures/' . $name)) {
                    break;
                }
            }

            $tourImages[] = new TourImage([
                'link' => $name,
                'is_main' => $i === 0 ? '1' : '0'
            ]);

            $i++;

            Image::make($file->get())
                ->save(storage_path('app/tour_pictures/' . $name), $file->getSize() > 1000000 ? 50 : 90);
        }

        $tour->images()->saveMany($tourImages);
        $tour->filters()->attach($filters);

        if (isset($additions)) {
            $tour->additions()->attach($additions);
        }

        return [
            'message' => __('messages.tour-created')
        ];
    }

    /**
     * Update tour (except images)
     *
     * @param TourRequest $request
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update(TourRequest $request, $id): array
    {
        $tour = Tour::with(['title', 'description', 'region', 'manager', 'type'])->find($id);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        // Filters validation
        $filters = json_decode($request->input('filters'));

        if (count($filters) === 0) {
            throw new Exception(__('messages.tour-filters-min'));
        }

        // Conducting days validation
        $days = json_decode($request->input('conducted_at'));

        if (count($days) === 0) {
            throw new Exception(__('messages.tour-conducted-at-min'));
        }

        // Title updating
        if ($tour->title->en !== $request->input('en_title')) {
            $tour->title->en = $request->input('en_title');
        }

        if ($tour->title->ru !== $request->input('ru_title')) {
            $tour->title->ru = $request->input('ru_title');
        }

        if ($tour->title->tr !== $request->input('tr_title')) {
            $tour->title->tr = $request->input('tr_title');
        }

        if ($tour->title->ua !== $request->input('ua_title')) {
            $tour->title->ua = $request->input('ua_title');
        }

        $tour->title->save();

        // Description updating
        if ($tour->description->en !== $request->input('en_description')) {
            $tour->description->en = $request->input('en_description');
        }

        if ($tour->description->ru !== $request->input('ru_description')) {
            $tour->description->ru = $request->input('ru_description');
        }

        if ($tour->description->tr !== $request->input('tr_description')) {
            $tour->description->tr = $request->input('tr_description');
        }

        if ($tour->description->ua !== $request->input('ua_description')) {
            $tour->description->ua = $request->input('ua_description');
        }

        $tour->description->save();

        // Manager updating
        if ($tour->manager->id !== $request->input('manager_id')) {
            $manager = User::managers()->find($request->input('manager_id'));

            if (!$manager) {
                throw new Exception(__('messages.manager-not-found'));
            }

            $tour->manager()->associate($manager);
        }

        // Region updating
        if ($tour->region->id !== $request->input('region_id')) {
            $region = Region::find($request->input('region_id'));

            if (!$region) {
                throw new Exception(__('messages.region-not-found'));
            }

            $tour->region()->associate($region);
        }

        // Tour type updating
        if ($tour->type->id !== $request->input('tour_type_id')) {
            $tourType = TourType::find($request->input('tour_type_id'));

            if (!$tourType) {
                throw new Exception(__('messages.tour-type-not-found'));
            }

            $tour->type()->associate($tourType);
        }

        // Filters updating
        $tour->filters()->sync($filters);

        // Other tour's fields updating
        if ($tour->conducted_at !== implode('~', json_decode($request->input('conducted_at')))) {
            $tour->conducted_at = implode('~', json_decode($request->input('conducted_at')));
        }

        if ($tour->price !== $request->input('price')) {
            $tour->price = $request->input('price');
        }

        if ($tour->getOriginal('duration') !== $request->input('duration')) {
            $tour->duration = $request->input('duration');
        }

        if ($request->has('additions')) {
            $additions = [];
            $parsedAdditions = json_decode($request->input('additions'));

            foreach ($parsedAdditions as $addition) {
                $additions[$addition->id] = [
                    'en_description' => $addition->en_description ?: null,
                    'ru_description' => $addition->ru_description ?: null,
                    'tr_description' => $addition->tr_description ?: null,
                    'ua_description' => $addition->ua_description ?: null,
                    'is_include' => $addition->is_include
                ];
            }

            $tour->additions()->sync($additions);
        } else {
            $tour->additions()->detach();
        }

        if ($request->has('departure_time')) {
            if (
                preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $request->input('departure_time')) !== 1 and
                $request->input('departure_time')
            ) {
                throw new Exception(__('messages.time-invalid'));
            }

            $tour->departure_time = $request->input('departure_time');
        }

        if ($request->has('check_out_time')) {
            if (
                preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $request->input('check_out_time')) !== 1 and
                $request->input('check_out_time')
            ) {
                throw new Exception(__('messages.time-invalid'));
            }

            $tour->check_out_time = $request->input('check_out_time');
        }

        if ($tour->save()) {
            return [
                'message' => __('messages.updating-success')
            ];
        } else {
            throw new Exception(__('messages.updating-failed'));
        }
    }

    /**
     * Delete tour
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        $tour = Tour::find($id);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        if ($tour->delete() !== true) {
            throw new Exception(__('messages.tour-deleting-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.tour-deleting-success')
        ];
    }

    /**
     * Change tour's main image
     *
     * @param Request $request
     * @param $tourId
     * @return array
     * @throws Exception
     */
    public function changeMainImage(Request $request, $tourId): array
    {
        if (!$request->has('image_id')) {
            throw new Exception(__('messages.specify-image-id'));
        }

        $tour = Tour::find($tourId);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        $image = TourImage::find($request->input('image_id'));

        if (!$image) {
            throw new Exception(__('messages.image-not-found'));
        }

        if (!$tour->images->contains($image)) {
            throw new Exception(__('messages.image-not-attached-to-tour'));
        }

        if ($image->isMain()) {
            throw new Exception(__('messages.tour-image-already-main'));
        }

        $prevMainImage = $tour->mainImage()[0];
        $prevMainImage->is_main = '0';

        $image->is_main = '1';

        if (!$prevMainImage->save() or !$image->save()) {
            throw new Exception(__('messages.updating-failed'));
        }

        return [
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Delete tour's image
     *
     * @param Request $request
     * @param $tourId
     * @return array
     * @throws Exception
     */
    public function deleteImage(Request $request, $tourId): array
    {
        if (!$request->has('image_id')) {
            throw new Exception(__('messages.specify-image-id'));
        }

        $tour = Tour::find($tourId);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        $image = TourImage::find($request->input('image_id'));

        if (!$image) {
            throw new Exception(__('messages.image-not-found'));
        }

        if (!$tour->images->contains($image)) {
            throw new Exception(__('messages.image-not-attached-to-tour'));
        }

        if ($image->isMain()) {
            throw new Exception(__('messages.cannot-delete-main-image'));
        }

        $image->delete();
        $imagePath = 'tour_pictures/' . $image->link;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        return [
            'message' => __('messages.tour-image-deleting-success')
        ];
    }

    /**
     * Attach image to a tour
     *
     * @param Request $request
     * @param $tourId
     * @return array
     * @throws Exception
     */
    public function uploadImage(Request $request, $tourId): array
    {
        $tour = Tour::find($tourId);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        if ($tour->images->count() > 5) {
            throw new Exception(__('messages.tour-can-have-max-five-images'));
        }

        // File validation
        $file = $request->file('image');

        if ($file->getSize() > 2000000) {
            throw new Exception(__('messages.max-uploaded-file-size'));
        }

        if (!in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
            throw new Exception(__('messages.allowed-file-extensions'));
        }

        if ($request->has('replace_image_id')) {
            // Edit existing image
            $image = TourImage::find($request->input('replace_image_id'));

            if (!$image) {
                throw new Exception(__('messages.image-not-found'));
            }

            $fileName = $image->link;
        } else {
            // Add a new image
            if ($tour->images->count() === 5) {
                throw new Exception(__('messages.tour-can-have-max-five-images'));
            }

            while (true) {
                $fileName = Str::random() . '.' . $file->extension();

                if (!Storage::exists('tour_pictures/' . $fileName)) {
                    break;
                }
            }

            $image = new TourImage(['link' => $fileName]);
            $tour->images()->save($image);
        }

        Image::make($file->get())
            ->save(storage_path('app/tour_pictures/' . $fileName), ($file->getSize() > 1000000 ? 50 : 90));

        return [
            'message' => __('messages.file-uploading-success')
        ];
    }

    /**
     * Get tours by title, filters, price, region and types
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function get(Request $request): array
    {
        $tours = Tour::with(['title', 'description', 'type', 'filters', 'images']);

        if ($request->has('filters')) {
            $filters = json_decode($request->input('filters'));

            if ($filters === null) {
                throw new Exception(__('messages.tour-filters-parse-error'));
            }

            $tours->whereHas('filters', function ($query) use ($filters) {
                $query->whereIn('id', $filters);
            });
        }

        if ($request->has('types')) {
            $types = json_decode($request->input('types'));

            if ($types === null) {
                throw new Exception(__('messages.tour-types-parse-error'));
            }

            $tours->whereIn('tour_type_id', $types);
        }

        if ($request->has('min_price')) {
            $tours->where('price', '>=', $request->input('min_price'));
        }

        if ($request->has('max_price')) {
            $tours->where('price', '<=', $request->input('max_price'));
        }

        if ($request->has('region_id')) {
            $tours->where('region_id', $request->input('region_id'));
        }

        if ($request->input('search_string')) {
            $searchString = preg_replace('/\s+/', '|', trim($request->input('search_string')));

            $tours->whereHas('title', function (Builder $query) use ($searchString) {
                $query->selectRaw(
                    'CHAR_LENGTH(REGEXP_REPLACE(REGEXP_REPLACE(LOWER(REPLACE(' . \App::getLocale() . ', \' \', \'\')), ?, \'~\', 1, 0, \'i\'), \'[^~]\', \'\')) as frequency',
                    [$searchString]
                )->having('frequency', '>', 0)->orderByDesc('frequency');
            });
        }

        $tours = $tours->offset($request->input('offset') ?? 0)->limit(15)->get();
        $user = Auth::check(['1']) ? Auth::user() : null;

        foreach ($tours as $tour) {
            $row = $tour->only(['id', 'price']);

            $row['title'] = $tour->title[\App::getLocale()];
            $row['description'] = Str::limit($tour->description[\App::getLocale()]);
            $row['duration'] = $tour->duration;
            $row['type'] = $tour->type->name;
            $row['is_favorite'] = '0';

            if ($user) {
                $row['is_favorite'] = $user->favoriteTours->contains($tour) ? '1' : '0';
            }

            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $row['image'] = route('get-image', [
                        'dir' => 'tour_pictures',
                        'file' => $image->link
                    ]);
                }
            }

            $response[] = $row;
        }

        return $response ?? [];
    }

    /**
     * Reserve a new tour
     *
     * @param TourReserveRequest $request
     * @param $tourId
     * @return array
     * @throws Exception
     */
    public function reserve(TourReserveRequest $request, $tourId): array
    {
        $tour = Tour::find($tourId);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        // Tickets validation
        $tickets = [];

        foreach (json_decode($request->input('tickets')) ?: [] as $item) {
            if (intval($item->amount ?? 0) === 0) {
                continue;
            }

            $ticket = Ticket::find($item->id);

            if (!$ticket) {
                throw new Exception(__('messages.ticket-not-found'));
            }

            $tickets[$ticket->id] = [
                'amount' => intval($item->amount),
                'percent_from_init_cost' => $ticket->getPercent()
            ];
        }

        if (count($tickets) === 0) {
            throw new Exception(__('messages.tickets-min'));
        }

        // Promo code validation
        $promoCode = null;

        if ($request->has('promo_code')) {
            $promoCode = PromoCode::where('code', $request->input('promo_code'))->get()->first();

            if (!$promoCode) {
                throw new Exception(__('messages.promo-code-not-found'));
            }
        }

        // Date validation
        if ($request->has('date')) {
            if (!$tour->isDateAvailable($request->input('date'))) {
                throw new Exception(__('messages.reservation->date-not-available'));
            }
        }

        // Total cost counting
        $totalCostWithoutSale = 0;

        foreach ($tickets as $ticket) {
            $totalCostWithoutSale += $ticket['amount'] * $ticket['percent_from_init_cost'] * $tour->price / 100;
        }

        // User validation
        if (Auth::check(['1'])) {
            $user = Auth::user();
        } else {
            if (!$request->has('email')) {
                throw new Exception(__('messages.user-email-required'));
            }

            if (!$request->has('phone')) {
                throw new Exception(__('messages.user-phone-required'));
            }

            $firstName = $request->input('first_name', 'Unnamed');
            $email = $request->input('email');
            $phone = substr($request->input('phone'), -10);
            $phoneCode = Str::before($request->input('phone'), $phone);

            $registrationResponse = Reg::reg($phone, $phoneCode, $email, $firstName);

            $user = $registrationResponse['user'];
            $accessCookies = $registrationResponse['cookies'];
        }

        $reservation = new Reservation([
            'tour_id' => $tourId,
            'user_id' => $user->id,
            'manager_id' => $tour->manager_id,
            'total_cost_without_sale' => $totalCostWithoutSale,
            'tour_init_price' => $tour->price
        ]);

        if ($promoCode) {
            $reservation->attachPromoCode($promoCode);
        }

        if ($request->has('region_id')) {
            /** @var Region|null $region */
            if (!$region = Region::find($request->input('region_id'))) {
                throw new Exception(__('messages.region-not-found'));
            }

            $reservation->region_id = $region->id;
        }

        $reservation->hotel_name = $request->input('hotel_name');
        $reservation->hotel_room_number = $request->input('hotel_room_number');
        $reservation->communication_type = $request->input('communication_type');
        $reservation->date = $request->input('date');

        if (!$reservation->save()) {
            throw new Exception(__('messages.reservation-creating-failed'));
        }

        $reservation->tickets()->attach($tickets);
        $response = [
            'status' => true,
            'message' => __('messages.reservation-creating-success')
        ];

        if (isset($accessCookies)) {
            $response['cookies'] = $accessCookies;
        }

        Mail::to($user->email)->send(new TourReserved(
            $tour, $reservation, $user
        ));

        return $response;
    }

    /**
     * Toggle tour at favorite
     *
     * @param $tourId
     * @return bool[]
     * @throws Exception
     */
    public function toggleFavorite($tourId): array
    {
        if (!Tour::find($tourId)) {
            throw new Exception(__('messages.tour-not-found'));
        }

        Auth::user()->favoriteTours()->toggle($tourId);

        return [
            'status' => true
        ];
    }
}
