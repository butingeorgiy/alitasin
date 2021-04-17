<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TourRequest;
use App\Models\Filter;
use App\Models\Region;
use App\Models\Tour;
use App\Models\TourDescription;
use App\Models\TourImage;
use App\Models\TourTitle;
use App\Models\TourType;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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

        // Creating tour
        $tour = new Tour();

        $tourTitle = TourTitle::create([
            'ru' => $request->input('ru_title'),
            'en' => $request->input('en_title'),
            'tr' => $request->input('tr_title')
        ]);

        $tourDescription = TourDescription::create([
            'ru' => $request->input('ru_description'),
            'en' => $request->input('en_description'),
            'tr' => $request->input('tr_description')
        ]);

        $tour->title()->associate($tourTitle);
        $tour->description()->associate($tourDescription);
        $tour->region()->associate($region);
        $tour->manager()->associate($manager);
        $tour->type()->associate($tourType);
        $tour->address = $request->input('address');
        $tour->price = $request->input('price');
        $tour->conducted_at = implode('~', $days);

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
        if ($tour->address !== $request->input('address')) {
            $tour->address = $request->input('address');
        }

        if ($tour->conducted_at !== implode('~', json_decode($request->input('conducted_at')))) {
            $tour->conducted_at = implode('~', json_decode($request->input('conducted_at')));
        }

        if ($tour->price !== $request->input('price')) {
            $tour->price = $request->input('price');
        }

        if ($tour->getOriginal('duration') !== $request->input('duration')) {
            $tour->duration = $request->input('duration');
        }

        if ($tour->save()) {
            return [
                'message' => __('messages.updating-success')
            ];
        } else {
            throw new Exception(__('messages.updating-failed'));
        }
    }

    public function delete(Request $request, $id)
    {
        //
    }

    public function hide(Request $request, $id)
    {
        //
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

    public function get(Request $request)
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

        $tours = $tours->offset($request->input('offset') ?? 0)->limit(15)->get();

        foreach ($tours as $tour) {
            $row = $tour->only(['id', 'price']);

            $row['title'] = $tour->title[\App::getLocale()];
            $row['description'] = Str::limit($tour->description[\App::getLocale()]);
            $row['duration'] = $tour->duration;
            $row['type'] = $tour->type->name;

            foreach ($tour->images as $image) {
                if ($image->isMain()) {
                    $path = 'tour_pictures/' . $image->link;

                    if (Storage::exists($path)) {
                        $row['image'] = Storage::get($path);
                    }
                }
            }

            $response[] = $row;
        }

        return $response ?? [];
    }
}
