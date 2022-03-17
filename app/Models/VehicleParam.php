<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleParam extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    /**
     * Get name
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this[\App::getLocale() . '_name'];
    }
}
