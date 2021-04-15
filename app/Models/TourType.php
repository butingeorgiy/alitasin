<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourType extends Model
{
    public $timestamps = false;

    /**
     * Get type's name according app locale
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this[\App::getLocale() . '_name'];
    }
}
