<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourImage extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Checks if the main image is
     *
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->is_main === '1';
    }
}
