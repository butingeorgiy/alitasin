<?php

namespace App\Http\Controllers\Api;

use App\Facades\Auth;
use App\Http\Requests\VehicleRequest;
use App\Models\Region;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\VehicleType;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VehicleController extends Controller
{
    /**
     * Create a new vehicle
     *
     * @param VehicleRequest $request
     * @return array
     * @throws Exception
     */
    public function create(VehicleRequest $request): array
    {
        if (!Region::find($request->input('region_id'))) {
            throw new Exception(__('messages.region-not-found'));
        }

        if (!VehicleType::find($request->input('vehicle_type_id'))) {
            throw new Exception('Неизвестный тип ТС!');
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


        // Parameters attaching

        if ($request->has('params')) {
            $params = [];
            $parsedParams = json_decode($request->input('params'));

            foreach ($parsedParams as $param) {
                $params[$param->id] = [
                    'en_value' => $param->en_value,
                    'ru_value' => $param->ru_value,
                    'tr_value' => $param->tr_value
                ];
            }
        }


        // Vehicle creating
        $vehicle = new Vehicle([
            'brand' => $request->input('brand'),
            'model' => $request->input('model'),
            'show_at_index_page' => $request->input('show_at_index_page'),
            'cost' => $request->input('cost'),
            'type_id' => $request->input('vehicle_type_id'),
            'region_id' => $request->input('region_id')
        ]);

        $vehicle->save();


        // Images attaching

        $vehicleImages = [];
        $i = 0;

        foreach ($request->file() as $file) {
            while (true) {
                $name = Str::random(14) . '.' . $file->extension();

                if (!Storage::exists('vehicle_pictures/' . $name)) {
                    break;
                }
            }

            $vehicleImages[] = new VehicleImage([
                'image' => $name,
                'is_main' => $i === 0 ? '1' : '0'
            ]);

            $i++;

            Image::make($file->get())
                ->save(storage_path('app/vehicle_pictures/' . $name), $file->getSize() > 1000000 ? 50 : 90);
        }

        $vehicle->images()->saveMany($vehicleImages);

        if (isset($params)) {
            $vehicle->params()->attach($params);
        }

        return [
            'status' => true,
            'message' => 'ТС успешно сохранено!'
        ];
    }

    /**
     * Update vehicle.
     *
     * @param VehicleRequest $request
     * @param $id
     * @return array
     * @throws Exception
     */
    public function update(VehicleRequest $request, $id): array
    {
        if (!$vehicle = Vehicle::withTrashed()->with(['type', 'region', 'params'])->find($id)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if ($vehicle->brand !== $request->input('brand')) {
            $vehicle->brand = $request->input('brand');
        }

        if ($vehicle->model !== $request->input('model')) {
            $vehicle->model = $request->input('model');
        }

        if ($vehicle->show_at_index_page !== $request->input('show_at_index_page')) {
            $vehicle->show_at_index_page = $request->input('show_at_index_page');
        }

        if ($vehicle->cost !== $request->input('cost')) {
            $vehicle->cost = $request->input('cost');
        }

        // Vehicle type updating
        if ($vehicle->type->id !== $request->input('vehicle_type_id')) {
            if (!$type = VehicleType::find($request->input('vehicle_type_id'))) {
                throw new Exception(__('messages.vehicle-type-not-found'));
            }

            $vehicle->type()->associate($type);
        }

        // Vehicle region updating
        if ($vehicle->region->id !== $request->input('region_id')) {
            if (!$region = Region::find($request->input('region_id'))) {
                throw new Exception(__('messages.region-not-found'));
            }

            $vehicle->region()->associate($region);
        }

        // Params updating
        if ($request->has('params')) {
            $parsedParams = json_decode($request->input('params', '[]'));

            if (count($parsedParams) > 0) {
                $params = [];

                foreach ($parsedParams as $param) {
                    $params[$param->id] = [
                        'en_value' => $param->en_value,
                        'ru_value' => $param->ru_value,
                        'tr_value' => $param->tr_value,
                        'ua_value' => $param->ua_value
                    ];
                }

                $vehicle->params()->sync($params);
            } else {
                $vehicle->params()->detach();
            }
        } else {
            $vehicle->params()->detach();
        }

        if ($vehicle->save()) {
            return [
                'message' => __('messages.updating-success')
            ];
        } else {
            throw new Exception(__('messages.updating-failed'));
        }
    }

    /**
     * Order vehicle
     *
     * @param Request $request
     * @param $id
     * @return bool[]
     * @throws Exception
     */
    public function order(Request $request, $id): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_name' => 'bail|required|string|min:2|max:32',
                'user_phone' => ['bail', 'required', 'regex:/^(\d{1,4})(\d{3})(\d{3})(\d{4})$/'],
                'location_region' => 'bail|required|string|min:2|max:128'
            ],
            [
                'user_name.required' => __('messages.user-first-name-required'),
                'user_name.min' => __('messages.user-first-name-min'),
                'user_name.max' => __('messages.user-first-name-max'),
                'user_phone.required' => __('messages.user-phone-required'),
                'user_phone.regex' => __('messages.user-phone-regex'),
                'location_region.required' => __('messages.region-required'),
                'location_region.min' => __('messages.region-name-min'),
                'location_region.max' => __('messages.region-name-max')
            ]
        );

        if ($validator->fails()) {
            throw new Exception($validator->errors()->first());
        }

        if (!$vehicle = Vehicle::find($id)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if (Auth::check([1])) {
            $user = Auth::user();
        }

        $vehicle->orders()->create([
            'user_name' => $request->input('user_name'),
            'user_phone' => $request->input('user_phone'),
            'user_id' => isset($user) ? $user->id : null,
            'location_region' => $request->input('location_region')
        ]);

        return [
            'status' => true,
            'message' => __('messages.request-sending-success')
        ];
    }

    /**
     * Delete vehicle.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function delete($id): array
    {
        if (!$vehicle = Vehicle::find($id)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if (!$vehicle->delete()) {
            throw new Exception(__('messages.vehicle-deleting-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.vehicle-deleting-success')
        ];
    }

    /**
     * Restore vehicle.
     *
     * @param $id
     * @return array
     * @throws Exception
     */
    public function restore($id): array
    {
        if (!$vehicle = Vehicle::withTrashed()->find($id)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if (!$vehicle->restore()) {
            throw new Exception(__('messages.vehicle-restoring-failed'));
        }

        return [
            'status' => true,
            'message' => __('messages.vehicle-restoring-success')
        ];
    }

    /**
     * Change vehicle's main image.
     *
     * @param Request $request
     * @param $vehicleId
     * @return array
     * @throws Exception
     */
    public function changeMainImage(Request $request, $vehicleId): array
    {
        if (!$request->has('image_id')) {
            throw new Exception(__('messages.specify-image-id'));
        }

        if (!$vehicle = Vehicle::withTrashed()->find($vehicleId)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if (!$image = VehicleImage::find($request->input('image_id'))) {
            throw new Exception(__('messages.image-not-found'));
        }

        if (!$vehicle->images->contains($image)) {
            throw new Exception(__('messages.image-not-attached'));
        }

        if ($image->isMain()) {
            throw new Exception(__('messages.image-already-main'));
        }

        /** @var VehicleImage $prevMainImage */
        $prevMainImage = $vehicle->mainImage();
        $prevMainImage->is_main = '0';

        $image->is_main = '1';

        if (!$prevMainImage->save() || !$image->save()) {
            throw new Exception(__('messages.updating-success'));
        }

        return [
            'message' => __('messages.updating-success')
        ];
    }

    /**
     * Delete vehicle's images.
     *
     * @param Request $request
     * @param $vehicleId
     * @return array
     * @throws Exception
     */
    public function deleteImage(Request $request, $vehicleId): array
    {
        if (!$request->has('image_id')) {
            throw new Exception(__('messages.specify-image-id'));
        }

        if (!$vehicle = Vehicle::withTrashed()->find($vehicleId)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if (!$image = VehicleImage::find($request->input('image_id'))) {
            throw new Exception(__('messages.image-not-found'));
        }

        if (!$vehicle->images->contains($image)) {
            throw new Exception(__('messages.image-not-attached'));
        }

        if ($image->isMain()) {
            throw new Exception(__('messages.cannot-delete-main-image'));
        }

        $image->delete();
        $imagePath = 'vehicle_pictures/' . $image->image;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        return [
            'message' => __('messages.tour-image-deleting-success')
        ];
    }

    /**
     * Update or upload vehicle image.
     *
     * @param Request $request
     * @param $vehicleId
     * @return array
     * @throws FileNotFoundException
     * @throws Exception
     */
    public function updateImage(Request $request, $vehicleId): array
    {
        if (!$vehicle = Vehicle::withTrashed()->find($vehicleId)) {
            throw new Exception(__('messages.vehicle-not-found'));
        }

        if ($vehicle->images->count() > 5) {
            throw new Exception(__('messages.vehicle-can-have-max-five-images'));
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
            if (!$image = VehicleImage::find($request->input('replace_image_id'))) {
                throw new Exception(__('messages.image-not-found'));
            }

            $fileName = $image->image;
        } else {
            // Add a new image
            if ($vehicle->images->count() === 5) {
                throw new Exception(__('messages.vehicle-can-have-max-five-images'));
            }

            while (true) {
                $fileName = Str::random() . '.' . $file->extension();

                if (!Storage::exists('vehicle_pictures/' . $fileName)) {
                    break;
                }
            }

            $image = new VehicleImage(['image' => $fileName]);
            $vehicle->images()->save($image);
        }

        Image::make($file->get())
            ->save(storage_path('app/vehicle_pictures/' . $fileName), ($file->getSize() > 1000000 ? 50 : 90));

        return [
            'message' => __('messages.file-uploading-success')
        ];
    }
}
