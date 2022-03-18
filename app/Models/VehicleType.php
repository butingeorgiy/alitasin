<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string en_name
 * @property string ru_name
 * @property string tr_name
 * @property string ua_name
 * @property string|null image
 *
 * @mixin Builder
 */
class VehicleType extends Model
{
    /**
     * Interact with `name` property.
     *
     * @return Attribute
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (): ?string => $this[app()->getLocale() . '_name']
        );
    }

    /**
     * Interact with `image` property.
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value): string => asset('storage/vehicle_types/' . $value)
        );
    }
}
