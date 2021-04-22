<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(array|string|null $input)
 */
class TourImage extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    /**
     * Checks if the main image is
     *
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->is_main === '1';
    }
}
