<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function get($dir, $file)
    {
        if (!\Storage::exists($dir . '/' .  $file)) {
            abort(404);
        }

        return Image::make(\Storage::get($dir . '/' .  $file))->response();
    }
}
