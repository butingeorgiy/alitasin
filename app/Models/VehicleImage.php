<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string is_main
 * @property string image
 */
class VehicleImage extends Model
{
    public $timestamps = false;

    protected $guarded = [];


    /**
     * Check if image is main
     *
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->is_main === '1';
    }
}
