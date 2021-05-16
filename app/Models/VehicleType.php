<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static VehicleType findOrFail(int|string|null $input)
 */
class VehicleType extends Model
{
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
