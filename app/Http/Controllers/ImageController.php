<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    /**
     * @throws FileNotFoundException
     */
    public function get($dir, $file)
    {
        if (!\Storage::exists($dir . '/' .  $file)) {
            abort(404);
        }

        return Image::make(\Storage::get($dir . '/' .  $file))->response();
    }
}
