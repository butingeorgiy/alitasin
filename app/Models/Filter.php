<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public $timestamps = false;

    /**
     * Get filter's name according app locale
     *
     * @return mixed
     */
    public function getNameAttribute()
    {
        return $this[\App::getLocale() . '_name'];
    }
}
