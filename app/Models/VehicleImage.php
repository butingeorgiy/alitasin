<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string is_main
 * @property string image
 *
 * @mixin Builder
 */
class VehicleImage extends Model
{
    /**
     * @inheritdoc
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * @inheritdoc
     *
     * @var array
     */
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
