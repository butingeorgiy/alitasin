<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(array|string|null $input)
 */
class Region extends Model
{
    public $timestamps = false;

    /**
     * Get region's name according app locale
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this[\App::getLocale() . '_name'];
    }
}
