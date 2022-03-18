<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string name
 *
 * @mixin Builder
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
        return $this[app()->getLocale() . '_name'];
    }
}
