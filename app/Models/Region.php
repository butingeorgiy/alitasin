<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(array|string|null $input)
 * @method static where(string|array|\Closure $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static findOrFail($id)
 * @property int id
 * @property string $name
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
