<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TransferType extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $appends = ['name'];


    /**
     * Get localized name
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this[App::getLocale() . '_name'];
    }
}
