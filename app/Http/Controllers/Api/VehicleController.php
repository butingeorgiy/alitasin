<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\VehicleRequest;
use App\Models\Region;
use App\Models\Vehicle;
use App\Models\VehicleImage;
use App\Models\VehicleType;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

            $tourImages[] = new VehicleImage([
                'image' => $name,
                'is_main' => $i === 0 ? '1' : '0'
            ]);

            $i++;

            Image::make($file->get())
                ->save(storage_path('app/vehicle_pictures/' . $name), $file->getSize() > 1000000 ? 50 : 90);
        }

        $vehicle->images()->saveMany($vehicleImages);

        return [
            'status' => true,
            'message' => 'ТС успешно сохранено!'
        ];
    }
}
