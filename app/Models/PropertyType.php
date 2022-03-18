<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 *
 * @mixin Builder
 */
class PropertyType extends Model
{
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
