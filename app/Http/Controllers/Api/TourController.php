<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TourRequest;
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
use Illuminate\Support\Str;

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
        $region = Region::find($request->input('region_id'));

        if (!$region) {
            throw new Exception(__('messages.region-not-found'));
        }

        $manager = User::managers()->find($request->input('manager_id'));

        if (!$manager) {
            throw new Exception(__('messages.manager-not-found'));
        }

        $tourType = TourType::find($request->input('tour_type_id'));

        if (!$tourType) {
            throw new Exception(__('messages.tour-type-not-found'));
        }

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
        $tour->date = $request->input('date');

        if(!$tour->save()) {
            throw new Exception(__('messages.tour-creation-failed'));
        }

        $tourImages = [];

        foreach ($request->file() as $index => $file) {
            $name = Str::random() . '.' . $file->extension();
            $tourImages[] = new TourImage([
                'link' => $name,
                'is_main' => $index === 0 ? '1' : '0'
            ]);

            $file->storeAs('tour_pictures', $name);
        }

        $tour->images()->saveMany($tourImages);

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
    public function update(TourRequest $request, $id)
    {
        $tour = Tour::with(['title', 'description', 'region', 'manager', 'type'])->find($id);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
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

        // Other tour's fields updating
        if ($tour->address !== $request->input('address')) {
            $tour->address = $request->input('address');
        }

        if ($tour->date !== $request->input('date')) {
            $tour->date = $request->input('date');
        }

        if ($tour->price !== $request->input('price')) {
            $tour->price = $request->input('price');
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
    public function changeMainImage(Request $request, $tourId)
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
    public function deleteImage(Request $request, $tourId)
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
    public function uploadImage(Request $request, $tourId)
    {
        $tour = Tour::find($tourId);

        if (!$tour) {
            throw new Exception(__('messages.tour-not-found'));
        }

        if ($tour->images->count() >= 5) {
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

            $file->storeAs('tour_pictures', $image->link);
        } else {
            // Add a new image
            while (true) {
                $fileName = Str::random() . '.' . $file->extension();

                if (!Storage::exists('tour_pictures/' . $fileName)) {
                    break;
                }
            }

            $image = new TourImage(['link' => $fileName]);
            $file->storeAs('tour_pictures', $fileName);
            $tour->images()->save($image);
        }

        return [
            'message' => __('messages.file-uploading-success')
        ];
    }
}
