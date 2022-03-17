<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static VehicleType findOrFail(int|string|null $input)
 * @method static VehicleType find(int|string|null $input)
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

    public function getImageAttribute(): string
    {
        return route('get-image', [
            'dir' => 'vehicle_types',
            'file' => $this->getOriginal('image')
        ]);
    }
}
