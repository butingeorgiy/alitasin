<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $brand
 * @property string $model
 * @property string $show_at_index_page
 * @property int $cost
 */
class Vehicle extends Model
{
    public $timestamps = false;


    /**
     * Get vehicle's type
     *
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(VehicleType::class, 'type_id');
    }

    /**
     * Get vehicle's images
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(VehicleImage::class);
    }

    /**
     * Need to show at index page
     *
     * @return bool
     */
    public function isShowAtIndexPage(): bool
    {
        return $this->show_at_index_page === '1';
    }
}
