<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class VehicleParam extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    # Other methods

    /**
     * Get type name by current locale.
     *
     * @return string
     */
    public function getLocaleName(): string
    {
        return $this[App::getLocale() . '_name'];
    }
}
