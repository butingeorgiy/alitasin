<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function get(Request $request, $fileName)
    {
        $directory = '';
        $entity = $request->input('entity');

        switch ($entity) {
            case 'tour':
                $directory = 'tour_pictures/';
                break;
            case 'region':
                $directory = 'region_pictures/';
                break;
            case 'vehicle':
                $directory = 'vehicle_pictures/';
                break;
            default:
                abort(404);
        }

        $filePath = $directory . $fileName;

        if (!\Storage::exists($filePath)) {
            abort(404);
        }

        return Image::make(\Storage::get($filePath))->response();
    }
}
