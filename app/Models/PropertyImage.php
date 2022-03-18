<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string image
 * @property string is_main
 *
 * @mixin Builder
 */
class PropertyImage extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    # Other methods

    /**
     * Get link for image.
     *
     * @return string
     */
    public function getAssetLink(): string
    {
        return asset('storage/property_pictures/' . $this->image);
    }

    /**
     * If image is main.
     *
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->is_main === '1';
    }
}
