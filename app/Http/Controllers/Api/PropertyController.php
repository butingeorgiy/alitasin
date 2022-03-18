<?php

namespace App\Http\Controllers\Api;

use App\Models\CostUnit;
use App\Facades\Auth;
use App\Http\Requests\PropertyRequest;
use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyDescription;
use App\Models\PropertyImage;
use App\Models\PropertyOrder;
use App\Models\PropertyTitle;
use App\Models\PropertyType;
use App\Models\Region;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Throwable;
use Validator;

class PropertyController extends Controller
{
    /**
     * Create a new property.
     *
     * @param PropertyRequest $request
     * @return array
     * @throws Throwable
     */
    public function create(PropertyRequest $request): array
    {
        # Get related models

        $region = Region::find($request->input('region_id'));
        $type = PropertyType::find($request->input('type_id'));
        $costUnit = CostUnit::find($request->input('cost_unit_id'));

        # Images validation

        if (count($request->file()) === 0) {
            throw new Exception(__('messages.property-images-min-amount'));
        }

        if (count($request->file()) > 5) {
            throw new Exception(__('messages.property-images-max-amount'));
        }

        foreach ($request->file() as $file) {
            if ($file->getSize() > 2000000) {
                throw new Exception(__('messages.max-uploaded-file-size'));
            }

            if (!in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
                throw new Exception(__('messages.allowed-file-extensions'));
            }
        }

        # Params preparing for attaching

        $params = [];

        if ($request->has('params')) {
            foreach (json_decode($request->input('params')) as $param) {
                $params[$param->id] = [
                    'en_value' => $param->en_value,
                    'ru_value' => $param->ru_value,
                    'tr_value' => $param->tr_value,
                    'ua_value' => $param->ua_value,
                ];
            }
        }

        # Creating property

        $property = new Property([
            'cost' => $request->input('cost')
        ]);

        DB::transaction(function () use ($request, $property, $region, $type, $params, $costUnit) {
            $title = PropertyTitle::create([
                'ru' => $request->input('ru_title'),
                'en' => $request->input('en_title'),
                'tr' => $request->input('tr_title'),
                'ua' => $request->input('ua_title')
            ]);

            $description = PropertyDescription::create([
                'ru' => $request->input('ru_description'),
                'en' => $request->input('en_description'),
                'tr' => $request->input('tr_description'),
                'ua' => $request->input('ua_description')
            ]);

            $property->title()->associate($title);
            $property->description()->associate($description);
            $property->region()->associate($region);
            $property->type()->associate($type);
            $property->unit()->associate($costUnit);

            if (!$property->save()) {
                throw new Exception(__('messages.property-creating-failed'));
            }

            # Image attaching

            $images = [];
            $i = 0;

            foreach ($request->file() ?: [] as $file) {
                while (true) {
                    $name = Str::random() . '.' . $file->extension();

                    if (!Storage::exists('property_pictures/' . $name)) {
                        break;
                    }
                }

                $images[] = new PropertyImage([
                    'image' => $name,
                    'is_main' => $i === 0 ? '1' : '0'
                ]);

                $i++;

                Image::make($file->get())
                    ->save(storage_path('app/property_pictures/' . $name));
            }

            $property->images()->saveMany($images);
            $property->params()->attach($params);
        });

        return [
            'message' => __('messages.property-creating-success')
        ];
    }

    /**
     * Update property.
     *
     * @param PropertyRequest $request
     * @param $id
     * @return array
     * @throws Throwable
     */
    public function update(PropertyRequest $request, $id): array
    {
        if (!$property = Property::with(['title', 'description', 'type', 'region', 'unit'])->find($id)) {
            throw new Exception(__('messages.property-not-found'));
        }

        DB::transaction(function () use ($request, $property) {
            $property->updateTitle(
                $request->input('en_title'),
                $request->input('ru_title'),
                $request->input('tr_title'),
                $request->input('ua_title')
            );

            $property->updateDescription(
                $request->input('en_description'),
                $request->input('ru_description'),
                $request->input('tr_description'),
                $request->input('ua_description')
            );

            $property->syncParams(json_decode($request->input('params', '[]')));

            # Type updating
            if ($property->type_id !== $request->input('type_id')) {
                $property->type_id = $request->input('type_id');
            }

            # Region updating
            if ($property->region_id !== $request->input('region_id')) {
                $property->region_id = $request->input('region_id');
            }

            # Cost unit updating
            if ($property->cost_unit_id !== $request->input('cost_unit_id')) {
                $property->cost_unit_id = $request->input('cost_unit_id');
            }

            # Cost updating
            if ($property->cost !== $request->input('cost')) {
                $property->cost = $request->input('cost');
            }

            if (!$property->save()) {
                throw new Exception(__('messages.updating-failed'));
            }
        });

        return [
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Delete property by soft-deleting.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        if (!$property = Property::find($id)) {
            throw new Exception(__('messages.property-not-found'));
        }

        if (!$property->delete()) {
            throw new Exception(__('messages.property-deleting-failed'));
        }

        return [
            'message' => __('messages.property-deleting-success')
        ];
    }

    /**
     * Restore property.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function restore($id): array
    {
        if (!$property = Property::withTrashed()->find($id)) {
            throw new Exception(__('messages.property-not-found'));
        }

        if (!$property->restore()) {
            throw new Exception(__('messages.property-restoring-failed'));
        }

        return [
            'message' => __('messages.property-restoring-success')
        ];
    }

    /**
     * Change property's main image.
     *
     * @param Request $request
     * @param $propertyId
     * @return array
     * @throws Exception
     */
    public function changeMainImage(Request $request, $propertyId): array
    {
        if (!$request->has('image_id')) {
            throw new Exception(__('messages.specify-image-id'));
        }

        if (!$property = Property::find($propertyId)) {
            throw new Exception(__('messages.property-not-found'));
        }

        /** @var PropertyImage $image */
        if (!$image = PropertyImage::find($request->input('image_id'))) {
            throw new Exception(__('messages.image-not-found'));
        }

        if (!$property->images->contains($image)) {
            throw new Exception(__('messages.image-not-attached-to-property'));
        }

        if ($image->isMain()) {
            throw new Exception(__('messages.image-already-main'));
        }

        /** @var PropertyImage $prevMainImage */
        $prevMainImage = $property->mainImage();
        $prevMainImage->is_main = '0';

        $image->is_main = '1';

        if (!$prevMainImage->save() || !$image->save()) {
            throw new Exception(__('messages.updating-failed'));
        }

        return [
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Upload property image.
     *
     * @param Request $request
     * @param $propertyId
     * @return array
     * @throws Exception
     */
    public function uploadImage(Request $request, $propertyId): array
    {
        if (!$property = Property::find($propertyId)) {
            throw new Exception(__('messages.property-not-found'));
        }

        if ($property->images()->count() > 5) {
            throw new Exception(__('messages.property-max-images-amount'));
        }

        # File validation

        if (!$file = $request->file('image')) {
            throw new Exception(__('messages.file-not-sent'));
        }

        if ($file->getSize() > 2000000) {
            throw new Exception(__('messages.max-uploaded-file-size'));
        }

        if (!in_array($file->extension(), ['jpg', 'jpeg', 'png'])) {
            throw new Exception(__('messages.allowed-file-extensions'));
        }

        if ($request->has('replace_image_id')) { # Edit existed image
            if (!$image = PropertyImage::find($request->input('replace_image_id'))) {
                throw new Exception(__('messages.image-not-found'));
            }

            $fileName = $image->image;
        } else { # Add a new image
            if ($property->images()->count() > 5) {
                throw new Exception(__('messages.property-max-images-amount'));
            }

            # Generate file name for new image

            while (true) {
                $fileName = Str::random() . '.' . $file->extension();

                if (!Storage::exists('property_pictures/' . $fileName)) {
                    break;
                }
            }

            $property->images()->save(new PropertyImage(['image' => $fileName]));
        }

        Image::make($file->get())
            ->save(storage_path('app/property_pictures/' . $fileName), ($file->getSize() > 1000000 ? 50 : 90));

        return [
            'message' => __('messages.file-uploading-success')
        ];
    }

    /**
     * Delete property image.
     *
     * @param Request $request
     * @param $propertyId
     * @return array
     * @throws Exception
     */
    public function deleteImage(Request $request, $propertyId): array
    {
        if (!$request->has('image_id')) {
            throw new Exception(__('messages.specify-image-id'));
        }

        if (!$property = Property::find($propertyId)) {
            throw new Exception(__('messages.property-not-found'));
        }

        if (!$image = PropertyImage::find($request->input('image_id'))) {
            throw new Exception(__('messages.image-not-found'));
        }

        if (!$property->images->contains($image)) {
            throw new Exception(__('messages.image-not-attached-to-property'));
        }

        if ($image->isMain()) {
            throw new Exception(__('messages.cannot-delete-main-image'));
        }

        $image->delete();
        $imagePath = 'property_pictures/' . $image->image;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        return [
            'message' => __('messages.image-deleting-success')
        ];
    }

    /**
     * Create order for property.
     *
     * @param Request $request
     * @param $propertyId
     * @return array
     * @throws Exception
     */
    public function order(Request $request, $propertyId): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_name' => 'bail|required|string|min:2|max:32',
                'user_phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/']
            ],
            [
                'user_name.required' => __('messages.user-first-name-required'),
                'user_name.min' => __('messages.user-first-name-min'),
                'user_name.max' => __('messages.user-first-name-max'),
                'user_phone.required' => __('messages.user-phone-required'),
                'user_phone.regex' => __('messages.user-phone-regex')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$property = Property::find($propertyId)) {
            throw new Exception(__('messages.property-not-found'));
        }

        if (Auth::check([1])) {
            $user = Auth::user();
        }

        PropertyOrder::create([
            'user_id' => isset($user) ? $user->id : null,
            'user_name' => $request->input('user_name'),
            'user_phone' => $request->input('user_phone'),
            'property_id' => $property->id
        ]);

        # TODO: mail and telegram bot notifications

        return [
            'message' =>  __('messages.request-sending-success')
        ];
    }
}
